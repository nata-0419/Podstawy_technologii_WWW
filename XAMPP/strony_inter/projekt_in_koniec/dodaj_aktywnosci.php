<?php
session_start();
require_once 'baza.php';

if (!isset($_SESSION['nick'])) {
    header("Location: login.php");
    exit();
}

$komunikat = '';
$nick = $_SESSION['nick'];
$stmt = $conn->prepare("SELECT id FROM uzytkownik WHERE nick = ?");
$stmt->bind_param("s", $nick);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$id_uzytkownika = $user['id'];
$stmt->close();

function przypiszIkone($status) {
    switch ($status) {
        case 'nie rozpoczęto realizacji':
            return '⏳';
        case 'w trakcie realizacji':
            return '🔄';
        case 'ukoczono':
            return '✅';
        default:
            return '';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $_POST['nazwa'];
    $opis = $_POST['opis'];
    $termin = $_POST['termin'];
    $typ = $_POST['typ'];
    $statusZam = $_POST['status'];
    $ikona = przypiszIkone($statusZam);

    $stmt1 = $conn->prepare("INSERT INTO aktywnosci_grupowe (nazwa, opis, termin, typ) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("ssss", $nazwa, $opis, $termin, $typ);
    $stmt1->execute();
    $id_aktywnosci = $stmt1->insert_id;
    $stmt1->close();

    $stmt2 = $conn->prepare("INSERT INTO aktywnosci_uzytkownik (id_aktywnosci, id_uzytkownika) VALUES (?, ?)");
    $stmt2->bind_param("ii", $id_aktywnosci, $id_uzytkownika);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $conn->prepare("INSERT INTO status (id_aktywnosci, statusZam, ikona) VALUES (?, ?, ?)");
    $stmt3->bind_param("iss", $id_aktywnosci, $statusZam, $ikona);
    $stmt3->execute();
    $stmt3->close();

    $_SESSION['komunikat'] = "Aktywność została pomyślnie dodana!";
    header("Location: dodaj_aktywnosci.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj aktywność grupową</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
    <div class="formularz-aktywnosci">
        <h2>Dodaj nową aktywność grupową</h2>
        <?php if (!empty($komunikat)) echo "<p>$komunikat</p>"; ?>

        <form method="POST" action="">
            <label for="nazwa">Nazwa:</label>
            <input type="text" name="nazwa" required>

            <label for="opis">Opis:</label>
            <textarea name="opis" required></textarea>

            <label for="termin">Termin:</label>
            <input type="date" name="termin" required>

            <label for="typ">Typ (np. rodzina, wakacje, hobby):</label>
            <input type="text" name="typ" required>

            <label for="status">Status aktywności:</label>
            <select name="status" required>
                <option value="nie rozpoczęto realizacji">Nie rozpoczęto realizacji</option>
                <option value="w trakcie realizacji">W trakcie realizacji</option>
                <option value="ukoczono">Ukończono</option>
            </select>

            <button type="submit">Dodaj aktywność</button>
        </form>
 
        <p><a class="btn-powrot" href="aktywnosci_grupowe.php">← Wróć do listy aktywności</a></p>
    </div>
</article>

<?php require_once 'elementy/footer.php'; ?>

</body>
</html>
