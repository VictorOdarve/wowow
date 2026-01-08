<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinic_consultationdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
}
?>