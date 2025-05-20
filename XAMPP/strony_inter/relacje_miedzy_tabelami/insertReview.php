<?php
$conn = new mysqli("localhost", "root", "", "dzbanyv2db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idDzbana = $_POST['idDzbana'];
$nick = $_POST['nick'];
$ocena = $_POST['ocena'];
$tresc = $_POST['tresc'];

$sql = "INSERT INTO recenzje (idDzbana, nick, ocena, tresc) VALUES ($idDzbana, '$nick', $ocena, '$tresc')";
if (!$conn->query($sql)) {
    die("Błąd przy dodawaniu recenzji: " . $conn->error);
}

$conn->close();

header("Location: details.php?id=$idDzbana");
exit();
?>
