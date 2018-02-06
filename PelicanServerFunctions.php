<?php
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "";
	$db_name = "Pelican_Database";

	@mysql_connect("$db_host","$db_username","$db_password") or die ("Could not connect to MySQL");
	@mysql_select_db("$db_name") or die ("No database");

	function returnvalue($projectid,$location,$columnname) {
		$return = "ERROR";
		$checkquery = "SELECT `" . $columnname . "` FROM `" . $location . "` WHERE projectid='" . $projectid . "'";
			if($query_run = mysql_query($checkquery))
			{
				while($query_execute = mysql_fetch_assoc($query_run))
				{
					$return = $query_execute[$columnname]; 
				}
			}
			mysql_free_result($query_run);
			return $return;
	}

	function returnnumericarray($projectid,$location) {
		$return = "ERROR";
		$checkquery = "SELECT * FROM `" . $location . "` WHERE projectid='" . $projectid . "'";
			if($query_run = mysql_query($checkquery))
			{
				$return = $query_execute = mysql_fetch_array($query_run,MYSQL_NUM);
			}
			mysql_free_result($query_run);
			return $return;
	}


	function buildquestionheader($Qnum) {
		$questionquery = "SELECT * FROM `product_selector_questions` WHERE qnumber=" . $Qnum;
		if($query_run=mysql_query($questionquery))
		{
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$header = $query_execute['header'];
				$subheader = $query_execute['subheader'];
				echo"<label class='questionheader'>$header</label> <br>
					<label class='questionsubheader'>$subheader</label>";						
			}
		}
		else
		{				
			echo"Query not executed";
		}
		mysql_free_result($query_run);
	} 

	function buildpersontypequestion() {
		$person_type = "empty";
		if(isset($_SESSION['pelicanprojectid']))
		{
			$projectid = $_SESSION['pelicanprojectid'];
			$person_type = returnvalue($projectid,"person_type","person_type");
		}

		$questionquery = "SELECT * FROM `product_selector_choices` WHERE qnumber=1";
		if($query_run=mysql_query($questionquery))
		{
			$i = 1;
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$text = $query_execute['text'];
				$checkvalue = "";
				if($text == $person_type)
					{ $checkvalue = "checked"; }
				$idname = "1_" . $i;
				echo"<div class='multichoiceblock'><input type='radio' id='$idname' name='1' value='$text' onclick='updatepersontype(\"$text\")' $checkvalue>
			    	<label for='$idname'><span class='multichoicetext'>$text</span></label></div>";	
			    $i++;					
			}
		}
		else
		{				
			echo"Query not executed";
		}
		mysql_free_result($query_run);

	} 	


	function buildinfoquestion($typeofquestion) {
		$defaultinput = false;
		$currentvalue = "";
		if(isset($_SESSION['pelicanprojectid']))
		{
			$projectid = $_SESSION['pelicanprojectid'];
			if($typeofquestion=="contractor_questions")
				{ $clientlocation = "contractor_info"; }
			if($typeofquestion=="customer_questions")
				{ $clientlocation = "customer_info"; }
			if($values = returnnumericarray($projectid,$clientlocation))
				{ $defaultinput=true; }		 
		}


		$questionquery = "SELECT * FROM `" . $typeofquestion . "`";
		if($query_run=mysql_query($questionquery))
		{
			$i=1;
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$Qid = $query_execute['id'];
				$Qtext = $query_execute['text'];
				$Qtype = $query_execute['type'];
				if($Qtype == 'l') 
				{
					$widthpercent = '49%';
					$floatside = 'left';
				}
				if($Qtype == 'r')
				{
					$widthpercent = '49%';
					$floatside = 'right';
				}
				if($Qtype == 'f')
				{
					$widthpercent = '100%';
					$floatside = 'none';
				}
				$Qname = $typeofquestion . "_" . $Qid;
				$Qvalue = $Qtext . '...';

				if($defaultinput)
				{
					$currentvalue = $values[$i];
				}

				echo"<input type='text' class='infoquestions' name='$Qname' placeholder='$Qvalue' style='width:$widthpercent;float:$floatside' value='$currentvalue'>";
				if($Qtype == 'r')
				{
					echo"<p style='clear:both'></p>";
				}
				$i++;
			}
		}
		else
		{				
			echo"Query not executed";
		}
		mysql_free_result($query_run);
	}


	function buildnumofbuildingsquestion() {
		$building_num = "";
		if(isset($_SESSION['pelicanprojectid']))
		{
			$projectid = $_SESSION['pelicanprojectid'];
			$building_num = 
			$checkquery = "SELECT building_number FROM units_info WHERE projectid='" . $projectid . "' LIMIT 1";
			if($query_run = mysql_query($checkquery))
			{
				while($query_execute = mysql_fetch_array($query_run,MYSQL_NUM))
				{
					$building_num = $query_execute[0]; 
				}
			}
		}

		echo"<input type='number' class='infoquestions' name='Number_of_buildings' id='Number_of_buildings' placeholder='Input Number of Buildings...'' value='$building_num' style='width:90%;padding-left:10px' oninput='showQ4(this.value)'>";

		mysql_free_result($query_run);
	}


	function buildunitstypequestion() {
		$defaultinput = false;
		$currentvalue = "";
		if(isset($_SESSION['pelicanprojectid']))
		{
			$projectid = $_SESSION['pelicanprojectid'];
			$clientlocation = "units_info";
			$unitsquery = "SELECT * FROM `" . $clientlocation . "` WHERE projectid=" . $projectid;
			if($unitsquery_run=mysql_query($unitsquery))
				{ 
					$values=mysql_fetch_array($unitsquery_run,MYSQL_NUM);
					mysql_free_result($unitsquery_run);
					$defaultinput = true;
				}			 
		}

		$questionquery = "SELECT * FROM `product_selector_choices` WHERE qnumber=4";
		if($query_run=mysql_query($questionquery))
		{
			$i = 1;
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$text = $query_execute['text'];
				if($defaultinput)
				{
					$currentvalue = $values[$i+1];
				}
				$idname = "4_" . $i;
				echo"<tr>
					<td><label class='Q4labels'>$text</label></td>
					<td><input type='number' class='Q4' id='$idname' name='$idname' placeholder='0' value='$currentvalue' class='unitstypes' oninput='updateQ4total()'></td>	
				</tr>";	
			   	$i++;					
			}
		}
		else
		{				
			echo"Query not executed";
		}
		mysql_free_result($query_run);
	}


	function buildfeatureoptions($thermnumber,$filter) {
		$features[1] = "";
		if(isset($_SESSION['pelicanprojectid']))
		{
			$projectid = $_SESSION['pelicanprojectid'];
			$return = "ERROR";
			$checkquery = "SELECT feature_name FROM features_info WHERE projectid='" . $projectid . "' AND thermostat='" . $thermnumber . "'";
			if($query_run = mysql_query($checkquery))
			{
				$i = 1;
				while($query_execute = mysql_fetch_assoc($query_run))
					{
						$features[$i] = $query_execute['feature_name'];
						$i++;
					}
			}
			mysql_free_result($query_run);
		}

		$questionquery = "SELECT * FROM `product_selector_choices` WHERE qnumber=5";
		if($query_run=mysql_query($questionquery))
		{
			$i = 1;
			$check = true;
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$text = $query_execute['text'];
				if($filter != "All")
				{
					$check = false;
					foreach ($filter as $currentvalue) {
						if($currentvalue == $text)
							{ $check = true; }
					}
				}
				$checked = "";
				foreach ($features as $feature) {
					if($feature==$text)
						{ $checked = "checked"; }
				}
				if($check == true)
				{
					$idname = "5_" . $thermnumber . "_" . $i;
					$name = "5_" . $thermnumber . "[]";
					echo"<div class='multichoiceblock'><input type='checkbox' id='$idname' name='$name' value='$text' $checked>
			   		<label for='$idname'><span class='multichoicetext'>$text</span></label></div>";	
				}
				
			   	$i++;					
			}
		}
		else
		{				
			echo"Query not executed";
		}
		mysql_free_result($query_run);

	} 


function buildthermostatoptions($projectid) {
	$questionquery = "SELECT * FROM `units_info` WHERE projectid=" . $projectid;
		if($query_run=mysql_query($questionquery))
		{
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$thermostat_number = $query_execute['conventional_single'] + $query_execute['heatpump_single'] + $query_execute['conventional_multi'] + $query_execute['heatpump_multi'];					
			}
		}
		else
		{				
			echo"Query not executed";
		}
	
	$check = false;
	$questionquery = "SELECT * FROM `features_info` WHERE thermostat=0 AND projectid=" . $projectid;
		if($query_run=mysql_query($questionquery))
		{
			$i = 0;
			while($query_execute=mysql_fetch_assoc($query_run))
			{
				$feature_name[$i] = $query_execute['feature_name'];
				$check = true;
				$i++;					
			}
		}
		else
		{				
			echo"Query not executed";
		}
	
	if($check == true)
	{
		for($i=1;$i<=$thermostat_number;$i++)
		{
			echo"<p class='Q6'><strong>THERMOSTAT $i:</strong>";
			buildfeatureoptions($i,$feature_name);
			echo"</p>";
		}
	}
	mysql_free_result($query_run);
}


function insertgeneralinfo($projectid,$location,$data)
{
	$datastring = "('" . $projectid . "',";
	$i = 1;
	for($i=1;$i<sizeof($data);$i++)
	{
		$datastring = $datastring . "'" .  $data[$i] . "',";
	}
	$datastring = $datastring . "'" . $data[$i] . "')";

	$insert = "REPLACE INTO `" . $location . "` VALUES " . $datastring;
	if($result = mysql_query($insert)) {
			return "success";
		}
	else {
		return "ERROR";
	}
}


function deleteexistingfeatures($projectid,$location,$thermostat) {
	$deleterows = "DELETE FROM `" . $location . "` WHERE `thermostat`= '" . $thermostat . "' AND `projectid`='" . $projectid . "'";
	mysql_query($deleterows) or trigger_error(mysql_error() . " in " . $deleterows);
}


function insertfeature($projectid,$location,$thermostat,$featurename,$value) {
	$datastring = "('" . $projectid . "','" . $thermostat . "','" . $featurename . "','" . $value . "')";
	$insert = "INSERT INTO `" . $location . "` (`projectid`,`thermostat`,`feature_name`,`value`) VALUES " . $datastring;
	if($result = mysql_query($insert)) {
		return "success";
	}
	else
	{
		return "ERROR";
	}	
}



 ?>


