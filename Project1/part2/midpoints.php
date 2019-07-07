<?php

/*
purpose : edit details page for user to edit details data
author(s) : Dana Amin,
*/
?>


<?php



$con = mysqli_connect('localhost', 'dana', 'dana', 'LAMP2PROJECT');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
} else {


$name;
$begDist;
$grndHt;
$terType;
$obsHt;
$obsType;

if (isset($_POST['edit']['begDist'])) {
	$begDist = $_POST['edit']['begDist'];
}

if (isset($_POST['edit']['grndHt']) && is_numeric($_POST['edit']['grndHt'])) {
	$grndHt = $_POST['edit']['grndHt'];
}//end grndHt

if (isset($_POST['edit']['terType'])) {
	if (strlen($_POST['edit']['terType']) > 0 && strlen($_POST['edit']['terType']) < 50) {
		$terType = $_POST['edit']['terType'];
	} //end strLen
} //end isset terType


if (isset($_POST['edit']['obsHt']) && is_numeric($_POST['edit']['obsHt'])) {
	$obsHt = $_POST['edit']['obsHt'];
}//end obsHt

if (isset($_POST['edit']['obsType'])) {
	if (strlen($_POST['edit']['obsType']) > 0 && strlen($_POST['edit']['obsType']) < 50) {
		$obsType = $_POST['edit']['obsType'];
	} //end strLen
} //end isset obsType




	//echo "connected";

//mdpt_id | mdpt_bgn_path_dist | mdpt_ground_height | mdpt_terrain_type | obs_height | obs_type  | pt_id

/*
	$name = mysqli_real_escape_string($con, $_POST['edit']['name']);
	$begDist = mysqli_real_escape_string($con, $_POST['edit']['begDist']);
	$grndHt = mysqli_real_escape_string($con, $_POST['edit']['grndHt']);
	$obsHt = mysqli_real_escape_string($con, $_POST['edit']['obsHt']);
	$obsType = mysqli_real_escape_string($con, $_POST['edit']['obsType']);
	$mdpt_Id = $_POST['edit']['name'];
	echo "mdpt  is"    .$mdpt_Id;
	
*/
if (isset($_POST['edit'])) {

	$mdpt_Id = $_POST['edit']['mdpt'];
	$sql = "UPDATE pt_midpoints 
	SET mdpt_ground_height = ". $grndHt . ",mdpt_terrain_type= " . "'$terType'" . ",obs_height= " . $obsHt . ",obs_type= " ."' $obsType '". 
	" WHERE mdpt_id = " . $mdpt_Id;
	$result = mysqli_query($con, $sql);


}//

if (isset($_POST['show'])) {
	$x = $_POST['show'];
	$selected = $x;
	//echo $selected;
}
if (isset($_POST['edit']['mdpt'])) {
	$x = $_POST['edit']['mdpt'];
	$selected = $x;
	//echo $selected;
}

	
	
	//echo "<label id = 'nameval'>" . $name . "</label>";
	
	echo '</br>';


} //end else
?>




<html>



<H1>Welcome to the Path Midpoint Edit Page </H1><br>

<h2>To edit a path enter the data in the correct fields and press submit</h2>




<head>


	<style>
		#details {
			margin-top: 1pc;
			border: 1px solid black;
			width: 40pc;
			padding: 5px;
		};
	</style>
</head>


<body>

	<script>

		var onNewPost = function(response) {
			if (response.status == "OK") {
				var r = "<?php echo $selected ?>";
				$("#txtHint2").html("<form id = 'details'><label>Path Name : </label><label id ='pathName'></label></br></br><label id = 'lblMdpt'>Midpoint : </label><label id = 'mdpt'></label></br></br><label>Beginning Midpoint Distance : </label><label id ='MdptBgnPathDist'></label></br></br><label> Midpoint Ground Height :</label><input type ='text' id ='MdptGrndHt'></input></br></br><label>Midpoint Terrain Type : </label><input type ='text' id ='MdptTerrainType' style = 'width:20pc;'></input></br></br><label>Midpoint Obstruction Height : </label><input type ='text' id ='MdptObsHt' style = 'width:20pc;'></input></br></br><label>Midpoint Obstruction Terrain Type : </label><input type ='text' id ='MdptObsType' style = 'width:20pc;'></input></br></br><input type='button' class 'button' value='update' onclick='editMidpoints()'></input><input type ='button' value ='cancel' onclick='cancelMidpoints()' style = 'margin-left:1pc;'></input><input type ='button' value ='back' onclick='back()' style = 'margin-left:1pc;'></input></form>");
				$("#mdpt").text(r);
				//set to 0 index
				r = r-1;

				
				$("#pathName").text(response[2][r].pt_id);
				$("#MdptBgnPathDist").text(response[2][r].mdpt_bgn_path_dist);
				$("#MdptGrndHt").attr("value", response[2][r].mdpt_ground_height);
				$("#MdptTerrainType").attr("value", response[2][r].mdpt_terrain_type);
				$("#MdptObsHt").attr("value", response[2][r].obs_height);
				$("#MdptObsType").attr("value", response[2][r].obs_type);


			} //end if




		}; //end new post


		$.post("getPath.php", onNewPost);
	</script>





	<div id="txtHint2">
	

		<br></div>
	<br><br>

	</div>




</body>

</html>