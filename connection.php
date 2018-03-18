<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'davisabols.dk.mysql');
define('DB_USERNAME', 'davisabols_dk');
define('DB_PASSWORD', 'c6sbyB7GvkfiHkJy7te9do26');
define('DB_NAME', 'davisabols_dk');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// sql to create table
$createtable = "CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
password VARCHAR(50) NOT NULL,
reg_date TIMESTAMP
)";

if ($link->query($createtable) === TRUE) {

} else {
    
}
?>
