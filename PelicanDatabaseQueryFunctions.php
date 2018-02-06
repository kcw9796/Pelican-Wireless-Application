<?php 

class headerinfo {
	public $header;
	public $subheader;
	
	function __construct($x,$y)
	{
		$this->header=$x;
		$this->subheader=$y;
	}

	function displayheader()
	{
		$header = $this->header;
		$subheader = $this->subheader;
		echo"<label class='questionheader'>$header</label><br>
		<label class='questionsubheader'>$subheader</label>";
	}
}

class infoinput {
	public $text;
	public $type;
	
	function __construct($x,$y)
	{
		$this->text=$x;
		$this->type=$y;
	}

	function gettext()
	{
		return $this->text;
	}

	function gettype()
	{
		return $this->type;
	}
}

class selectorchoices {
	public $qnumber;
	public $text;
	
	function __construct($x,$y)
	{
		$this->qnumber=$x;
		$this->text=$y;
	}

	function getqnumber()
	{
		return $this->qnumber;
	}

	function gettext()
	{
		return $this->text;
	}
}


function loadformelements() {
	//Open a new connection to the MySQL server
	$mysqli = new mysqli('localhost','root','','Pelican_Database');

	//Output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$q = "SELECT header,subheader FROM `product_selector_questions`;";
	$q .= "SELECT qnumber,text FROM `product_selector_choices`;";
	$q .= "SELECT text,type FROM `contractor_questions`;";
	$q .= "SELECT text,type FROM `customer_questions`";

	$persontype="";

	$headerinfo = array("");
	$selectorchoices = array();
	$contractorinputs = array();
	$customerinputs = array();

	$query = 1;
	if ($mysqli->multi_query($q)) {
	    do {
	        if ($result = $mysqli->store_result()) {
	            while ($row = $result->fetch_assoc()) {
	                switch($query)
	                {
	                	case 1:
		                	$header = $row['header'];
							$subheader = $row['subheader'];
							$headerinfo[] = new headerinfo($header,$subheader);
							break;
						case 2:
							$qnumber = $row['qnumber'];
							$text = $row['text'];
							$choice = new selectorchoices($qnumber,$text);
							$selectorchoices[] = $choice;
							break;
						case 3:
							$text = $row['text'];
							$type = $row['type'];
							$input = new infoinput($text,$type);
							$contractorinputs[] = $input;
							break;
						case 4:
							$text = $row['text'];
							$type = $row['type'];
							$input = new infoinput($text,$type);
							$customerinputs[] = $input;
							break;
						default:
							break;
	                }
				}
	            $result->free();
	        }
	        /* divider */
	        if ($mysqli->more_results()) {
	            $query++;
	        }
	    } while ($mysqli->next_result());
	}

	setcookie("pelicanquestionheaders", serialize($headerinfo), time()+86400);
	setcookie("pelicanselectorchoices", serialize($selectorchoices), time()+86400);
	setcookie("pelicancontractorinputs", serialize($contractorinputs), time()+86400);
	setcookie("pelicancustomerinputs", serialize($customerinputs), time()+86400);

	// close connection 
	$mysqli->close();
}


function loadpage($page) {
	//Open a new connection to the MySQL server
	$mysqli = new mysqli('localhost','root','','Pelican_Database');

	//Output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	$projectid = "";
	if(isset($_SESSION['pelicanprojectid']))
	{
		$projectid = $_SESSION['pelicanprojectid'];
	}

	switch($page)
	{
		case 1:
			$q = "SELECT `person_type` FROM `person_type` WHERE projectid='" . $projectid . "' LIMIT 1;";
			$q .= "SELECT * FROM `contractor_info` WHERE projectid='" . $projectid . "' LIMIT 1;";
			$q .= "SELECT * FROM `customer_info` WHERE projectid='" . $projectid . "' LIMIT 1";
			break;

		case 2:
			$q = "SELECT building_number,conventional_single,heatpump_single,conventional_multi,heatpump_multi FROM `units_info` WHERE projectid='" . $projectid . "' LIMIT 1";
			break;

		case 3:
			$q = "SELECT thermostat,feature_name FROM `features_info` WHERE projectid='" . $projectid . "' AND thermostat=0";
			break;

		case 4:
			$q = "SELECT conventional_single,heatpump_single,conventional_multi,heatpump_multi FROM `units_info` WHERE projectid='" . $projectid . "' LIMIT 1;";
			$q .= "SELECT thermostat,feature_name FROM `features_info` WHERE projectid='" . $projectid . "'";
			break;

		default:
			break;
	}

	$query = 1;
	$results = array();
	if ($mysqli->multi_query($q)) {
	    do {
	        if ($result = $mysqli->store_result()) {
	            while ($row = $result->fetch_array()) {
	            	$results[$query][] = $row;
	            }
	            $result->free();
	        }
	        /* divider */
	        if ($mysqli->more_results()) {
	            $query++;
	        }
	    } while ($mysqli->next_result());
	}

	return $results;

	// close connection 
	$mysqli->close();
}


function displaypersontypequestion($person_type) {
	$selectoroptions = unserialize($_COOKIE["pelicanselectorchoices"]);
	$i=1;
	foreach ($selectoroptions as $currentoption) {
		if($currentoption->getqnumber()==1)
		{
			$text = $currentoption->gettext();
			$checkvalue = "";
			if($text == $person_type)
				{ $checkvalue = "checked"; }
			$idname = "1_" . $i;
			echo"<div class='multichoiceblock'><input type='radio' id='$idname' name='1' value='$text' onclick='updatepersontype(\"$text\")' $checkvalue>
		    	<label for='$idname'><span class='multichoicetext'>$text</span></label></div>";	
		    $i++;	
		}
	}
} 	


function displayinfoquestion($typeofquestion,$fillinput) {
	$defaultinput = false;
	if($fillinput!="none")
	{
		$defaultinput = true;
	}
	
	$currentvalue = "";

	if($typeofquestion=="contractor_info")
		{ $inputs = unserialize($_COOKIE['pelicancontractorinputs']); }
	if($typeofquestion=="customer_info")
		{ $inputs = unserialize($_COOKIE['pelicancustomerinputs']); }
	$i = 1;
	foreach($inputs as $currentinput)
	{
		$Qtext = $currentinput->gettext();
		$Qtype = $currentinput->gettype();
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
		$Qname = $typeofquestion . "_" . $i;
		$Qvalue = $Qtext . '...';

		if($defaultinput)
		{
			$currentvalue = $fillinput[$i];
		}

		echo"<input type='text' class='infoquestions' name='$Qname' placeholder='$Qvalue' style='width:$widthpercent;float:$floatside' value='$currentvalue'>";
		if($Qtype == 'r')
		{
			echo"<p style='clear:both'></p>";
		}
		$i++;
	}
	
}



function displaynumofbuildingsquestion($results) {
	$building_num = "";
	if($results!="none")
	{
		$building_num = $results[0];
	}

	echo"<input type='number' class='infoquestions' name='Number_of_buildings' id='Number_of_buildings' placeholder='Input Number of Buildings...'' value='$building_num' style='width:90%;padding-left:10px' oninput='showQ4(this.value)'>";
}



function displayunitstypequestion($results) {
	$defaultinput = false;
	$currentvalue = "";

	if($results!="none")
		{ 
			$values = $results;
			$defaultinput = true;
		}			 
	$selectoroptions = unserialize($_COOKIE["pelicanselectorchoices"]);
	$i=1;
	foreach($selectoroptions as $currentoption) {
		if($currentoption->getqnumber()==4)
		{
			$text = $currentoption->gettext();
			if($defaultinput)
				{
					$currentvalue = $values[$i];
				}
				$idname = "4_" . $i;
				echo"<tr>
					<td><label class='Q4labels'>$text</label></td>
					<td><input type='number' class='Q4' id='$idname' name='$idname' placeholder='0' value='$currentvalue' class='unitstypes' oninput='updateQ4total()'></td>	
				</tr>";	
			   	$i++;
		}	
	}
}



function displayfeatureoptions($thermnumber,$filter,$results) {
	$selectoroptions = unserialize($_COOKIE["pelicanselectorchoices"]);
	$i = 1;
	foreach ($selectoroptions as $currentfeature) {
		if($currentfeature->getqnumber()==5)
		{	
			$text = $currentfeature->gettext();
			$check = true;
			if($filter != "All")
			{
				$check = false;
				foreach ($filter as $currentvalue) {
					if($text == $currentvalue)
						{ $check = true; }
				}
			}
			$checked = "";
			if($results!="none")
			{
				foreach ($results as $feature) 
				{
					if($feature==$text)
						{ $checked = "checked"; }
				}
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
} 



function displaythermostatoptions($results) {
	$unitstypes = $results[1][0];
	$thermostat_number = 0;
	for($i=0;$i<4;$i++)
	{
		$thermostat_number += $unitstypes[$i];
	}
	echo"<input type='hidden' name='thermostat_number' value='$thermostat_number'>";

	$thermostatfeatures = $results[2];			

	$check = false;
	$feature_name = array();
	foreach ($thermostatfeatures as $currentfeature) 
	{
		if($currentfeature[0]==0)
		{
			$feature_name[] = $currentfeature[1];
			$check = true;
		}
	}
				
	if($check == true)
	{
		for($i=1;$i<=$thermostat_number;$i++)
		{
			$fillfeatures = array();
			for($j=0;$j<sizeof($thermostatfeatures);$j++)
			{
				if($thermostatfeatures[$j][0]==$i)
				{
					$fillfeatures[] = $thermostatfeatures[$j][1];
				}
			}

			echo"<p class='Q6'><strong>THERMOSTAT $i:</strong>";
			if(isset($fillfeatures[0]))
			{
				displayfeatureoptions($i,$feature_name,$fillfeatures);
			}
			else
			{
				displayfeatureoptions($i,$feature_name,"none");
			}
			echo"</p>";
		}
	}
}



function insertpageinfo($projectid,$location,$data)
{
	//Open a new connection to the MySQL server
	$mysqli = new mysqli('localhost','root','','Pelican_Database');

	//Output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	$q = "";
	for($i=0;$i<sizeof($data);$i++)
	{
		if($i!=0)
			{ $q .= ";"; }
		$currentdata = $data[$i];
		$datastring = "('" . $projectid . "',";
		for($j=1;$j<sizeof($currentdata);$j++)
		{
			$datastring .= "'" .  $currentdata[$j] . "',";
		}
		$datastring .= "'" . $currentdata[$j] . "')";

		$q .= "REPLACE INTO `" . $location[$i] . "` VALUES " . $datastring;
	}
	$mysqli->multi_query($q);
	// close connection 
	$mysqli->close();
}


function updatefeatures($projectid,$location,$thermostatlist,$featurenames,$value) {
	//Open a new connection to the MySQL server
	$mysqli = new mysqli('localhost','root','','Pelican_Database');

	//Output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$q = "";
	if($thermostatlist[0]==0)
	{
		$q .= "DELETE FROM `" . $location . "` WHERE `thermostat` = 0 AND `projectid`='" . $projectid . "'";
	}
	else
	{
		$q .= "DELETE FROM `" . $location . "` WHERE `thermostat` != 0 AND `projectid`='" . $projectid . "'";
	}

	for($i=0;$i<sizeof($thermostatlist);$i++)
	{
		$currentfeatures = $featurenames[$i];
		for($j=0;$j<sizeof($currentfeatures);$j++)
		{
			if($currentfeatures!="")
			{
				$q .= ";";
				$datastring = "('" . $projectid . "','" . $thermostatlist[$i] . "','" . $currentfeatures[$j] . "','" . $value . "')";
				$q .= "INSERT INTO `" . $location . "` (`projectid`,`thermostat`,`feature_name`,`value`) VALUES " . $datastring;				
			}
		}
	}

	$mysqli->multi_query($q);
	// close connection 
	$mysqli->close();	

}


function insertprojectid() {
	//Open a new connection to the MySQL server
	$mysqli = new mysqli('localhost','root','','Pelican_Database');

	//Output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$insert = "INSERT INTO `client_legend` (`date`) VALUES (Now())";
	$mysqli->query($insert);
	$currentid = $mysqli->insert_id;
	$mysqli->close();

	return $currentid;
}


 ?>

