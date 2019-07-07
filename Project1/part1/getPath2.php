<?php

/*
process reset web form
author(s) : Dana Amin*/
?>



<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>

    <?php

    // echo $_GET['q']."<br>";

    $q = $_GET['q'];

    $con = mysqli_connect('localhost', 'dana', 'dana', 'LAMP2PROJECT');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    } else {

        //echo "connected  "  . $q;
    }

    //echo "Paht name : ".$q;



    //multi table query to extract  pt_id mdpt_id and pt_name;
    $sql = "SELECT * FROM paths 
    INNER JOIN pt_endpoints ON paths.pt_id = pt_endpoints.pt_id
    INNER JOIN pt_midpoints ON paths.pt_id = pt_midpoints.pt_id WHERE pt_name = '$q'";



    // $sql = "SELECT * FROM paths WHERE pt_name = '$q'";
    // echo "<br><br>".$sql;
    // echo "<br>";
    $id;
    $pathName;
    $path;
    $result = mysqli_query($con, $sql);
    $mdpt_array = [];
    $mdpt;
    if ($result->num_rows > 0) {

        echo $q . "<h2> has been reset</h2>";

        while ($row = $result->fetch_assoc()) {
            //echo "id: ". $row["pt_id"];
            $id = $row["pt_id"];
            $pathName = $row["pt_name"];
            $path = substr($pathName, 5, 1);
            $path = $path;
            //echo "path name is :".$path."<br>";
            //echo "midpoint is :" .$row["mdpt_id"];
            $mdpt = $row["mdpt_id"] + 0;
            array_push($mdpt_array, $mdpt);
            //echo "records found";

        }
    } else {
        echo ("Error description: " . mysqli_error($con));
    }

    $lines = array();

    $file = fopen('../prm/path0' . $path . '.csv', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        array_push($lines, $line);
    }

    /* reset paths table values to original from .csv file  */

    $path_name = $lines[0][0];
    $path_length = $lines[0][1];
    $path_description = $lines[0][2];
    $path_note = $lines[0][3];

    /* update query  */

    $sql = "UPDATE paths SET pt_name = '$path_name', pt_length = $path_length, pt_description =  '$path_description',pt_note = '$path_note'  WHERE pt_id =  $id";
    $result = mysqli_query($con, $sql);



    /* reset pt_endpoints table values to original from .csv file  */

    $beg_path = $lines[1][0];
    $beg_grnd_ht = $lines[1][1];
    $beg_ant_ht = $lines[1][2];
    $end_path = $lines[2][0];
    $end_grnd_ht = $lines[2][1];
    $end_ant_ht = $lines[2][2];

    $sql = "UPDATE pt_endpoints SET edpt_bgn_path_dist = $beg_path, edpt_bgn_ground_height = $beg_grnd_ht, edpt_bgn_antenna_height = $beg_ant_ht,edpt_end_path_dist = $end_path, edpt_end_ground_height = $end_grnd_ht,edpt_end_antenna_height =$end_ant_ht  WHERE pt_id =  $id";
    $result = mysqli_query($con, $sql);


    $y = 0;

    for ($x = 3; $x < 17; $x++) {


        $mdpt_array[$y];
        // echo  "<br>".$x."  ".$lines[$x][0]." "."<br>";
        $mdpt_bgn_path_dist = $lines[$x][0];
        //	echo  $x."  ".$lines[$x][1]." "."<br>";
        $mdpt_ground_height = $lines[$x][1];
        //      echo  $x."  ".$lines[$x][2]." "."<br>";
        $mdpt_terrain_type = $lines[$x][2];
        //    echo  $x."  ".$lines[$x][3]." "."<br>";
        $obs_height = $lines[$x][3];
        //  echo  $x."  ".$lines[$x][4]."<br>"."<br>";
        $obs_type = $lines[$x][4];

        //echo $sql."<br>";


        $sql = "UPDATE pt_midpoints SET mdpt_bgn_path_dist = $mdpt_bgn_path_dist, mdpt_ground_height = $mdpt_ground_height, mdpt_terrain_type = '$mdpt_terrain_type',obs_height = $obs_height,obs_type = '$obs_type '  WHERE mdpt_id =  $mdpt_array[$y]";
        $result = mysqli_query($con, $sql);
        $y++;
    } //end for pt_endpoints


    // var_dump($mdpt_array);
    mysqli_close($con);
    ?>



</body>

</html>