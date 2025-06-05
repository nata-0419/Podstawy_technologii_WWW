<?php
session_start();
require_once 'baza.php';
$username = $_SESSION['nick'];

$query = "SELECT id FROM uzytkownik WHERE nick = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $id_uzytkownika = $user['id'];
    $_SESSION['id_uzytkownika'] = $id_uzytkownika;
} else {
    echo "Użytkownik nie został znaleziony.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_cele.css">
    <title>Lista zaplanowanych zadań do wykonania</title>
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>

<div class="listaCeli">
    <h3>Twoje plany na przyszłość </h3>

    <?php
    $query = " SELECT c.id, c.nazwa, c.kategoria, c.opis, c.zdjecie,
               s.koszty, s.uzbierana_kwota, s.data_rozpoczecia, s.data_zakonczenia, s.status
                FROM cele c JOIN szczegoly_celu s ON c.id = s.id_celu WHERE c.id_uzytkownika = ? ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_uzytkownika);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($cel = $result->fetch_assoc()) {
        echo "<div class='cel-box'>";
        echo "<div class='cel-grid'>";

            echo "<div class='cel-info'>";
            echo "<h2>" . htmlspecialchars($cel['nazwa']) . "</h2><br>";
            echo "<p><strong>Kategoria:</strong> " . htmlspecialchars($cel['kategoria']) . "</p>";
            echo "<p><strong>Opis:</strong> " . htmlspecialchars($cel['opis']) . "</p>";
            echo "<p><strong>Koszty:</strong> " . $cel['koszty'] . " zł</p>";
            echo "<p><strong>Zebrano:</strong> " . $cel['uzbierana_kwota'] . " zł</p>";
            echo "<p><strong>Data rozpoczęcia:</strong> " . $cel['data_rozpoczecia'] . "</p>";
            echo "<p><strong>Data zakończenia:</strong> " . $cel['data_zakonczenia'] . "</p>";
            echo "<p><strong>Status:</strong> " . $cel['status'] . "</p>";
            echo "</div>";

            echo "<div class='cel-img'>";
            if (!empty($cel['zdjecie'])) {
                echo "<img src='zdjecia/cele/" . htmlspecialchars($cel['zdjecie']) . "' alt='Zdjęcie celu'>";
            }
            echo "</div>";
        echo "</div>";

            echo "<div class='cel-actions'>";
                echo "<a href='edycja_celu.php?id=" . $cel['id'] . "' class='przycisk-linkowy'>Edytuj cel</a> ";
                
                echo "<form action='usun_cel.php' method='POST' onsubmit='return confirm(\"Na pewno chcesz usunąć ten cel?\")' style='display:inline-block; margin-left:10px;'>";
                echo "<input type='hidden' name='id' value='" . $cel['id'] . "'>";
                echo "<button type='submit' class='przycisk-linkowy' >Usuń cel</button>";
                echo "</form>";
            echo "</div>";
            echo "</div><hr>";

        }
            } else {
                echo "<p>Brak zapisanych celów.</p>";
            }

    $stmt->close();
    ?>
</div>

<div class="Menu">
    <h3>Menu</h3>
    <ul>
        <li><a href="StronaUzytkownika.php">Strona główna użytkownika</a></li>
        <li><a href="cele_uzytkownika.php">Wyświetl zaplanowane cele</a></li>
        <li><a href="dodaj_cel.php">Dodaj nowy plan do listy</a></li>
        <li><a href="aktywnosci_grupowe.php">Wyświetl zadania rodzinne</a></li>
    </ul>
</div>

</article>

<?php require_once 'elementy/footer.php'; ?>

</body>
</html>
