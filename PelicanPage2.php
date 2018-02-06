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
		$results = loadpage(2);
		$addidlocally = $_SESSION['pelicanlocalidinsert'];
		$headers = unserialize($_COOKIE["pelicanquestionheaders"]);
 	?>

	<script type="text/javascript">
		projectid = sessionStorage.getItem("pelicanprojectid");
		addidlocally = "<?php echo $addidlocally ?>";
		if(addidlocally)
		{
			storeidlocally(projectid);
		}
	 	storagename = sessionStorage.getItem("pelicanlinkstoragename");
	 	if(localStorage.getItem(storagename) < 2)
		{
			localStorage.setItem(storagename,2);
		}
	</script>

	<?php 
		$_SESSION['pelicanlocalidinsert'] = false;
	 ?>

</head>
<body onload="page2displaycheck();linksdisplay(2)">
<div class="fullpage">
	
	<?php 
		include_once('header.php');
	 ?>

	<form class="forms" method=post action=PelicanPage2Processing.php> 
	 	<script type="text/javascript" src="entertotab.js"></script>

		<p style="margin-bottom:60px">
			<?php 
				$headers[3]->displayheader();

				if(isset($results[1]))
	    			{ displaynumofbuildingsquestion($results[1][0]); }
	    		else
	    			{ displaynumofbuildingsquestion("none"); }
			 ?>

		</p>
		<hr style="margin-right:10%">

		
		<div id="Q4block">
			<?php 
				$headers[4]->displayheader();
			 ?>
			 <br><br>
			<table cellpadding="8">
				
				<?php 
					if(isset($results[1]))
	    				{ displayunitstypequestion($results[1][0]); }
	    			else
	    				{ displayunitstypequestion("none"); }
				 ?>

				<tr>
					<td><label class="Q4labels">TOTAL NUMBER OF HVAC UNITS: </label></td>
					<td><label name="Q4total" class="Q4" id="Q4total" style="margin:0px">0</label></td>
				</tr>
				<!--
				UNITS TYPE QUESTION EXAMPLE:
				<tr>
					<td><label class="Q4labels">CONVENTIONAL UNITS SERVING A SINGLE ZONE:</label></td>
					<td><input type="number" class="Q4" name="4.1" placeholder="0" value="" class="unitstypes" onchange="updateQ4total()"></td>	
				</tr>
				-->
			</table>	

			<input type="hidden" name="HVAC_Total" id="HVAC_Total" value="0">

			<div style="overflow:hidden">
				<input class="sub_res" type="submit" name="submit2" value="Save and Continue" style="float:right">
				<p style="clear:both"></p>
			</div>
		</div>
		
	</form>
</div>
</body>
</html>


