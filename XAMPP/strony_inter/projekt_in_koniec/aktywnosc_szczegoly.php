<?php
require_once 'baza.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("Nieprawidłowe ID.");

$id_aktywnosci = (int)$id;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły aktywności</title>
    <link rel="stylesheet" href="css/styleAktywnosciSz.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>

    <div class="panel-boczny">
        <h3>Nawigacja</h3>
        <ul>
            <li><a href="aktywnosci_grupowe.php">Wróc do strony aktywności</a></li>
            <li><a href="dodaj_aktywnosci.php">Dodaj aktywność</a></li>
            <li><a href="dodaj_podzial_zadan.php?id=<?= $id_aktywnosci ?>">Dodaj podział zadań</a></li>
<br>
            <li><a href="StronaUzytkownika.php">Strona główna użytkownika</a></li>
            <li><a href="cele_uzytkownika.php">Wyświetl zaplanowane cele</a></li>
        </ul>
    </div>

    <div class="szczegoly-aktywnosci">
        <?php
            include 'aktywnosci/dane_ogolne.php';
            include 'aktywnosci/podzial_zadan.php';
            include 'aktywnosci/komentarze.php';
            include 'aktywnosci/galeria.php';
        ?>
    </div>

</article>


<?php require_once 'elementy/footer.php'; ?>

</body>
</html>
