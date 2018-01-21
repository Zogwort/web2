<!DOCTYPE html>
<html>
	<head>
		<title>Hello, World!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	</head>

	<body>
		<?php
			echo date("F j, Y, g:i a");
		?>

		<form action="scraper.php" method="post">
			<p>ISBN</p>
			<input name="isbn"  type="text"/>
			<p>Condition</p>
			<select name="condition">
				<option value="like_new">Like New</option>
				<option value="good">Good</option>
				<option value="fair">Fair</option>
			</select></br>
			<p>Price</p>
			<input name="price" type="text"/></br></br>
			<input type="submit"/>
		</form>

	</body>
</html>
