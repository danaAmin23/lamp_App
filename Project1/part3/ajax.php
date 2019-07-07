<?php

/*
purpose :, display  web form
author(s) : Dana Amin
*/

?>



<?php
$con = mysqli_connect('localhost', 'dana', 'dana', 'LAMP2PROJECT');
if (!$con) {
	die('Could not connect: ' . mysqli_error($con));
} else {

	//echo "Connected";

} //end db con


$sql = "SELECT * FROM paths";
$result = mysqli_query($con, $sql);


$options = array();

while ($row = mysqli_fetch_array($result)) {
	array_push($options, $row['pt_name']);
} //end while

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



<form>
	<h1> Choose Path Curvature From Below</h1><br><b>Curvature
		<select name="curv" id="curv">
			<option value='4/3'> 4/3 </option>
			<option value='1'> 1 </option>
			<option value='2/3'> 2/3 </option>
			<option value='infinite'> infinite </option>


		</select>
</form>


<br>
<br>
<br>
<input id='calc' value='calc' type='button'>

<br>
<br>
<input type="button" value="HOME" onClick="window.location = '../index.php';">


<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script type="text/javascript" src="canvasjs.min.js"></script>


	<style>
		td {
			text-align: center;
		}

		;

		.container {
			width: 50%;
			height: 50%;
		}

		img {
			opacity: 0.4;
		}
	</style>
</head>


<body>

	<script>
		//ground height

		/***********Part 2 - A) create a web form that shows all paths currently in the db ****************/

		var options = <?php echo json_encode($options); ?>;

		//set options according to database values
		$.each(options, function(i, options) {
			$('#path').append($('<option>', {
				value: i,
				text: options
			}));
		});



		//path select



		/***********Part 2 - B)  Show all data in details via json format and ajax****************/



		//on select change
		$('#calc').click(function() {

			var r = $('#path').val();

			var s = $("#path option:selected").text();
			var p = s.match(/\d+/);
			p = parseInt(p);





			var curv = $('#curv').val();
			var factor = curv;
			console.log("factor " + curv);
			var cfactor;
			//alert(curv);

			if (curv == '4/3') {
				cfactor = 17;
			}
			if (curv == '1') {
				cfactor = 12.75;
			}
			if (curv == '2/3') {
				cfactor = 8.5;
			}
			if (curv == 'infinite') {
				cfactor = 0;
			}

			$.post("getPath.php", onNewPost);

			var numberArray = [];
			var dist = [];
			var dateArray = [];

			var onNewPost = function(response) {
				//	console.log(r);
				//	console.log(response);
				if (response.status == "OK") {


					$("#h1").html("<h1>Path Details</h1> ");
					$("#h2").html("<h1>Path EndPoints</h1> ");
					$("#h3").html("<h1>Path MidPoints</h1> ");

					$("#txtHint").html("<table id=\"table1\" border=\"1\"></table>");
					$("#txtHint2").html("<table id=\"table2\" border=\"1\"></table>");
					$("#txtHint3").html("<table id=\"table3\" border=\"1\"></table>");

					$("#table1").html("<tr><th>Path ID</th><th>Name</th><th>Length</th><th>Description</th><th>Note</td></tr>");


					$("#table2").html("<tr><th>pt_id</th><th>bgn_path_dist</th><th> bgn_ground_height</th><th>bgn_antenna_height</th><th>end_path_dist</th><th>end_ground_height</th><th>end_antenna_height</td></tr>");


					$("#table3").html("<tr><th>mdpt_id</th><th>bgn_path_dist</th><th> ground_height</th><th>terrain type</th><th>obs height</th><th>obs type</th><th>pt_id</th><th>Curvature Height</th><th>Apparent Gound and Obstruction Height</th><th>1st Freznel Zone</th><th>Total CLearance Height</th></tr>");




					$("#table1").append(
						"<tr><td>" + response[0][r].pt_id +
						"</td><td>" + response[0][r].pt_name +
						"</td><td>" + response[0][r].pt_length +
						"</td><td>" +
						response[0][r].pt_description +
						"</td><td>" +

						response[0][r].pt_note





						+
						"</td></tr>"

					); //end append 

					$('#details').val(parseInt(r) + 1);



					$("#table2").append(


						"<tr><td>" + response[1][r].pt_id +
						"</td><td>" + response[1][r].edpt_bgn_path_dist +
						"</td><td>" + response[1][r].edpt_bgn_ground_height +
						"</td><td>" +
						response[1][r].edpt_bgn_ground_height +
						"</td><td>" +
						response[1][r].edpt_end_path_dist

						+
						"</td><td>" +
						response[1][r].edpt_end_ground_height

						+
						"</td><td>" +
						response[1][r].edpt_end_antenna_height



						+
						"</td></tr>"

					); //end append

					var mdpts = [0.0];
					var curvs = [];
					var freznel = [];


					for (var i = 0; i < response[2].length; i++) {

						var edpt = response[1][r].pt_id;

						var mdpt = response[2][i].pt_id;

						if (edpt == mdpt) {
							//	console.log(response[2][i].mdpt_bgn_path_dist);
							mdpts.push(parseFloat(response[2][i].mdpt_bgn_path_dist));





						} //end if
					} //end for 


					console.log("max is " + Math.max(...mdpts));
					var max = Math.max(...mdpts);
					//set counter variable
					var k = 0;


					$('#endpoints').val(parseFloat(r) + 1);

					for (var i = 0; i < response[2].length; i++) {
						var edpt = response[1][r].pt_id;
						var mdpt = response[2][i].pt_id;

						if (edpt == mdpt) {

							var d = max;

							//retrieve max
							var d1 = response[2][i].mdpt_bgn_path_dist;
							var d2 = d - mdpts[k];
							k++;

							//curvature
							var curv = (d2 * d1) / cfactor;
							//console.log("curvature : " + curv);
							var curv = curv.toFixed(4);

							//var curv = parseInt(curv);
							//Apparent GROund and Height OBstruction 
							var agh = parseInt(response[2][i].mdpt_ground_height) + parseInt(response[2][i].obs_height);
							var agh = parseFloat(curv) + agh;
							numberArray.push(agh);

							var grndHt = parseFloat(response[1][r].edpt_end_ground_height);

							//freznel zone
							var f1 = (d1 * d2) / (parseInt(response[0][r].pt_length) * grndHt);
							var f2 = Math.sqrt(f1);
							f2 = f2 * 1.73;
							f2 = f2 * 10;
							f2 = f2.toFixed(4);
							freznel.push(parseFloat(f2))

							console.log(freznel[0])

							//total clearance height
							var tcht = agh + parseFloat(f2);

							tcht = tcht.toFixed(4);

							curvs.push(parseInt(agh));




							$("#table3").append(



								"<tr><td>" + response[2][i].mdpt_id +
								"</td><td>" + response[2][i].mdpt_bgn_path_dist +
								"</td><td>" + response[2][i].mdpt_ground_height +
								"</td><td>" +
								response[2][i].mdpt_terrain_type +
								"</td><td>" +
								response[2][i].obs_height

								+
								"</td><td>" +
								response[2][i].obs_type

								+
								"</td><td>" +
								response[2][i].pt_id

								+
								"</td><td>" +
								curv


								+
								"</td><td>" +
								agh

								+
								"</td><td>" +
								f2

								+
								"</td><td>" +
								tcht




								+
								"</td></tr>"


							); //end append



						}; //end inner if


					}; //end for




				} //end if
				var chart = new CanvasJS.Chart("chartContainer0", {
						title: {
							text: s + " with a curvature of " + factor
						},
						data: [

							{
								type: "spline",
								showInLegend: true,
								axisYIndex: 1, //Defaults to Zero
								name: "Ground + Obstruction",
								xValueFormatString: "####",
								dataPoints: [{
										x: mdpts[1],
										y: curvs[0]
									},
									{
										x: mdpts[2],
										y: curvs[1]
									},
									{
										x: mdpts[3],
										y: curvs[2]
									},
									{
										x: mdpts[4],
										y: curvs[3]
									},
									{
										x: mdpts[6],
										y: curvs[4]
									},
									{
										x: mdpts[6],
										y: curvs[5]
									},
									{
										x: mdpts[7],
										y: curvs[6]
									},
									{
										x: mdpts[8],
										y: curvs[7]
									},
									{
										x: mdpts[9],
										y: curvs[8]
									},
									{
										x: mdpts[10],
										y: curvs[9]
									},
									{
										x: mdpts[11],
										y: curvs[10]
									},
									{
										x: mdpts[12],
										y: curvs[11]
									},
									{
										x: mdpts[13],
										y: curvs[12]
									},
									{
										x: mdpts[14],
										y: curvs[13]
									}
								]
							},
							{
								type: "spline",
								showInLegend: true,
								//axisYIndex: 0, //Defaults to Zero
								name: "freznel",
								dataPoints: [{
										x: mdpts[1],
										y: parseFloat(freznel[0])
									},
									{
										x: mdpts[2],
										y: freznel[1]
									},
									{
										x: mdpts[3],
										y: freznel[2]
									},
									{
										x: mdpts[4],
										y: freznel[3]
									},
									{
										x: mdpts[6],
										y: freznel[4]
									},
									{
										x: mdpts[6],
										y: freznel[5]
									},
									{
										x: mdpts[7],
										y: freznel[6]
									},
									{
										x: mdpts[8],
										y: freznel[7]
									},
									{
										x: mdpts[9],
										y: freznel[8]
									},
									{
										x: mdpts[10],
										y: freznel[9]
									},
									{
										x: mdpts[11],
										y: freznel[10]
									},
									{
										x: mdpts[12],
										y: freznel[11]
									},
									{
										x: mdpts[13],
										y: freznel[12]
									},
									{
										x: mdpts[14],
										y: freznel[13]
									}
								]
							}
						]
					},

				); //end chart 
				chart.render();

			}; //end new post


			$.get("getPath.php", onNewPost);



		}); //end on change


		/***********Part 2 - c) on radio click display a form that has general path details ****************/
	</script>

	<div id="chartContainer0" style="height: 360px; width: 100%;"></div>






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