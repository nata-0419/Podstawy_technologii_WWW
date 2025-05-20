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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleUzytkownika.css">
    <title>Strona użytkownika</title>
</head>
<body>
    

    <?php   require_once 'elementy/header.php';     ?>


    
    <article>

    <div class="Harmonogram">
        <h3>Twóje zadania na 
            <?php  $dzisiaj = date("d.m.Y");
                echo $dzisiaj; ?> 
        </h3>

<?php
$dzisiaj = date('Y-m-d');

for ($h = 6; $h <= 22; $h++) {
    $poczatek = sprintf('%02d:00:00', $h);
    $koniec = sprintf('%02d:59:59', $h);
    $przedzial = sprintf('%02d:00–%02d:59', $h, $h);

    echo "<p class='godzina'>{$przedzial}</p>";

    $query = "
        SELECT z.id, z.nazwa, z.piorytet, z.kategoria, sz.stan_realizacji, sz.szczegoly 
        FROM zadania z JOIN szczegoly_zad sz ON z.id = sz.id_zadania
        WHERE z.id_uzytkownika = ? AND sz.data = ? AND sz.godzina BETWEEN ? AND ? ORDER BY sz.godzina ASC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $id_uzytkownika, $dzisiaj, $poczatek, $koniec);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {


            echo "<div class='zadanie-box'>";
            echo "<h4><a href='szczegoly_zadania.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['nazwa']) . "</a></h4>";
            echo '<p style="margin-left: 20px;"><strong>Kategoria:</strong> ' . htmlspecialchars($row['kategoria']) . '</p>';
            echo '<p style="margin-left: 20px;"><strong>Stan:</strong> ' . htmlspecialchars($row['stan_realizacji']) . '</p>';
            echo "</div>";
    
        }
    } else {
        echo "<p>Brak zadań</p>";
    }
    echo "<hr>";
    $stmt->close();
}
?>



    </div>


    <div class="Menu">
        <h3>Menu</h3>
        <ul>
            <li><a href="StronaUzytkownika.php">Wróc na stronę glówną.</a></li>
            <li><a href="cele_uzytkownika.php">Wyświetl cele</a></li>

            <li><a href="dodaj_zadanie.php">Dodaj zadanie</a></li>
        </ul>
    </div>

    </article>

    <?php   require_once 'elementy/footer.php';     ?>

</body>
</html>