<?php
	$has_error=FALSE;
	$price_error= $isbn_error= '';
	if (array_key_exists('isbn',$_POST)) {
		
		// the form was posted so we need to validate it
		$_POST['isbn'] = str_replace(" ", "",$_POST['isbn']);
		$_POST['isbn'] = str_replace("-", "",$_POST['isbn']);
		if(!preg_match("/\d{9}(?:\d|X)/", $_POST['isbn'])) {
			$isbn_error= 'Invalid ISBN';
			$has_error= TRUE;
		}
		if ($_POST['price'] > 200.00) {
			$price_error= 'Price too High';
			$has_error= TRUE;
		}
		if ($_POST['price'] < 0.00) {
			$price_error= 'Price too Low';
			$has_error= TRUE;
			}	
		}
	$title= $has_error ? 'Book Form' : 'Book Information';
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"></meta>
  <title><?php echo $title;?></title>
  <style>
		.errormsg { color:red; margin-left:10px; }
		form p { display:none; }
	</style>
</head>

<body class="container_12">
	<!-- p> ?php echo (!array_key_exists('isbn',$_POST) || $has_error)  ?></p -->
	<?php
	if (!array_key_exists('isbn',$_POST) || $has_error) // show the form
	{
	?>
			<h1>Book Information</h1>
			<p>Please enter the following information:</p>

			<form method="post" action="sell.php" onsubmit="return checkTheForm()">
				<label class="grid_1">ISBN:</label>
				<input class="grid_2" type="text" id="isbn" name="isbn"/>
				<div class="clear"></div>
				<p class="<?php echo $isbn_error;?>" id="isbn-error">ISBN is invalid</p>
				</br>

				<label class="grid_1">Condition:</label>
				<select class="grid_1" id="condition" name="condition">
					<option id="Like New">Like New</option>
					<option id="Good">Good</option>
					<option id="Fair">Fair</option>
				</select>
				</br></br>
		
				<label class="grid_1">Price:</label>
				<input class="grid_2" type="text" id="price" name="price"/>
				<div class="clear"></div>
				<p class="<?php echo $price_error;?>" id="price-error">Price is Required</p>
				</br></br>

				<div class="clear"></div>
				<input class="push_1 grid_2" type="submit" id="submit" value="Submit Form" name="submitbutton" />
			</form>
	<?php
	}
	else // form was accepted, let's display the results
	{
	
		$info = json_decode(file_get_contents("https://www.googleapis.com/books/v1/volumes?q=isbn:" . $_POST['isbn']),true);
		
		$author=$bookTitle=$year=$publisher="Unknown";
		
		$bookTitle=$info['items'][0]['volumeInfo']['title'];
		$author = $info['items'][0]['volumeInfo']['authors'];
		$year = $info['items'][0]['volumeInfo']['publishedDate'];
		$publisher = $info['items'][0]['volumeInfo']['publisher'];

?>	
		<h1>Book Information</h1>
		<p>ISBN: <?php echo $_POST['isbn']; ?></p>
		<p>Author(s): <?php 
			for($i = 0;$i < count($author);$i++) {
    			echo $author[$i];
				if($i !== (count($author)-1)){
					echo", ";
				}
			} 		
		?> </p>
		<p>Title: <?php echo $bookTitle ?> </p>
		<p>Year/Date: <?php echo $year ?> </p>
		<p>Publisher: <?php echo $publisher ?> </p>	
	<?php
	}
	?>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script>
	$(document).ready(function() {
		$('.errormsg').fadeIn();
	});

  function checkTheForm() {
		var err= false;

		$(".errormsg").removeClass("errormsg").hide();
    if ($("#isbn").val().search(/\d{9}(?:\d|X)/)==-1) {
			$("#isbn-error").addClass("errormsg").fadeIn();
			err= true;
		}
    if ($("#price").val().search(/^\s*$/)==0) {
			$("#price-error").addClass("errormsg").fadeIn();
			err= true;
		}
    if (!$("#male").checked && !$("#female").checked)

    return !err;
  }
  </script>
</body>
</html>
