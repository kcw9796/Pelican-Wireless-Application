<!DOCTYPE html>
<html>
<head>
	<title>Pelican Product Selector</title>
	<link rel="stylesheet" type="text/css" href="PelicanSystemStyling.css">
	<script type="text/javascript" src="PelicanSystemPageFunctions.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<?php
		require 'PelicanDatabaseQueryFunctions.php';
		session_start();
		$results = loadpage(4);
		$headers = unserialize($_COOKIE['pelicanquestionheaders']);
 	?>

	<script type="text/javascript">
	 	storagename = sessionStorage.getItem("pelicanlinkstoragename");
	 	if(localStorage.getItem(storagename) < 4)
		{
			localStorage.setItem(storagename,4);
		}
	</script>

</head>
<body onload="linksdisplay(4)">
<div class="fullpage">
	
	<?php 
		include_once('header.php');
	 ?>

	<form class="forms" method=post action=PelicanPage4Processing.php> 

		<p>
			<?php 
				$headers[6]->displayheader();
			 ?>
		</p>

		<div class="radio-toolbar" style="margin-top:50px">
			<?php
	    		displaythermostatoptions($results);
			 ?>		
		</div>


		<div style="overflow:hidden">
			<input class="sub_res" type="submit" name="submit4" value="Save and Continue" style="float:right">
			<p style="clear:both"></p>			
		</div>

		
	</form>
</div>
</body>
</html>
