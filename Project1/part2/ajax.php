<?php

/*
purpose :, loads html table via ajax
author(s) : Dana Amin
*/

?>

<?php       
$con = mysqli_connect('localhost','dana','dana','LAMP2PROJECT');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
else {

	//echo "Connected";

}//end db con


$sql="SELECT * FROM paths";
$result = mysqli_query($con,$sql);


$options = array();

while($row = mysqli_fetch_array($result)) {
array_push($options,$row['pt_name'] );
}//end while

//set max of array 
$max = sizeof($options);
?>



<html>

<form>
<h1> Choose From drop down menu a path to be displayed</h1><br><b>Path
<select name="paths" id="path">
    <option disabled selected value> -- select an option -- </option>

  </select>
</form>



<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<style>
td{
text-align:center;
};
</style>
</head>


<body>
	<br><br><br>
<input type="button" value="HOME" onClick="window.location = '../index.php';">

<script>


/***********Part 2 - A) create a web form that shows all paths currently in the vadb****************/
 
var options = <?php echo json_encode($options); ?>;

//set options according to database values
$.each(options, function (i, options) {
    $('#path').append($('<option>', { 
        value: i,
        text : options
    }));
});


//path select



/***********Part 2 - B)  Show all data in details via json format and ajax****************/



//on select change
$('#path').change(function() {

var r = $('#path').val();


var onNewPost = function (response){
//console.log(response); 
if(response.status == "OK"){


$("#h1").html("<h1>Path Details</h1> ");
$("#h2").html("<h1>Path EndPoints</h1> ");
$("#h3").html("<h1>Path MidPoints</h1> ");

$("#txtHint").html("<table id=\"table1\" border=\"1\"></table>");
	$("#txtHint2").html("<table id=\"table2\" border=\"1\"></table>");
	$("#txtHint3").html("<table id=\"table3\" border=\"1\"></table>");		


 $("#table1").html("<tr><th>Path ID</th><th>Name</th><th>Length</th><th>Description</th><th>Note</th><th>Click button to edit the path detail data</td></tr>");


 $("#table2").html("<tr><th>pt_id</th><th>bgn_path_dist</th><th> bgn_ground_height</th><th>bgn_antenna_height</th><th>end_path_dist</th><th>end_ground_height</th><th>end_antenna_height</th><th>CLick path to edit path endpoint data</td></tr>");


 $("#table3").html("<tr><th>mdpt_id</th><th>bgn_path_dist</th><th> ground_height</th><th>terrain type</th><th>obs height</th><th>obs type</th><th>pt_id</th><th>Click a midpointto edit that  midpoint's data  </td></tr>");



	$("#table1").append(
					  "<tr><td>" + response[0][r].pt_id
					+ "</td><td>" + response[0][r].pt_name
					+ "</td><td>" + response[0][r].pt_length
					+ "</td><td>" + 
response[0][r].pt_description
					+ "</td><td>" +

response[0][r].pt_note

	+ "</td><td>" + "<input type = 'button' id = 'details' name = 'details' onclick='showDetails()' >"






+ "</td></tr>"

				);//end append 

$('#details').val(parseInt(r)+1);



	$("#table2").append(


  "<tr><td>" + response[1][r].pt_id
					+ "</td><td>" + response[1][r].edpt_bgn_path_dist
					+ "</td><td>" + response[1][r].edpt_bgn_ground_height 
					+ "</td><td>" + 
response[1][r].edpt_bgn_antenna_height
					+ "</td><td>" +
response[1][r].edpt_end_path_dist

+ "</td><td>" +
response[1][r].edpt_end_ground_height

+ "</td><td>" +
response[1][r].edpt_end_antenna_height

	+ "</td><td>" + "<input type = 'button' id = 'endpoints' name = 'endpoints' onclick='showEndpoints()' >"



+ "</td></tr>"

				);//end append

$('#endpoints').val(parseInt(r)+1);

for (var i = 0; i < response[2].length; i++){



var edpt = response[1][r].pt_id; 

var mdpt = response[2][i].pt_id;

if(edpt == mdpt){

$("#table3").append(



  "<tr><td>" + response[2][i].mdpt_id
					+ "</td><td>" + response[2][i].mdpt_bgn_path_dist
					+ "</td><td>" + response[2][i]. mdpt_ground_height
					+ "</td><td>" + 
response[2][i].mdpt_terrain_type 
					+ "</td><td>" +
response[2][i].obs_height

+ "</td><td>" +
response[2][i].obs_type

+ "</td><td>" +
response[2][i].pt_id

/*
	+ "</td><td>" + "<input type = 'button' onclick = 'showMidpoints()' id='midpoints"+ response[2][i].mdpt_id  + "'"+ "name='midpoints' value ="+response[2][i].mdpt_id + ">"
*/
	+ "</td><td>" + "<input type = 'button' onclick = 'showMidpoints(this.value)'   id='midpoints name='midpoints' value ="+response[2][i].mdpt_id + ">"




+ "</td></tr>"


				);//end append






};//end inner if


};//end for







}//end if

		

	};//end new post


	$.get("getPath.php", onNewPost);







});//end on change



/***********Part 2 - c) on radio click display a form that has general path details ****************/


</script>


<div id="h1"></div>
<!--h3>Details</h3-->
<div id="txtHint">
 </b></div>
<br><br>


<!--h3>Endpoints</h3-->
<div id="h2"></div>
<div id="txtHint2">
</b></div>
</body>

<br><br>

<div id="h3"></div>
<!--h3>Midpoints</h3-->
<div id="txtHint3">
</b></div>
</body>
</html>





