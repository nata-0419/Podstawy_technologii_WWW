<?php
$conn = new mysqli("localhost", "root", "", "dzbanyv2db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nazwa = $_POST['nazwa'];
$opis = $_POST['opis'];
$pojemnosc = $_POST['pojemnosc'];
$wysokosc = $_POST['wysokosc'];
$idKategorii = $_POST['idKategorii'];

$obrazek = basename($_FILES['obrazek']['name']);

$sql = "INSERT INTO dzbany (idKategorii, nazwa, obrazek, opis, pojemnosc, wysokosc) 
        VALUES ('$idKategorii', '$nazwa', '$obrazek', '$opis', '$pojemnosc', '$wysokosc')";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
