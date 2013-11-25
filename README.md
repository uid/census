#Mechanical Turk Census

Census allows you to post tasks on Mechanical Turk and then assess the demographics and
cognitive skill of the workers that do your tasks.
We attach an additional, extremely short question for the worker to answer once they have
completed your task. The results of these additional census questions regarding the workers
answering your questions are aggregated and provided for you to view through our webpage:
(COMING SOON). The results of your original task are not affected nor stored by us.


#Instructions to Use

1. Pull the `/client` folder off GitHub. 

2. Make sure that you've included `census.js` (in the `/client` folder) as well as jQuery in your HIT:
> ```
<script src="census.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
```

3. Add the census call to your task as follows:

	* Call `census.submit( '#questionDiv', '#taskForm', 'unique_key' );` when your task is ready to submit
		* `#questionDiv` is the empty `<div>` where the census question will be posted 
	 	* `#taskForm` is your `<form>` element for your HIT --- whatever you want submitted to MTurk.
	 	* `unique_key` is the secret key that Census gives you, and that you can use to find the census results for your HIT later (COMING SOON)
	* The following is demo code that you can use in your HIT. Only `census.submit()` is required, but the rest may be helpful. This code intercepts the original form submission, disables the original form submission button, and calls `census.submit()` to retrieve a Census task, display it and then submit the HIT:


> ```
$(document).ready(function()  // Called when the HIT is loaded
{
	$("#submitBtn").click( function()  // When submit button is pressed for your original form on the HIT
	{
    		event.preventDefault();  // Prevents default response of submitting the form
    		$('#submitBtn').prop('disabled', 'true');  // Disables original submit button so the worker doesn't click it again
    		census.submit( '#questionDiv', '#taskForm' );  // Summon Census! Requests a task from the census server, displays it, and then submits your original task when the worker submits the Census task
	});
});
```

	
* DO NOT call `census.submit()` until you’re ready for your task to be submitted to MTurk (as the form will be submitted to MTurk as-is once the census task is complete).


# About Us

We are a group of researchers at Stanford, MIT, U. Rochester, CMU, U. Michigan, UT Austin,
and elsewhere trying to learn more about the demographic and cognitive information regarding
the workers on Amazon's Mechanical Turks.


