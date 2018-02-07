<!DOCTYPE html>
<html>
	<head>
		<title>Hello, World!</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	</head>

	<body>
		<?php
			$title = $author = $edition = $year = $publisher = "N/A";
			$ISBN = str_replace("-","",$_POST["isbn"]);
			$price = $_POST["price"];			

			if(preg_match("/\d{9}(?:\d|X)/", $ISBN) && ($price >= 0.00 && $price <= 200.00)){
				echo "ISBN: ".$ISBN;
				
				echo "</br>";	
				$amazon = fopen("http://www.amazon.com/exec/obidos/ISBN=".$ISBN, "r");
				while(($tmp = fgets($amazon, 4096)) !== false){
					if (preg_match("/<span id=\"productTitle\".+>(.+)<\/span>/",$tmp,$result)) {
   						$title= $result[1];
					}	
					if (preg_match("/<span class=\"author notFaded\".+>[/r/n]+<a.+>(.+)<\/a>/",$tmp,$result)) {
   						$author= $result[1];
					}
					if (preg_match("/<span id=\"bookEdition\".+>(.+)<\/span>/",$tmp,$result)) {
   						$edition= $result[1];
					}
					if (preg_match("/<meta name=\"description\".+\[(.+)\]/",$tmp,$result)) {
   						$author= $result[1];
					}
					if (preg_match("/<meta name=\"description\".+\[(.+)\]/",$tmp,$result)) {
   						$author= $result[1];
					}
				}
				fclose($amazon);
				echo "Title: " . $title . "</br>";
				echo "Author: " . $author . "</br>";
				echo "Edition: " . $edition . "</br>";
				echo "Year: " . $year . "</br>";
				echo "Publisher: " . $publisher . "</br>";
			} else {
				echo "Not Valid";
			}
		?>
	</body>
</html>
