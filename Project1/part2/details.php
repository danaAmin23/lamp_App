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
	/*
1) The data item exists.
 2) The data item does not begin or end with spaces or tabs.
 3) If the data item is a required item, it must not be empty. 
 4) The data item must not exceed its maximum length and/or must be within its specified range of values.
*/

	//isset
	$name;
	$length;
	$note;
	$desc;
	$sql;


	if (isset($_POST['edit']['name'])) {
		if (strlen($_POST['edit']['name']) > 0 &&  strlen($_POST['edit']['name']) < 100) {
			$name = $_POST['edit']['name'];
		} //end  name strlen 
	} //
	if (isset($_POST['edit']['length']) && is_numeric($_POST['edit']['length'])) {
		$length = $_POST['edit']['length'];
	} //end length isset

	//note
	if (isset($_POST['edit']['note'])) {
		if (strlen($_POST['edit']['note']) > 0  && strlen($_POST['edit']['note']) < 65535) {
			$note = $_POST['edit']['note'];
		} //end note strlen
	} //end note isset


	if (isset($_POST['edit']['desc'])) {
		if (strlen($_POST['edit']['desc']) > 0  && strlen($_POST['edit']['desc']) < 255) {
			$desc = $_POST['edit']['desc'];
		} //end desc strlen
	} //end desc isset


	if (isset($_POST['edit']['desc'])) {


		


		$sql = "UPDATE paths SET pt_length= '" . $length . "',pt_description= '" . $desc . "',pt_note= '" . $note . "' WHERE pt_name = '" . $name . "'";
		$result = mysqli_query($con, $sql);
	} //end isset


} //end else



?>

<html>
<H1>Welcome to the Path Details Edit Page </H1><br>
<h2>To edit a path enter the data in the correct fields and press submit</h2>
<br>
<h3>*Path Name cannot be edited*</h3>

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

?>
<style>
	#details {
		margin-top: 1pc;
		border: 1px solid black;
		width: 25pc;
		padding: 5px;
	};
</style>


<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
</head>


<body>

	<script>

		var onNewPost = function(response) {

			if (response.status == "OK") {

				$("#txtHint2").html("<form id = 'details'><label>Path Name : </label><label id ='pathName'></label></br></br><label>Path Length : </label><input type ='text' id ='pathLength'></input></br></br><label>Path Description : </label><input type ='text' id ='pathDesc'></input></br></br><label>Path Note : </label><input type ='text' id ='pathNote' style = 'width:20pc;'></input></br></br><input type='button' class 'button' value='update' onclick='editDetails()'></input><input type ='button' value ='cancel' onclick='cancelDetails()' style = 'margin-left:1pc;'></input><input type ='button' value ='back' onclick='back()' style = 'margin-left:1pc;'></input></form>");

				var r = "<?php echo $selected ?>";
				var str = r
				var res = str.replace(/\D/g, "");
				var res = parseInt(res);
				res = res - 1;

				$("#pathName").text(response[0][res].pt_name);
				$("#pathLength").attr("value", response[0][res].pt_length);
				$("#pathDesc").attr("value", response[0][res].pt_description);
				$("#pathNote").attr("value", response[0][res].pt_note);
			} //end if

		}; //end new post

		$.post("getPath.php", onNewPost);
	</script>





	<div id="txtHint2">
		</b></div>
	<br><br>

	</div>




</body>

</html>