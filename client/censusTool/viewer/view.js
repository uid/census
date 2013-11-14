$(document).ready( function() {
	localLogURL = "fetchRequests.php";
	resultsURL = "https://census.stanford.edu/censusServer/fetchResults.php";
	// Call local PHP query to get info from database about logged tasks
	$.ajax( {
		url: localLogURL,
		dataType: 'text',
		success: function(data) {
			//
			contentAry = data.split(',');
			//alert(contentAry);

			for( i = 0; i < contentAry.length; i++ ) {
				requesterId = "";
				workerId = "";
				assignmentId = "";
				hitId = contentAry[i];
			
			
				// Make remote call to get CSV of demographic results from the trials run by this server
				$.ajax({
					//url: resultsURL + '?workerId=' + workerId + '&assignmentId=' + assignmentId + '&hitId=' + hitId + '&requesterId=' + requesterId,
					url: resultsURL + '?hitId=' + hitId,
					dataType: 'text',
					success: function(data) {
						//
						resultsAry = data.split('\n');
						for( i = 0; i < resultsAry.length; i++ ) {
							$("#container").append(resultsAry[i] + "<BR/>");
						}
						$("#container").append("<BR/> ___ <BR/>");
					}
				});
			}
		}
	});

});
