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

        echo "<h3> Lista wszystkich kategorii: </h3>";
        echo "<ol>";
        echo "<li><a href='index.php'> Wszyskie</a></li>";
        while($row = $result->fetch_object()) {
        echo "<li><a href='index.php?idKat={$row->id}'>{$row->nazwa}</a></li>";
        }     
        echo "</ol>";


        echo "<form>
        <p>
            <input type='text' name='fraza' placeholder='Wyszukaj po nazwie dzbanek'>
            <input type='submit' value='Wyszukaj'>
        </p>
        </form>";


        $sql = "SELECT id, nazwa, obrazek FROM dzbany";
        if (isset($_GET["idKat"])) {
        $idKat = $_GET["idKat"];
        $sql .= " WHERE idKategorii = $idKat";
        }
        elseif (isset($_GET["fraza"])) {
        $fraza = $_GET["fraza"];
        $sql .= " WHERE nazwa LIKE '%$fraza%'";
        }

        $result = $conn->query($sql);
        echo "<h3>Lista dzbanów: </h3>";
        if ($result -> num_rows > 0) {
            echo "<table><tr><th>Obraz</th></tr>";
            while ($row = $result -> fetch_object()){
                echo "<tr>
                    <td><img src='{$row->obrazek}' alt='{$row->nazwa}' width='120'></td>
                    <td><a href='details.php?id={$row->id}'>{$row->nazwa}</a></td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p> Nie mamy dzbanów na liście </p>";
        }
        
    $conn -> close();
       

 ?>



</body>
</html>