<!DOCTYPE html>
<html>
	<head>
		<title>Hello, World!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	</head>

	<body>
		<?php
			$ISBN = str_replace("-","",$_POST["isbn"]);
			
			if(preg_match("/\d{9}(?:\d|X)/", $ISBN)){
				echo $ISBN;
				
				echo "</br>";	
				$poem = fopen("poem.txt", "r");
				while(($tmp = fgets($poem, 4096)) !== false){
					echo $tmp . "</br>";
				}
				fclose($poem);
			} else {
				echo "Not Valid";
			}
		?>
	</body>
</html>
