<html>

<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
<script src="start.js" type="text/javascript"></script>
<link rel="stylesheet" href="style.css" />

<body>

	<div id="header">
		Get started with Census!
	</div>

	<div id="Instructions">
		To get started, just click the button below and generate a unique key, then get a copy of the <a href="">Census GitHub project</a>

		<BR/>
		<BR/>
		<HR/>
		<BR/>
	</div>

	<div id="container">
		<div id="pass" class="pwd">
			<div id="pass-label">Add a password (optional):</div>
			<input type="text" id="pass-field"></input>
		</div>
		<div id="confirmPass" class="pwd">
			<div id="confirmPass-label">Confirm password:</div>
			<input type="text" id="confirmPass-field"></input>
		</div>

		<input type="button" id="genBtn" value="Click here to get a key for your project!"></input>

		<div id="key">
			<div id="key-label">Your key: </div>
			<div id="key-val"></div>
		</div>
	</div>

</body>

</html>
