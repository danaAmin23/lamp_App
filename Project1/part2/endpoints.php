<?php

/*
purpose :  edit endpoints page for user to edit data
author(s) : Dana Amin
*/
?>

<?php
$con = mysqli_connect('localhost', 'dana', 'dana', 'LAMP2PROJECT');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
} else {

	//	$result = mysqli_query($con, $sql);



	//echo "connected";


	$name;
	$begDist;
	$begGrndHt;
	$begAH;
	$endDist;
	$endAH;
	$id;

	if (isset($_POST['edit']['name'])) {
		$name = $_POST['edit']['name'];
	}

	if (isset($_POST['edit']['begDist']) && is_numeric($_POST['edit']['begDist'])) {
		$begDist = $_POST['edit']['begDist'];
	} //end begDist

	if (isset($_POST['edit']['begGrndHt']) && is_numeric($_POST['edit']['begGrndHt'])) {
		$begGrndHt = $_POST['edit']['begGrndHt'];
	} // end isset begGrndHt


	if (isset($_POST['edit']['begAH']) && is_numeric($_POST['edit']['begAH'])) {
		$begAH = $_POST['edit']['begAH'];
	} // end isset begAH




	if (isset($_POST['edit']['endDist']) && is_numeric($_POST['edit']['endDist'])) {
		$endDist = $_POST['edit']['endDist'];
	}


	if (isset($_POST['edit']['endGrndHt']) && is_numeric($_POST['edit']['endGrndHt'])) {
		$endGrndHt = $_POST['edit']['endGrndHt'];
	} // end endGrndHt


	if (isset($_POST['edit']['endAH']) && is_numeric($_POST['edit']['endAH'])) {
		$endAH = $_POST['edit']['endAH'];

		//multi table query to extract  pt_id mdpt_id and pt_name;
		$sql = "SELECT * FROM paths 
	INNER JOIN pt_endpoints ON paths.pt_id = pt_endpoints.pt_id WHERE pt_name = '" . $name . "' ";
		$result = mysqli_query($con, $sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				//echo "id: ". $row["pt_id"];
				$id = $row["pt_id"];
			}
		} //end if 
		$sql = "UPDATE pt_endpoints SET edpt_bgn_path_dist=  $begDist,edpt_bgn_ground_height= $begGrndHt, edpt_bgn_antenna_height= $begAH,edpt_end_path_dist= $endDist,
	edpt_end_ground_height= $endGrndHt, edpt_end_antenna_height= $endAH  WHERE pt_id = $id";
		$result = mysqli_query($con, $sql);
	} //end isset endAH

} //end else
?>




<html>



<H1>Welcome to the Path Endpoints Edit Page </H1><br>

<h2>To edit a path enter the data in the correct fields and press submit</h2>
<h3>*Path Beginning EndPoints cannot be edited*</h3>

<?php
if (isset($_POST['show'])) {
	$x = $_POST['show'];
	$selected = $x;
	//echo $selected;
}
if (isset($_POST['edit'])) {
	$x = $_POST['edit']['name'];
	$selected = $x;
	//echo $selected;
}
echo '</br>';
?>

<head>
	<style>
		#endpoints {
			margin-top: 1pc;
			border: 1px solid black;
			width: 40pc;
			padding: 5px;
		}

		;
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
	</script>

</head>


<body>

	<script>
		//$.post("getPath.php", onNewPost);

		var onNewPost = function(response) {
			if (response.status == "OK") {



				$("#txtHint2").html("<form id = 'endpoints'><label>Path Name : </label><label id ='pathName'></label></br></br><label>Beginning Endpoint Distance : </label><label id ='begDist'></label></br></br><label>Beginning Endpoint Ground Height : </label><input type ='text' id ='begGrndHt'></input></br></br><label> Beginning Endpoint Antenna Height : </label><input type ='text' id ='begAH' style = 'width:20pc;'></input></br></br><label>Ending Endpoint Distance : </label><input type ='text' id ='endDist'></br></br><label>Ending Endpoint Ground Height : </label><input type ='text' id ='endGrndHt'></br></br><label>Ending Endpoint Antenna Height : </label><input type ='text' id ='endAH'></br></br><input type='button' class 'button' value='update' onclick='editEndpoints()'></input><input type ='button' value ='cancel' onclick='cancelEndpoints()' style = 'margin-left:1pc;'></input><input type ='button' value ='back' onclick='back()' style = 'margin-left:1pc;'></input></form>");


				var r = "<?php echo $selected ?>";

				var str = r
				var res = str.replace(/\D/g, "");
				var res = parseInt(res);
				res = res - 1;

				$("#pathName").text(response[0][res].pt_name);
				$("#begDist").text(response[1][res].edpt_bgn_path_dist);
				$("#begGrndHt").attr("value", response[1][res].edpt_bgn_ground_height);
				$("#begAH").attr("value", response[1][res].edpt_bgn_antenna_height);
				$("#endDist").attr("value", response[1][res].edpt_end_path_dist);
				$("#endGrndHt").attr("value", response[1][res].edpt_end_ground_height);
				$("#endAH").attr("value", response[1][res].edpt_end_antenna_height);

			} //end if




		}; //end new post


		$.get("getPath.php", onNewPost);
	</script>





	<div id="txtHint2">
		</b></div>
	<br><br>

	</div>




</body>

</html>