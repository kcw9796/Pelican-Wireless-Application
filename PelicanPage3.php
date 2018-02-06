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
		$results = loadpage(3);
		$headers = unserialize($_COOKIE['pelicanquestionheaders']);
		$addidlocally = $_SESSION['pelicanlocalidinsert'];
 	?>

	<script type="text/javascript">
	 	projectid = sessionStorage.getItem("pelicanprojectid");
	 	addidlocally = "<?php echo $addidlocally ?>";
		if(addidlocally)
		{
			storeidlocally(projectid);
		}
	 	storagename = sessionStorage.getItem("pelicanlinkstoragename");
	 	if(localStorage.getItem(storagename) < 3)
		{
			localStorage.setItem(storagename,3);
		}
	</script>

	<?php 
		$_SESSION['pelicanlocalidinsert'] = false;
	 ?>

</head>
<body onload="linksdisplay(3)">
<div class="fullpage">
	
	<?php 
		include_once('header.php');
	 ?>

	<form class="forms" method=post action=PelicanPage3Processing.php onsubmit="return validatepage3()"> 

	 	<script type="text/javascript">

	 	</script>

		 <p>
		 	<?php 
		 		$headers[5]->displayheader();
		 	 ?>
		 </p>

		<div class="radio-toolbar" style="margin-top:50px">
			<p>
				
				<?php 
					

					if(isset($results[1]))
					{
						for($i=0;$i<sizeof($results[1]);$i++)
						{
							$features[] = $results[1][$i][1];
						}
	    				displayfeatureoptions(0,"All",$features); 
	    			}
	    			else
	    				{ displayfeatureoptions(0,"All","none"); }
				 ?>
				
				<!--
				FEATURE EXAMPLE:
				<div class="multichoiceblock"><input type="checkbox" id="5.1" name="5" value="false">
			   	<label for="5.1"><span class="multichoicetext">Humidity %</span></label></div>
			   	-->
			   	
			</p>		
		</div>


		<div style="overflow:hidden">
			<input class="sub_res" type="submit" name="submit3" value="Save and Continue" style="float:right">
			<p style="clear:both"></p>			
		</div>

		
	</form>
</div>
</body>
</html>

