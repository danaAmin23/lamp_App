<?php

/*
purpose :  index page for user to access parts of application
author(s) : Dana Amin
*/
?>



<style>
	body {
		background-image: url("./part1/images/tower.jpg");
		color: white;
	}

	h1 {
		font-size: 2em;

	}

	a {
		font-size: 4em;
		color: white;
	}

	img {

		width: 80px;
		margin-right: 15px;
	}
</style>

<h1> Welcome to my Microwave Path LAMP app by Dan Amin</h1> <br>

<h1> Choose from a link below to navigate project parts </h1>

<a href="home.php">
	<img src="./part1/images/upload.png">
	Upload csv path data</a>
<br>


<a href="part2/index.php">
	<img src="./part1/images/edit.png">Edit Path Data</a><br>
<a href="part3/index.php">
	<img src="./part1/images/chart.png">Display graph with variable curvature </a><br>
<a href="part1/reset.php">
	<img src="./part1/images/reset.png">Reset a Path </a>