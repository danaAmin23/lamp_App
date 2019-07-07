<?php

/*
purpose :, reset web form
author(s) : Dana Amin
*/

?>

<?php
$con = mysqli_connect('localhost', 'dana', 'dana', 'LAMP2PROJECT');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
} else {

    echo "Connected";
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
    <h1> Choose From drop down menu a path to be reset</h1><br><b>Path
        <select name="paths" id="path" onchange="showPath(this.options[selectedIndex].innerHTML)">
            <option disabled selected value> -- select an option -- </option>

        </select>
</form>
<br>
<br>

<input type="button" value="HOME" onClick="window.location = '../index.php';">

<br>
<div id="txtHint" style="color:white"><b> </b></div>
<br />

<script>
    var options = <?php echo json_encode($options); ?>;

    //set options according to database values
    $.each(options, function(i, options) {
        $('#path').append($('<option>', {
            value: i,
            text: options
        }));
    });

    function showPath(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            console.log(str);
            xmlhttp.open("GET", "getPath2.php?q=" + str, true);
            xmlhttp.send();
        }
    }
</script>

</html>