<?php

/*
purpose : home page for user to upload csv file
author(s) : Dan Amin
*/
?>


<style>
    body {
        background-image: url("./part1/images/tower.jpg");
        color: white;
    }
</style>

<?php

$target_dir = "prm/";

if (isset($_POST["submit"])) {

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


    $csv_mimetypes = array(
        "text/csv",
        "text/plain",
        "application/csv",
        "text/comma-separated-values",
        "application/excel",
        "application/vnd.ms-excel",
        "application/vnd.msexcel",
        "text/anytext",
        "application/octet-stream",
        "application/txt",
    );
    if (in_array($_FILES["fileToUpload"]["type"], $csv_mimetypes)) {
        // possible CSV file
        // could also check for file content at this point

        $check = true;
    } else {

        $check = false;
    }
    if ($check !== false) {
        echo "File is csv file - " . $check["mime"] . "." . $_FILES["fileToUpload"]["name"];
        $uploadOk = 1;
    } else {
        echo "File is not a csv file.";
        $uploadOk = 0;
    }


    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<br>" . "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "<br>" . "Sorry, your file is too large.";
        $uploadOk = 0;
    }




    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<br>" . "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        } else {
            echo "<br>" . "Sorry, there was an error uploading your file.";
        }
    }


    $conn = connect_db();
    $lines = array();

    $uplFIle = $_FILES["fileToUpload"]["name"];
    $file = fopen('prm/' . $uplFIle, 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        //  $line[0] = '1004000018' in first iteration
        //  print_r($line);
        array_push($lines, $line);
    }

    //1 for insert ok 0 for insert didnt work 
    $sqlInsert = 0;





    /*   Path Validation for paths Table Data */

    //-------------------Path Name

    //echo $lines[0][0];
    $path_name = $lines[0][0];

    if (!isset($path_name)) {
        $sqlInsert = 0;
    }

    //string length  
    if (strlen($path_name) > 100) {
        $sqlInsert = 0;
    } //end 


    //-------------------Path Length

    echo "<br>";
    //echo $lines[0][1];
    $path_length = $lines[0][1];


    //number size  
    if ($path_length >= 1 && $path_length <= 100) {
        $sqlInsert = 0;
    } //end 

    if (!isset($path_length)) {
        $sqlInsert = 0;
    }

    echo "<br>";

    //-------------------Path Desc

    //echo $lines[0][2];
    $path_desc = $lines[0][2];

    if (strlen($path_desc) > 255) {
        $sqlInsert = 0;
    }

    if (!isset($path_desc)) {
        $sqlInsert = 0;
    }

    //-------------------Path Note

    echo "<br>";
    //echo $lines[0][3];
    $path_note = $lines[0][3];

    if (strlen($path_note) > 65534) {
        $sqlInsert = 0;
    } //end 




    echo "<br>";

    //2 & 3 lines contain information about the end points of the path

    if ($sqlInsert = 1 && $uploadOk != 0) {
        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO paths (pt_name, pt_length, pt_description, pt_note ) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $path_name, $path_length, $path_desc, $path_note);
        $stmt->execute();
    }

    //echo $lines[1][0];
    $beg_path = $lines[1][0];

    //echo $lines[1][1];
    $beg_grnd_ht = $lines[1][1];

    //echo $lines[1][2];
    $beg_ant_ht = $lines[1][2];

    //echo $lines[2][0];
    $end_path = $lines[2][0];

    //echo $lines[2][1];
    $end_grnd_ht = $lines[2][1];

    //echo $lines[2][2];
    $end_ant_ht = $lines[2][2];



    if ($sqlInsert = 1 && $uploadOk != 0) {

        // prepare and bind
        $stmt = $conn->prepare("INSERT INTO pt_endpoints (edpt_bgn_path_dist, edpt_bgn_ground_height, edpt_bgn_antenna_height, edpt_end_path_dist, edpt_end_ground_height,edpt_end_antenna_height,pt_id ) VALUES (?, ?, ?, ?, ? , ? , ?)");
        $stmt->bind_param("ddddddi", $beg_path, $beg_grnd_ht, $beg_ant_ht, $end_grnd_ht, $end_path, $end_ant_ht, $conn->insert_id);
        $stmt->execute();
    }

    //loop through rest of csv and insert it and echo it out
    $id = $conn->insert_id;
    for ($x = 3; $x < 17; $x++) {

        // echo  "<br>".$x."  ".$lines[$x][0]." "."<br>";
        $mdpt_bgn_path_dist = $lines[$x][0];
        //	echo  $x."  ".$lines[$x][1]." "."<br>";
        $mdpt_ground_height = $lines[$x][1];
        //      echo  $x."  ".$lines[$x][2]." "."<br>";
        $mdpt_terrain_type = $lines[$x][2];
        //    echo  $x."  ".$lines[$x][3]." "."<br>";


        //Midpoint Terrain Type

        //string length  
        if (strlen($mdpt_terrain_type) > 50) {
            $sqlInsert = 0;
        } //end 




        $obs_height = $lines[$x][3];
        //  echo  $x."  ".$lines[$x][4]."<br>"."<br>";
        $obs_type = $lines[$x][4];

        if (strlen($obs_type) > 50) {
            $sqlInsert = 0;
            break;
        } //end 
        else {
            $sqlInsert = 1;
        }


        if ($sqlInsert = 1 && $uploadOk != 0) {
            // prepare and bind
            $stmt = $conn->prepare("INSERT INTO pt_midpoints (mdpt_bgn_path_dist, mdpt_ground_height, mdpt_terrain_type, obs_height , obs_type ,pt_id ) VALUES (?, ?, ?, ?, ? , ? )");
            $stmt->bind_param("ddsdsi", $mdpt_bgn_path_dist, $mdpt_ground_height, $mdpt_terrain_type, $obs_height, $obs_type, $id);
            $stmt->execute();
        }
    } //end for 

}
?>

<?php function connect_db()
{


    $servername = "localhost";
    $username = "dana";
    $password = "dana";
    $dbname = "LAMP2PROJECT";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";

    return $conn;
}
?>


<!DOCTYPE html>
<html>

<body>

    <form action="home.php" method="post" enctype="multipart/form-data">

        <h2> Please Choose a path from selection below and click upload Select image to upload:</h2>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload CSV" name="submit">
    </form>

    <input type="submit" value="HOME" onClick="window.location = 'index.php';">
</body>

</html>