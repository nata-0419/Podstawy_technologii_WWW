<?php
$conn = new mysqli("localhost", "root", "", "dzbanydb");

$nazwa = $_POST["nazwa"];
$opis = $_POST["opis"];
$pojemnosc = $_POST["pojemnosc"];
$wysokosc = $_POST["wysokosc"];

$sql = "INSERT INTO dzbany (nazwa, opis, pojemnosc, wysokosc) VALUES ('$nazwa', '$opis', $pojemnosc, $wysokosc)";

if ($conn->query($sql) === TRUE) {
    echo "<p>Dodano nowego dzbana!</p>";
    echo "<p><a href='index.php'>Wróć do listy</a></p>";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
