<?php 
require 'PelicanDatabaseQueryFunctions.php';
session_start();

$projectid = $_SESSION['pelicanprojectid'];
if(isset($_POST['submit1']))
{
	$locationlist = array();
	$datalist = array();
	$_SESSION['pelicanlocalidinsert'] = true;
	$q1[1] = $_POST['1'];
	$locationlist[] = 'person_type';
	$datalist[] = $q1;

	if($q1[1]=="Contractor")
	{
		$i=1;
		$idname="contractor_info_1";
		while(isset($_POST[$idname]))
		{
			$contractorinfo[$i] = $_POST[$idname];
			$i++;
			$idname="contractor_info_" . $i;
		}
		$locationlist[] = 'contractor_info';
		$datalist[] = $contractorinfo;
	}
	$i=1;
	$idname="customer_info_1";
	while(isset($_POST[$idname]))
	{
		$customerinfo[$i] = $_POST[$idname];
		$i++;
		$idname="customer_info_" . $i;
	}
	$locationlist[] = 'customer_info';
	$datalist[] = $customerinfo;
	insertpageinfo($projectid,$locationlist,$datalist);
}

header("Location: PelicanPage2.php");
die();
 ?>






 <?php 
/*
require 'PelicanServerFunctions.php';
session_start();

if(isset($_POST['submit1']))
{
	$projectid = insertprojectid();
	$q1[1] = $_POST['1'];
	$location = 'person_type';
	insertgeneralinfo($projectid,$location,$q1);
	if($q1[1]=="Contractor")
	{
		$i=1;
		$idname="contractor_questions_1";
		while(isset($_POST[$idname]))
		{
			$contractorinfo[$i] = $_POST[$idname];
			$i++;
			$idname="contractor_questions_" . $i;
		}
		$location = 'contractor_info';
		insertgeneralinfo($projectid,$location,$contractorinfo);
	}
	$i=1;
	$idname="customer_questions_1";
	while(isset($_POST[$idname]))
	{
		$customerinfo[$i] = $_POST[$idname];
		$i++;
		$idname="customer_questions_" . $i;
	}
	$location = 'customer_info';
	insertgeneralinfo($projectid,$location,$customerinfo);
}
else
{
	if(isset($_SESSION['pelicanprojectid']))
	{
		$projectid = $_SESSION['pelicanprojectid'];
	}
	else
	{
		$projectid = "skip";

	}
}

$_SESSION['pelicanprojectid'] = $projectid;

header("Location: PelicanPage2.php");
die();
*/
 ?>



