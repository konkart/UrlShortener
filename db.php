<?php
$con = mysqli_connect("localhost","simpleuser","S1mpl3","urlshortener");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>