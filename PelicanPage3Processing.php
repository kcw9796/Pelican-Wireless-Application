<?php 
require 'PelicanDatabaseQueryFunctions.php';
session_start();

if(isset($_POST['submit3']))
{
	$projectid = $_SESSION['pelicanprojectid'];
	$location = 'features_info';
	$thermostatlist = array(0);
	$value = 'yes';
	$featureslist = array($_POST['5_0']);
	updatefeatures($projectid,$location,$thermostatlist,$featureslist,$value);
}
 
header("Location: PelicanPage4.php");
die();

 ?>