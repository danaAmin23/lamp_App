<?php

header("Content-Type: application/json");


$db_conn = connect_db();




    

	$data = array("status" => "OK");
//$data[0] = array("month" => "Jun", "value" => 1234546);    
//$data[1] = array("month" => "Jul", "value" => 987654);


$qry = "select * from paths";
$rs = $db_conn->query($qry);
if ($rs->num_rows > 0){

	$data[0]= array();
    while ($row = $rs->fetch_assoc()){
		array_push($data[0], $row);
    }
} else {
    echo '{ "status": "None" }';
}



$qry = "select * from pt_endpoints";
$rs = $db_conn->query($qry);
if ($rs->num_rows > 0){

	$data[1]= array();
    while ($row = $rs->fetch_assoc()){
		array_push($data[1], $row);
    }
} else {
    echo '{ "status": "None" }';
}



$qry = "select * from pt_midpoints";
$rs = $db_conn->query($qry);
if ($rs->num_rows > 0){

	$data[2]= array();
    while ($row = $rs->fetch_assoc()){
		array_push($data[2], $row);
    }
} else {
    echo '{ "status": "None" }';
}








function connect_db(){
    $db_conn = new mysqli('localhost', 'dana', 'dana', 'LAMP2PROJECT');
    if ($db_conn->connect_errno) {
        printf ("Could not connect to database server\n Error: "
            .$db_conn->connect_errno ."\n Report: "
            .$db_conn->connect_error."\n");
        die;
    }
    return $db_conn;
}

function disconnect_db($db_conn){
    $db_conn->close();
}








	echo json_encode($data);

?>








