$(document).ready( function() {
	localLogURL = "fetchRequests.php";
	resultsURL = "https://census.stanford.edu/censusServer/fetchResults.php";

	// Call local PHP query to get info from database about logged tasks
	$('#getBtn').click( function() {
		$.ajax( {
			url: localLogURL,
			type: "POST",
			dataType: 'text',
			data: {'key': $('#key-field').val(), 'pwd': $('#pass-field').val()},
			success: function(data) {
				if( data == "Invalid-Password") {
					alert("Password is not valid. Please try again.");
				}
	
				$('#respData').html(data);
	
			}
		});
	});



});
