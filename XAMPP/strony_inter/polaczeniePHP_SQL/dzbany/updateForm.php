<?php
    $conn = new mysqli("localhost", "root", "", "dzbanydb");

    $id = $_GET["id"];
    $sql = "SELECT * FROM dzbany WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $dzban = $result->fetch_assoc();
    } else {
        echo "Nie znaleziono dzbana.";
        exit;
    }

    $conn->close();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja</title>
</head>
<body>
    <h2>Edytuj dzbanek</h2>
    <form action="update.php" method="post">
        <p>
            <input type="hidden" name="id" value="<?=$dzban['id'] ?>">
        </p>
        <p>
            Nazwa:  <input type="text" name="nazwa" value="<?= htmlspecialchars($dzban['nazwa']) ?>">
        </p>
        <p>
            Opis: <textarea name="opis"> <?= htmlspecialchars($dzban['opis']) ?></textarea>
        </p>
        <p>
            Pojemność: <input type="number" name="pojemnosc" value="<?= $dzban['pojemnosc']?>">
        </p>
        <p>
            Wysokość: <input type="number" name="wysokosc" value="<?= $dzban['wysokosc']?>">
        </p>
        <p>
            <input type="submit" value="Zapisz zmiany">
        </p>

        </form>

        <a href="index.php">Wróć do listy</a>



</body>
</html>