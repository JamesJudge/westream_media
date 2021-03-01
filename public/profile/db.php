<?php
//DB details
$dbHost = '127.0.0.1';
$dbUsername = 'westream';
$dbPassword = 'medi4Password!';
$dbName = 'westream';
//Create connection and select DB
try {
    $conn = new PDO("mysql:host=$dbHost;dbname=westream", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}