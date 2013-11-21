$(document).ready( function() {
	keyURL = "newKey.php";

	$('#key-val').hide();

	$('#genBtn').click( function() {
		// Call local PHP query to get info from database about logged tasks
		$.ajax( {
			url: keyURL,
			dataType: 'text',
			success: function(data) {
				// Show the key
				$('#key-val').html(data);
				$('#key-val').show('fast');
			}
		});
	});

});
