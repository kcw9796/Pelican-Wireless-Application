<?php 
require 'PelicanDatabaseQueryFunctions.php';
session_start();
if(isset($_POST['submit4']))
{
	$projectid = $_SESSION['pelicanprojectid'];
	$location = 'features_info';
	$value = 'yes';
	$thermostatlist = array();
	$featureslist = array();
	$thermostat_number = $_POST['thermostat_number'];
	for($i=1;$i<=$thermostat_number;$i++) 
	{
		$name = "5_" . $i;
		$thermostatlist[] = $i;
		if(isset($_POST[$name]))
		{
			$featureslist[] = $_POST[$name];
		}
		else
		{
			$featureslist[] = "";
		}
	}
	updatefeatures($projectid,$location,$thermostatlist,$featureslist,$value);
}

header("Location: PelicanPage5.php");
die();

 ?>