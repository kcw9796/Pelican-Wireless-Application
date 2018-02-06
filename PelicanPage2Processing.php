<?php 
require 'PelicanDatabaseQueryFunctions.php';
session_start();

if(isset($_POST['submit2']))
{
	$projectid = $_SESSION['pelicanprojectid'];
	$locationlist = array();
	$datalist = array();
	$_SESSION['pelicanlocalidinsert'] = true;

	$HVAC_Total = $_POST['HVAC_Total'];
	$unitdata[1] = $_POST['Number_of_buildings'];
	$unitdata[2] = $_POST['4_1'];
	$unitdata[3] = $_POST['4_2'];
	$unitdata[4] = '';
	$unitdata[5] = '';
	$locationlist[] = "units_info";
	$datalist[] = $unitdata;
	insertpageinfo($projectid,$locationlist,$datalist);
}

header("Location: PelicanPage3.php");
die();
 ?>






<?php 
/*
require 'PelicanServerFunctions.php';
session_start();

if(isset($_POST['submit2']))
{
	$projectid = $_SESSION['pelicanprojectid'];
	if($projectid=="skip")
	{
		$projectid = insertprojectid();
		$_SESSION['pelicanprojectid'] = $projectid;
	}
	$HVAC_Total = $_POST['HVAC_Total'];
	$unitdata[1] = $_POST['Number_of_buildings'];
	$unitdata[2] = $_POST['4_1'];
	$unitdata[3] = $_POST['4_2'];
	$unitdata[4] = '';
	$unitdata[5] = '';
	$location = "units_info";
	insertgeneralinfo($projectid,$location,$unitdata);
}

header("Location: PelicanPage3.php");
die();
*/
 ?>


