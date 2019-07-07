<?php

/*
purpose : loada ajax.php
author(s) : Dana Amin
*/
?>
<html>

<head>

  <style>
    html {
      background-image: url("../part1/images/tower.jpg");
      color: white;

    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Load paths into select via ajax -->
  <script>
    // A) Create a web form that shows the paths available to be edited, options are imported from the database
    $(document).ready(function() {
      $.ajax({
        url: "ajax.php",
        success: function(result) {
          $("body").html(result);
        }
      });




    }); //end on ready 
  </script>
</head>

<body>

</body>

</html>