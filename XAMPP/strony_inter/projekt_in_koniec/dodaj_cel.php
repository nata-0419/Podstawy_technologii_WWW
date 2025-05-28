<?php
session_start();
require_once 'baza.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$username = $_SESSION['nick'];
$stmt = $conn->prepare("SELECT id FROM uzytkownik WHERE nick = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nie znaleziono użytkownika.";
    exit;
}
$user = $result->fetch_assoc();
$id_uzytkownika = $user['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $_POST['nazwa'] ?? '';
    $kategoria = $_POST['kategoria'] ?? '';
    $opis = $_POST['opis'] ?? '';
    $koszty = floatval($_POST['koszty'] ?? 0);
    $uzbierana_kwota = floatval($_POST['uzbierana_kwota'] ?? 0);
    $data_rozpoczecia = $_POST['data_rozpoczecia'] ?? '';
    $data_zakonczenia = $_POST['data_zakonczenia'] ?? '';
    $status = $_POST['status'] ?? '';
    $zdjecie = '';

    if (!empty($_FILES['zdjecie']['name'])) {
        $upload_dir = "zdjecia/cele/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $zdjecie = basename($_FILES["zdjecie"]["name"]);
        $upload_path = $upload_dir . $zdjecie;
        if (!move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $upload_path)) {
            echo "Błąd podczas przesyłania zdjęcia.";
            exit;
        }
    }

    $stmt1 = $conn->prepare("INSERT INTO cele (nazwa, kategoria, opis, zdjecie, id_uzytkownika) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt1) {
        echo "Błąd przygotowania zapytania: " . $conn->error;
        exit;
    }
    $stmt1->bind_param("ssssi", $nazwa, $kategoria, $opis, $zdjecie, $id_uzytkownika);
    if (!$stmt1->execute()) {
        echo "Błąd przy dodawaniu celu: " . $stmt1->error;
        exit;
    }
    $id_celu = $conn->insert_id;
    $stmt1->close();

    $stmt2 = $conn->prepare("INSERT INTO szczegoly_celu (id_celu, koszty, uzbierana_kwota, data_rozpoczecia, data_zakonczenia, status) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt2) {
        echo "Błąd przygotowania zapytania do szczegółów: " . $conn->error;
        exit;
    }
    $stmt2->bind_param("iddsss", $id_celu, $koszty, $uzbierana_kwota, $data_rozpoczecia, $data_zakonczenia, $status);
    if (!$stmt2->execute()) {
        echo "Błąd przy dodawaniu szczegółów celu: " . $stmt2->error;
        exit;
    }
    $stmt2->close();
    header("Location: cele_uzytkownika.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj cel</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

        <?php require_once 'elementy/header.php'; ?>

    <article>
        <div class="karta">
        <h2>Dodaj nowy cel</h2>

     <?php
            if (!empty($komunikat)) {
                echo '<p style="color: green;">' . $komunikat . '</p>';
            }
    ?>
    <form action="dodaj_cel.php" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Podaj nazwę celu:</td>
                <td><input type="text" name="nazwa" required></td>
            </tr>
            <tr>
                <td>Podaj kategorię:</td>
                <td><input type="text" name="kategoria" required></td>
            </tr>
            <tr>
                <td>Podaj opis celu:</td>
                <td><textarea name="opis" required></textarea></td>
            </tr>
            <tr>
                <td>Podaj zdjęcie (opcjonalnie):</td>
                <td><input type="file" name="zdjecie" accept="image/*"></td>
            </tr>
            <tr>
                <td>Podaj szacowany koszt:</td>
                <td><input type="number" name="koszty" min="0" required></td>
            </tr>
            <tr>
                <td>Podaj zebraną kwotę:</td>
                <td><input type="number" name="uzbierana_kwota" min="0" required></td>
            </tr>
            <tr>
                <td>Podaj datę rozpoczęcia:</td>
                <td><input type="date" name="data_rozpoczecia" required></td>
            </tr>
            <tr>
                <td>Podaj datę zakończenia:</td>
                <td><input type="date" name="data_zakonczenia" required></td>
            </tr>
            <tr>
                <td>Wybierz status:</td>
            <td>
                <select name="status" required>
                <option value="nie rozpoczęto planowania">Nie rozpoczęto planowania</option>
                <option value="w trakcie planowania">W trakcie planowania</option>
                <option value="zrealizowano">Zrealizowano</option>
                </select>
            </td>
            </tr>
    </table>        
        
        <div class="przyciski">
            <button class="butLog" type="submit">Dodaj zadanie</button>
            <button type="reset" class="butLog">Wyczyść</button>
            <a href="cele_uzytkownika.php"><button type="button" class="butLog">Wróć na stronę planów</button></a>
        </div></form>

    </div>
    </article>

    <?php require_once 'elementy/footer.php'; ?>


</body>
</html>
