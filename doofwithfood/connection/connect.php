<?php

$servername = "localhost"; //server
$username = "root"; //username
$password = ""; //password
$dbname = "online_rest";  //database

// Create connection
$db = mysqli_connect($servername, $username, $password, $dbname); 

if (!$db) {       	
    die("Connection failed: " . mysqli_connect_error());
}

?>