<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "", "dzbanyv2db");

    $sql = "SELECT id, nazwa FROM kategorie";
    $result = $conn->query($sql);

    echo "<h2>Dodaj nowy dzban</h2>
    <form action='insert.php' method='post' enctype='multipart/form-data'>
        <label for='nazwa'>Nazwa dzbana:</label><br>
        <input type='text' name='nazwa' required><br><br>
        
        <label for='opis'>Opis:</label><br>
        <textarea name='opis' required></textarea><br><br>
        
        <label for='pojemnosc'>Pojemność (l):</label><br>
        <input type='number' name='pojemnosc' required><br><br>
        
        <label for='wysokosc'>Wysokość (cm):</label><br>
        <input type='number' name='wysokosc' required><br><br>
        
        <label for='obrazek'>Obrazek:</label><br>
        <input type='file' name='obrazek' required><br><br>
        
        <label for='idKategorii'>Kategoria:</label><br>
        <select name='idKategorii'>";
            while ($row = $result->fetch_object()) {
                echo "<option value='{$row->id}'>{$row->nazwa}</option>";
            }
            echo "</select><br><br>
                <input type='submit' value='Dodaj dzban'>
    </form>";

$conn->close();
?>

</body>
</html>