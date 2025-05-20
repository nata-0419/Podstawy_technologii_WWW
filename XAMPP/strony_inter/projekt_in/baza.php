<?php
$servername = "localhost";
$username11 = "root";
$password = "";
$dbname = "harmonogramv2";

$conn = new mysqli($servername, $username11, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
