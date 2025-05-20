<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista dzbanow</title>
</head>
<body>
    <a href="insertForm.php">Dodanie nowego dzbana</a>

<?php
    $conn = new mysqli("localhost", "root", "", "dzbanydb");

    $sql = "SELECT id, nazwa FROM dzbany";
    $result = $conn -> query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_object()) {
            echo "<li><a href='details.php?id={$row->id}'>{$row->nazwa}</a></li>";
           }
        echo "</ul>";
       } else {
        echo "Nie masz żadnych dzbanów w swojej kolekcji";
       }
    
    $conn -> close(); 
?>

</body>
</html>