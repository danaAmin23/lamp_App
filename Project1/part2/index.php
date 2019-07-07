
<?php 

/*
purpose : Lamp2 Project 1,  index page for user to access and edit midpoint data
author(s) : Dana Amin, Chris Fraser, Darsh Bhatt
*/
  ?>
<html>
<head>

<style>
html{
  
  background-image: url("../part1/images/tower.jpg");
  color: white;
}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<!-- Load paths into select via ajax -->
<script>
// A) Create a web form that shows the paths available to be edited, options are imported from the database
$( document ).ready(function() {
      $.ajax({url: "ajax.php", success: function(result){
    $("body").html(result);
  }});



});//end on ready 


/***********Part 2 - c) on button click display a form that has general path details ****************/


function showDetails(){
  //window.location.replace('details.php');


 var btnVal = $("#details").val();
  
$.ajax({
        url: "details.php",
        type: "post",
        data: { show: btnVal },
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');
        }


    });//end ajax
};//end showDetails()


function cancelDetails(){
 
var name = $('#pathName').text();




$.ajax({
        url: "details.php",
        type: "post",
        data: { show: name},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');
        }


    });//end ajax

};//end cancelDetails()


//update function for new values 
function editDetails(){

var name = $('#pathName').text();
var length = $('#pathLength').val();
var desc = $('#pathDesc').val();
var note = $('#pathNote').val();
var mdpt = $('#mdpt').text();
console.log(mdpt);


var details = {




    'name': name,
    'length': length,
    'desc': desc, 
    'note' : note,
    'mdpt' : mdpt

};



$.ajax({
        url: "details.php",
        type: "post",
        data: { edit: details},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');
        }


    });//end ajax



};//end editDetails()


function editEndpoints(){

var name = $('#pathName').text();
var begDist = $('#begDist').text();
var begGrndHt = $('#begGrndHt').val();
var begAH = $('#begAH').val();
var endDist = $('#endDist').val();
var endGrndHt = $('#endGrndHt').val();
var endAH = $('#endAH').val();
begDist = parseInt(begDist);

var details = {

    'name': name,
    'begDist': begDist,
    'begGrndHt': begGrndHt, 
    'begAH' : begAH,
    'endDist': endDist,
    'endGrndHt': endGrndHt, 
    'endAH' : endAH
};



$.ajax({
        url: "endpoints.php",
        type: "post",
        data: { edit: details},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }


    });//end ajax

};//end editEndpoints()


function cancelEndpoints(){

var name = $('#pathName').text();





$.ajax({
        url: "endpoints.php",
        type: "post",
        data: { show: name},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }


    });//end ajax


};//end cancelEndpoints()

/***********Part 2 - d) on button click display a form that has general path endpoints ****************/


function showEndpoints(){

 var name = $("#details").val();




$.ajax({
        url: "endpoints.php",
        type: "post",
        data: { show: name},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }


    });//end ajax


};//end showEndpoints()




/***********Part 2 - d) on button click display a form that has general path midpoints ****************/


function showMidpoints(name){



var details = name;



$.ajax({
        url: "midpoints.php",
        type: "post",
        data: { show: details},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }//en ajax


    });


};//end showMidpoints();



function editMidpoints(){
  //window.location.replace('details.php');


var name = $('#nameval').text();
var begDist = $('#MdptBgnPathDist').text();
var grndHt = $('#MdptGrndHt').val();
var terType = $('#MdptTerrainType').val();
var obsHt = $('#MdptObsHt').val();
var obsType = $('#MdptObsType').val();
var mdpt = $('#mdpt').text();
begDist = parseInt(begDist);

var details = {

    'name': name,
    'begDist': begDist,
    'grndHt': grndHt, 
    'terType' : terType,
    'obsHt': obsHt,
    'obsType': obsType,
    'mdpt': mdpt

	
   
};



$.ajax({
        url: "midpoints.php",
        type: "post",
        data: { edit: details},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }//end ajax


    });

};//end editMidpoints()


function cancelMidpoints(){

var name = $('#mdpt').text();


$.ajax({
        url: "midpoints.php",
        type: "post",
        data: { show: name},
        success: function (data) {
          $('body').html(data);

        },
        error: function() {
                  alert('failure');;
        }


    });//end ajax


};//end cancelMidpoints()


function back(){


 window.location.href='./index.php';

}

</script>
</head>
<body>

</body>

</html>


