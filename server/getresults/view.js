$(document).ready( function() {
	localLogURL = "fetchRequests.php";
	resultsURL = "https://census.stanford.edu/censusServer/fetchResults.php";

	$('#dataField').hide();

	// Call local PHP query to get info from database about logged tasks
	$('#getBtn').click( function() {
		$.ajax( {
			url: localLogURL,
			type: "POST",
			dataType: 'text',
			data: {'key': $('#key-field').val().trim(), 'pwd': $('#pass-field').val().trim()},
			success: function(data) {
				if( data == "Invalid-Password") {
					alert("Password is not valid. Please try again.");
				}
	
				$('#dataField-val').html(data.replace(/[\n\r]/g, "<BR/>"));
				$('#dataField').show(500);
	
			}
		});
	});



});
