<?php

/*
purpose :, reset web form
author(s) : Dana Amin
*/

?>


<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/path.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




    <script>
        // A) Create a web form that shows the paths available to be edited, options are imported from the database
        $(document).ready(function() {
            $.ajax({
                url: "reset2.php",
                success: function(result) {
                    $("body").html(result);
                }
            });




        }); //end on ready 


        //
    </script>
</head>

<body>



</body>

</html>