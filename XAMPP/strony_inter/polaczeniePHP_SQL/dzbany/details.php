<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły dzbana</title>
</head>
<body>
    <a href="index.php">Wróć do listy</a>

    <?php
    $conn = new mysqli("localhost", "root", "", "dzbanydb");

    $id = $_GET["id"];
    $sql = "SELECT id, nazwa, opis, pojemnosc, wysokosc FROM dzbany WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_object();

    echo "<p><strong>Nazwa:</strong> {$row->nazwa}</p>";
    echo "<p><strong>Opis:</strong> {$row->opis}</p>";
    echo "<p><strong>Pojemność:</strong> {$row->pojemnosc} ml</p>";
    echo "<p><strong>Wysokość:</strong> {$row->wysokosc} cm</p>";

    echo "<p><a href='updateForm.php?id=$id'>Edytuj dzban</a></p>";
    echo "<p><a href='delete.php?id=$id'>Usuń dzban</a></p>";

    $conn->close();
    ?>

</body>
</html>
