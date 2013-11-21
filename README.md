#Census

We are a group of researchers at Stanford, MIT, U. Rochester, U. Michigan, UT Austin, and elsewhere trying to learn more about the demographic and cognitive information regarding the workers on Amazon's Mechanical Turks. Our package allows you to post tasks on Mechanical Turks and then assess the demographic and cognitive skills for the workers that do your tasks. 



#Brief Overview - How It Works

We attach an additional, extremely short question for the worker to answer once they have completed your task. The results of these additional census questions regarding the workers answering your questions are aggregated and provided for you to view through our webpage: (ENTER LATER). The results of your original task are not affected nor stored by us.


#Instructions to Use

1. Pull the /censusTool folder off the server. 

2. In your main task file, make a call to census as follows:

	* - Call census.submit( '#questionDiv', '#taskForm' ); when your task is ready to submit
		* - #questionDiv is the empty ` <div> ` where the census question will be posted 
	 	* - #taskForm is the ` <form> ` element that will be submitted to MTurk. 
	* - The following is the code containing the aforementioned census.submit( '#questionDiv', '#taskForm' ) call that needs to be inserted into your maintask file


> ```
$(document).ready(function()  //Called when the document is ready to be submitted
{
	$("#submitBtn").click( function()  //Function called when submit button is pressed
	{
    		event.preventDefault();  //Prevents default submit from occurring
    		$('#submitBtn').prop('disabled', 'true');  //Disables submit button
    		census.submit( '#questionDiv', '#taskForm' );  //Submits data from tasks to census server
	});
});
```
	
* DO NOT call this function until you’re ready for your task to be submitted to MTurk (as the form will be submitted to MTurk as-is once the census task is complete)
