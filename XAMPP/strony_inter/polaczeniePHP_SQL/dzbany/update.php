<?php
$conn = new mysqli("localhost", "root", "", "dzbanydb");

$id = $_POST['id'];
$nazwa = $conn -> real_escape_string($_POST['nazwa']);
$opis = $conn->real_escape_string($_POST['opis']);
$pojemnosc = (int) $_POST['pojemnosc'];
$wysokosc = (int) $_POST['wysokosc'];

$sql = "UPDATE dzbany SET nazwa='$nazwa', opis='$opis', pojemnosc='$pojemnosc', wysokosc='$wysokosc' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "<p>Dzban zostal zaktualizowany</p>";
    echo "<a href='index.php'>Wróć do listy</a>";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
