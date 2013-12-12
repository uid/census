$(document).ready( function() {
	keyURL = "newKey.php";

	$('#confirmPass').hide();
	$('#key').hide();

	$('#pass-field').keyup( function(e) {
		if( $('#pass-field').val() == "" ) {
			$('#confirmPass').hide(500);
		}
		else {
			$('#confirmPass').show(500);
		}
	});


	$('#genBtn').click( function() {
		if( !$('#confirmPass').is(":visible") || ($('#pass-field').val() == $('#confirmPass-field').val()) ) {
			// Call local PHP query to get info from database about logged tasks
			$.ajax( {
				url: keyURL,
				type: "POST",
				dataType: 'text',
				data: {'pwd': $('#passField').val()},
				success: function(data) {
					$('#pass').addClass('disabled');
					$('#pass-field').attr('disabled', 'disabled');
					$('#confirmPass').addClass('disabled');
					$('#confirmPass-field').attr('disabled', 'disabled');

					// Show the key
					$('#key-val').html(data);
					$('#key').show('fast');
				}
			});
		}
		else {
			alert("Passwords do not match!");
		}
	});

});
