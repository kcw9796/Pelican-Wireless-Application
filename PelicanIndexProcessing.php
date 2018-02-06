
<?php 
	require 'PelicanDatabaseQueryFunctions.php';
	session_start();
	if(isset($_POST['initialid']))
	{
		$projectid = $_POST['initialid'];
	}
	else
	{
		$projectid = insertprojectid();
	}
	$_SESSION['pelicanprojectid'] = $projectid;
	$_SESSION['pelicanlocalidinsert'] = false;

	loadformelements();

	header("Location: PelicanPage1.php");
	die();
?>
