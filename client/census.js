/**
 * Census: collecting demographics for Mechanical Turk
 * --------
 * Michael Bernstein (msb@cs.stanford.edu)
 * Juho Kim (juhokim@mit.edu)
 * Walter Lasecki (wlasecki@cs.rochester.edu)
 * CrowdCamp 2013
 *
 *
 * Usage: 
 * 1) Include jQuery and Census.js in your MTurk HIT's HTML.
 * 2) Add a div where census can display a demographic or benchmark task to the HTML.
 * 3) Register a listener so that when the worker tries to submit the work, 
 * you call census.submit(your_task_json_data, '#div-id-for-question-insertion').
 */

if (typeof console == 'undefined') {
	console = { log: function() {},
				debug: function() {} };
}

if (typeof jQuery == 'undefined') {
	console.log("jQuery is required to use Census. Please include jQuery in your HIT page source: jquery.org");
}


(function( window, undefined ) {
	census = {};
	census.DEBUG = false;
	census.requestCensusURL = 'http://roc.cs.rochester.edu/census/issue_task.php';
	census.submitCensusURL = 'http://roc.cs.rochester.edu/census/submit_task.php';

	census._taskJSON = null;	

	/**
	 * When the worker tries to submit the HIT, call this function to request
	 * and display the Census task
	 */
	census.submit = function( taskJSON, questionDiv ) {
		this._taskJSON = taskJSON;
		if (Object.prototype.toString.call(taskJSON) === '[object Array]') {
			console.log("Please send a JSON object to census.submit()");
			return;
		}

		// Have they sent all the relevant MTurk IDs?
		var requiredFields = ["requesterId", "workerId", "hitId", "assignmentId"];
		for (var i=0; i<requiredFields.length; i++) {
			if(!this._taskJSON.hasOwnProperty(requiredFields[i])) {
				console.log("Error: please include " + requiredFields[i] + " in the task JSON");
				return;
			}
		};


		console.log(this._taskJSON);
		this._requestCensusTask($('#questionDiv'), 'requesterId', 'workerId', 'hitId', 'assignmentId');
	};

	/**
	 * Makes an AJAX call to the Census server to retrieve a task. Displays the task in
	 * questionDiv.
	 */
	census._requestCensusTask = function(questionDiv, requesterId, workerId, hitId, assignmentId) {
		if (census.DEBUG) {
			var question = "<div><div>In metric tons, how much wood would a woodchuck chuck if a woodchuck could chuck Woody Allen?</div>" +
				"<div><input type='text' name='woodchuck'></input></div></div>";
			census._insertCensusQuestion(question);
		} else {
			$.ajax( {
				url: census.requestCensusURL + '?workerId=' + workerId + '&assignmentId=' + assignmentId + '&hitId=' + hitId + '&requesterId=' + requesterId,
				dataType: 'jsonp',
				success: function(data) {
					console.log(data);
					if (data['success'] == 'false') {
						console.log("No Census task currently, or failure. Submitting original task.");
						census._submitTask();
					}

					census._insertCensusQuestion(data['data']);
				}, 
				error: function(data) {
					console.log("AJAX call to Census server failed");
				}
			});
		}
	};

	census._insertCensusQuestion = function(question) {
		var css = "<style type='text/css'>#censusForm { border: 1px solid darkGray; border-radius: 10px; margin-top: 20px; padding: 10px; } #censusForm .censusTitle { font-size: 20pt; color: #8A1946; } </style>";
		var wrapped = $(css + "<form id='censusForm'>" +
			"<div><div class='censusTitle'>Mechanical Turk Census</div>" +
			question + 
			"<input type='submit'></input></form>");

		$(questionDiv).append(wrapped);

		$("#censusForm").on("submit", function(event){
    		event.preventDefault();
    		var response = $('#censusForm').serializeArray();
    		census._submitCensusResponse(response);
		});		
	}

	/**
	 * Submits the Census question response back to the server, then submits the HIT
	 */
	census._submitCensusResponse = function(response) {
		if (census.DEBUG) {
			census._submitTask();
		} else {
			// AJAX call to census server
			$.post(submitCensusURL, response, function(data) {
				console.log("AJAX request to Census server succeeded");
				// Now that the AJAX call has returned, we can safely submit the HIT
				census._submitTask();
			}, 
			function(data) {
				// failure handler
				// eventually we want to submit the HIT form anyway
				// for now, break out and tell the user about the error
				console.log("AJAX request to Census server failed");
			});
		}
	};

	/**
	 * Submits the original HIT to Mechanical Turk
	 */
	census._submitTask = function() {
		var hiddenForm = $("<form id='censusMturkSubmit' action='http://www.mturk.com/mturk/externalSubmit'></form>");
		$.each(census._taskJSON, function(index, value) {
			hiddenForm.append("<input type='hidden' name='" + index + "' value='" + value + "'></input>");
		});
		$('body').append(hiddenForm);
		hiddenForm.submit();
	}
}(this));