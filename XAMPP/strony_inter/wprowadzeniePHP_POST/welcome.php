<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        p {
            color: <?php echo ($_POST['kolor']); ?>;
        }
    </style>
</head>
<body>
    <p>
        <?php
            $imie = ($_POST['imie']);
            $nazwisko = ($_POST['nazwisko']);
            echo "Witaj $imie $nazwisko!";
        ?>
    </p>
    <a href="index.html">Powrót do formularza</a>
</body>
</html>
