function linksdisplay(currentpage) {
	storagename = sessionStorage.getItem("pelicanlinkstoragename");
	linkposition = localStorage.getItem(storagename);
	for(i=0;i<6;i++)
	{
		idname = "link" + i;
		currentlink = document.getElementById(idname);
		if(i<=linkposition)
		{
			currentlink.style.display = "block";
		}
		else
		{
			currentlink.style.display = "none";
		}
		if(i==currentpage)
		{
			currentlink.style = "background-color:#22c3bb;color:black";
		}
	}

}


function updatepersontype(type) {
	Contractor_Questions = document.getElementById("Contractor_Questions");
	Customer_Questions = document.getElementById("Customer_Questions");
	part2 = document.getElementById("part2");
	part2.style.display = "inline";

	if (type == 'Contractor')
	{
		Contractor_Questions.style.display = "inline";
		Customer_Questions.style.display = "inline";
	}
	else
	{
		Contractor_Questions.style.display = "none";
		Customer_Questions.style.display = "inline";
	}

}

function updateQ4total() {
	idname="4_1";
	total = 0;
	i = 1;
	check = true;
	while(document.getElementById(idname))
	{
		currentvalue = document.getElementById(idname).value;
		if (currentvalue!=='')
		{
			total = total + parseInt(currentvalue);
		}
		i++;
		idname = "4_" + i.toString();
	}
	sessionStorage.setItem("Pelican_HVAC_Total",total);
	Q4total = document.getElementById("Q4total");
	HVAC_Total = document.getElementById("HVAC_Total");
	Q4total.innerHTML = total;
	HVAC_Total.value = total;
}

function showQ4(x) {
	x = Number(x);
	Q4 = document.getElementById("Q4block");
	if (x > 0)
	{
		Q4.style.display = "inline";
	}
	else
	{
		Q4.style.display = "none";
	}
}


function page1displaycheck() {
	var check = $("input[name='1']:checked").val();
	if (typeof check !== 'undefined')
	{
		updatepersontype(check);
	}
}


function page2displaycheck() {
	var check = document.getElementById("Number_of_buildings").value;
	if(check!=="")
	{
		showQ4(check);
		updateQ4total();
	}
}


function storeidlocally(id) {
	var insertid = [id];
	if(localStorage.getItem("PelicanExpertSystemid") !== null)
	{

		idlistdata = localStorage.getItem("PelicanExpertSystemid");
		idlist = JSON.parse(idlistdata);
		check = true;
		for(i=0;i<idlist.length;i++)
		{
			if(idlist[i] === id)
			{
				check = false;
			}
		}
		if(check==true && id !== "skip")
		 {
		 	idlist = idlist.concat(insertid); 
		 	localStorage.setItem("PelicanExpertSystemid",JSON.stringify(idlist));
		 }
	}
	else if(id !== "skip")
	{
		localStorage.setItem("PelicanExpertSystemid",JSON.stringify(insertid));
	}
}


function validatepage3() {
	x = document.getElementsByName("5_0[]");
	check = false;
	for (var i = 0; i < x.length; i++) {
	    if (x[i].checked == true) {
	        check = true;
	    }
	}
	return check;
}





