<?php 

/*
purpose : process reset web form
author(s) : Dana Amin,
*/
  ?>

<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
    color:white;
}

table, td, th {
    border: 1px solid white;
    padding: 5px;
    text-align: center;
    
}

</style>
</head>
<body>

<?php
$q = intval($_GET['q']);



$con = mysqli_connect('localhost','dana','dana','LAMP2PROJECT');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}


$sql="SELECT * FROM paths WHERE pt_id = 7 ";
$sql = "wtf";
echo $sql;
$result = mysqli_query($con,$sql);



echo "<table>
The Following table displays General Path Information

<tr>
<th>Name</th>
<th>Length</th>
<th>Description</th>
<th>Note</th>

</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['pt_name'] . "</td>";
    echo "<td>" . $row['pt_length'] . "</td>";
    echo "<td>" . $row['pt_description'] . "</td>";
    echo "<td>" . $row['pt_note'] . "</td>";
    echo "</tr>";
}


$sql="SELECT * FROM pt_endpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);




echo "<table>
The Following table displays  Path EndPoint Information

<tr>
<th>Beg Path Distance</th>
<th>Beg Ground Height</th>
<th>Beg Antenna Height</th>
<th>Beg Path Distance</th>
<th>End Ground Height</th>
<th>End Antenna Height</th>



</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['edpt_bgn_path_dist'] . "</td>";
    echo "<td>" . $row['edpt_bgn_ground_height'] . "</td>";
    echo "<td>" . $row['edpt_bgn_antenna_height'] . "</td>";
    echo "<td>" . $row['edpt_end_path_dist'] . "</td>";
    echo "<td>" . $row['edpt_end_ground_height'] . "</td>";
    echo "<td>" . $row['edpt_end_antenna_height'] . "</td>";
    echo "</tr>";
}
echo "</table>";


$sql="SELECT * FROM pt_midpoints WHERE pt_id = '".$q."'";
$result = mysqli_query($con,$sql);


echo "<table>
The Following table displays  Path EndPoint Information

<tr>
<th>Beg Path Distance</th>
<th>Beg Ground Height</th>
<th>Terrain Type</th>
<th>Obstruction Height</th>
<th>Obstruction Type</th>



</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['mdpt_bgn_path_dist'] . "</td>";
    echo "<td>" . $row['mdpt_ground_height'] . "</td>";
    echo "<td>" . $row['mdpt_terrain_type'] . "</td>";
    echo "<td>" . $row['obs_height'] . "</td>";
    echo "<td>" . $row['obs_type'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>
</body>
</html>












