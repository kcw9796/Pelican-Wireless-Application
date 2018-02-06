<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="PelicanSystemStyling.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<title>Pelican Product Selector</title>
</head>
<body>

	<div id="idchoices" style="display:none">
		<h1 id="centertitle"><strong>Pelican Product Selector</strong></h1>
		
		
		<form id="idchoiceform" method="post" action="PelicanIndexProcessing.php">
				
			<fieldset id="idbtnfield">
				<div style="display:inline-block">
					<input class="chooseidbtn" type="submit" name="submitinitial" value="Create New Project">
				</div>

				
				<div class="dropdown" style="display:inline-block">
				  <button class="chooseidbtn" disabled>Choose Existing Project</button>
				  <div class="dropdown-content" id="links">

				  </div>
				</div>
				
			</fieldset>

		</form>		
		
		
	</div>


	<script type="text/javascript">
		//TO REMOVE LOCALLY STORED IDS: localStorage.removeItem("PelicanExpertSystemid");
		if(localStorage.getItem("PelicanExpertSystemid") !== null)
		{
			idchoices = document.getElementById("idchoices");
			idchoices.style = "display:inline";
			projectiddata = localStorage.getItem("PelicanExpertSystemid");
			projectid = JSON.parse(projectiddata);

			links = document.getElementById("links");
			for(i=0;i<projectid.length;i++)
			{
				currentid = projectid[i];
				newlink = document.createElement("label");
				newlink.setAttribute("onclick","chooseid(this.value)");
				newlink.value = currentid;
				newlink.innerHTML = "Project Number " + (i+1);
				links.appendChild(newlink);
			}
			
		}
		else
		{
			location.replace("PelicanIndexProcessing.php");
		}

		function chooseid($id) {
			links = document.getElementById("links");
			id = document.createElement("input");
			id.type = "hidden";
			id.name = "initialid";
			id.value = $id;
			links.appendChild(id);
			document.getElementById("idchoiceform").submit();

		}
	
	</script>




</body>
</html>


