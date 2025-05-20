<?php
$conn = new mysqli("localhost", "root", "", "dzbanydb");

$id = $_GET["id"];

$sql = "DELETE FROM dzbany WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<p>Dzban został usunięty!</p>";
    echo "<p><a href='index.php'>Powrót do listy</a></p>";
} else {
    echo "Błąd: " . $conn->error;
}

$conn->close();
?>
