<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie dzbanów</title>
</head>
<body>
    <h2>Dodaj nowy dzban</h2>
    <form action="insert.php" method="post">
        <p>
            Nazwa:  <input type="text" name="nazwa" required>
        </p>
        <p>
            Opis: <textarea name="opis" cols="30" rows="10"></textarea>
        </p>
        <p>
            Pojemność: <input type="number" name="pojemnosc">
        </p>
        <p>
            Wysokość: <input type="number" name="wysokosc">
        </p>
        <p>
            <input type="submit" value="Dodaj dzbana">
        </p>

        </form>

        <a href="index.php">Wróć do listy</a>



</body>
</html>