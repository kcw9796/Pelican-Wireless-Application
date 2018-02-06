<!DOCTYPE html>
<html>
<head>
	<title>Pelican Product Selector</title>
	<link rel="stylesheet" type="text/css" href="PelicanSystemStyling.css">
	<script type="text/javascript" src="PelicanSystemPageFunctions.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<script type="text/javascript">
	 	storagename = sessionStorage.getItem("pelicanlinkstoragename");
	 	if(localStorage.getItem(storagename) < 5)
		{
			localStorage.setItem(storagename,5);
		}
	</script>

</head>
<body onload="linksdisplay(5)">
<div class="fullpage">
	
	<?php 
		require 'PelicanDatabaseQueryFunctions.php';
		include_once('header.php');
	 ?>

	 <script type="text/javascript" src="entertotab.js"></script>

	<form class="forms">
		SUCCESS
	</form>
	

</div>
</body>
</html>