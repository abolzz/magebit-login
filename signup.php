<?php
 
require 'connection.php';
$conn    = Connect();
$name    = $conn->real_escape_string($_POST['username']);
$password    = $conn->real_escape_string($_POST['password']);
$query   = "INSERT into users (username,password) VALUES('" . $username . "','" . $password. "')";
$success = $conn->query($query);
 
if (!$success) {
    die("Couldn't enter data: ".$conn->error);
 
}
 
$conn->close();
 
