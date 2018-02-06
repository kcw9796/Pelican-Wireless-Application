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
		$results = loadpage(1);
		$projectid = $_SESSION['pelicanprojectid'];
		$headers = unserialize($_COOKIE["pelicanquestionheaders"]);
	 ?>

	<script type="text/javascript">
	 	projectid = "<?php echo $projectid ?>";
	 	sessionStorage.setItem("pelicanprojectid",projectid);
	 	storagename = "pelicanlinkposition" + projectid;
	 	sessionStorage.setItem("pelicanlinkstoragename",storagename);
	 	if(localStorage.getItem(storagename) < 1)
		{
			localStorage.setItem(storagename,1);
		}
	</script>

</head>
<body onload="page1displaycheck();linksdisplay(1)">
<div class="fullpage">	

	<?php 
		include_once('header.php');
	 ?>
	
	<form  class="forms" method=post action=PelicanPage1Processing.php> 
		<script type="text/javascript" src="entertotab.js"></script>

		<p>
			<?php 
				$headers[1]->displayheader();
			 ?>
		</p>
		
		<fieldset id="Q1block">
			<fieldset id="person">
				<div id="headcircle"></div>
				<div id="bodyoval"></div>
			</fieldset>

			<fieldset id="Q1">
				<label id="Q1title"><strong>I AM A:</strong></label>
				<div class="radio-toolbar">
			    	<?php 
			    		if(isset($results[1]))
			    			{ displaypersontypequestion($results[1][0][0]); }
			    		else
			    			{ displaypersontypequestion("none"); }
			    	 ?>
				<!--
					PERSON TYPE EXAMPLE:
			    	<input type="radio" id="1.1" name="1" value="false" onclick="updatepersontype('Contractor')">
			    	<label for="1.1">Contractor</label>
			    -->
		    	</div>
			</fieldset>
		</fieldset>

		<div style="overflow:hidden">
			<input class="sub_res" type="button" onclick="window.location.href='PelicanPage1Processing.php'" name="skip1" value="Skip Question" style="float:right">
			<p style="clear:both"></p>
		</div>
		
		<br>
		<hr>
		<div id="part2">
			
			<!--
				INFORMATION EXAMPLE: <br>
				<input type="text" class="infoquestions" name="Contractor_Question.1" placeholder="Project Name..." value="" style="float:left">
				<input type="text" class="infoquestions" name="Contractor_Question.1" placeholder="Project Name..." value="" style="float:right">
				<p style="clear:both"></p>
			-->

			<p id=infoheader>
				<?php 
					$headers[2]->displayheader();
				 ?>
			</p>

			<fieldset id="Contractor_Questions">
				<?php
					if(isset($results[2]))
						{ displayinfoquestion("contractor_info",$results[2][0]); }
					else
						{ displayinfoquestion("contractor_info","none"); }
		 		?>
			</fieldset>

			<fieldset id="Customer_Questions">
				<?php 
					if(isset($results[3]))
						{ displayinfoquestion("customer_info",$results[3][0]); }
					else
						{ displayinfoquestion("customer_info","none"); }
			 	?>
			</fieldset>

			<div style="overflow:hidden">
				<p style="float:right">
					<input class="sub_res" type="button" name="skip2" onclick="window.location.href='PelicanPage1Processing.php'" value="Skip Question" style="margin-right:7px">
					<input class="sub_res" type="submit" name="submit1" value="Save and Continue" style="margin-left:7px"> 
				</p>
			</div>
		</div>
	</form>
</div>
</body>
</html>






