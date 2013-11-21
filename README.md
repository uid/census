CENSUS
We are a group of researchers at Stanford, MIT, U. Rochester, U. Michigan, UT Austin, and elsewhere trying to learn more about the demographic and cognitive information regarding the workers on Amazon's Mechanical Turks. Our package allows you to post tasks on Mechanical Turks and then assess the demographic and cognitive skills for the workers that do your tasks. 


BRIEF OVERVIEW - HOW IT WORKS
We attach an additional, extremely short question for the worker to answer once they have completed your task. The results of these additional census questions regarding the workers answering your questions are aggregated and provided for you to view through our webpage: (ENTER LATER). The results of your original task are not affected nor stored by us.


INSTRUCTIONS TO USE
1) Pull the /censusTool folder off the server.

2) In your main task file, make a call to census as follows:
	- Call census.submit( '#questionDiv', '#taskForm' ); when your task is ready to submit
		-- #questionDiv is the empty <div> where the census question will be posted
		-- #taskForm is the <form> element that will be submitted to MTurk.

- DO NOT call this function until you’re ready for your task to be submitted to MTurk (as the form will be submitted to MTurk as-is once the census task is complete)
- To see examples, look in the client/demo.html file.

NOTE: Be sure to disable your task’s ‘Submit’ button before calling submit (to ensure workers can’t submit your task twice).
3) To see aggregated census data regarding the workers answering your questions, visit (ENTER WEBSITE) and click on "View Details" in the For Requesters section in the bottom left.

5) Enter (WHAT DO THEY ENTER?) to see (HOW IS THE INFORMATION PRESENTED?)