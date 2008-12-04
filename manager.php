<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="js/mootools-1.2.1-core.js"></script>
		<script type="text/javascript" src="js/mootools-1.2-more.js"></script>
		<script type="text/javascript" src="js/miniPinkSquare.js"></script>
	</head>
	
	<body>
		<h1>miniPinkSquare</h1>
		<h2>Contentklassen</h2>
		<ul id="contentclasses"></ul>
		<div>
			<a href="" id="addContentClass">add</a>
			<form action="handleRequest.php" method="post" id="createContentClass" style="display:none">				
				<fieldset>				
					<legend>Create a new ContentClass</legend>
					<input type="hidden" name="method" value="addContentClass" />		
					<label for="name">Name</label><input type="text" name="name" />	
					<input type="submit" name="create" value="create" />				
				</fieldset>
			</form>
		</div>		
	</body>
</html>