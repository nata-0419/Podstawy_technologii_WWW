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
$id = $_GET['id'];

    $sql = "SELECT AVG(ocena) AS srednia FROM recenzje WHERE idDzbana=$id";
    $result = $conn->query($sql);
    $srednia = $result->fetch_object()->srednia;

    $sql = "SELECT idKategorii, k.nazwa AS nazwaKat, d.nazwa, obrazek, d.opis, pojemnosc, wysokosc FROM dzbany d, kategorie k WHERE d.id=$id AND idKategorii=k.id";
    $result = $conn->query($sql);
    $row = $result->fetch_object();

    echo "<h2> Szczególowe informacje o dzbanie </h2>";
    echo "<h3> {$row -> nazwa} </h3> ";
    echo "<p> Opis dzbana: {$row -> opis} </p>";
    echo "<p>Wysokość dzbana: {$row->wysokosc} cm</p>";
    echo "<p>Pojemność dzbana: {$row->pojemnosc} l</p>";
    echo "<p>Kategoria: <a href='index.php?idKat={$row->idKategorii}'>{$row->nazwaKat}</a></p>";
    echo "<p>Średnia ocena: " . round($srednia, 1) . "</p>";
    echo "<img src='{$row->obrazek}' alt='{$row->nazwa}' width='180'>";


    echo "<h3>Dodaj swoją recenzję na temat dzbana </h3>
        <form method='post' action='insertReview.php'>
            <input type='hidden' name='idDzbana' value='{$id}'>
            <label for='nick'>Twój nick:</label><br>
                <input type='text' name='nick' required><br><br>
            <label for='ocena'>Ocena (1-9):</label><br>
                <select name='ocena' required>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>                   
                    <option value='6'>6</option>
                    <option value='7'>7</option>
                    <option value='8'>8</option>
                    <option value='9'>9</option>
                </select><br><br>
            <label for='tresc'>Treść recenzji:</label><br>
                <textarea name='tresc' required></textarea><br><br>
            <input type='submit' value='Dodaj recenzję'>
        </form>";


        $sql = "SELECT nick, ocena, tresc, data FROM recenzje WHERE idDzbana=$id";
        $result = $conn->query($sql);
        
        echo "<h2>Lista recenzji:</h2>";
        if ($result && $result->num_rows > 0) {
            echo "<table><tr><th>Nick</th><th>Ocena</th><th>Treść</th><th>Data</th></tr>";
            while ($row = $result->fetch_object()) {
                echo "<tr><td>{$row->nick}</td><td>{$row->ocena}</td><td>{$row->tresc}</td><td>{$row->data}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Brak recenzji.</p>";
        }
        

$conn->close();
?>


</body>
</html>