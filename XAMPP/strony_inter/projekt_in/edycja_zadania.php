<?php
session_start();
require_once 'baza.php';

$komunikat = "";

// Pobieramy ID zadania z POST lub sesji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $_SESSION['id_zadania'] = $_POST['id'];
}
$id_zadania = $_SESSION['id_zadania'] ?? null;

if (!$id_zadania) {
    die("Brak ID zadania do edycji.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tytul'])) {
    // Odczyt danych z formularza
    $tytul     = trim($_POST['tytul'] ?? '');
    $kategoria = trim($_POST['kategoria'] ?? '');
    $priorytet = $_POST['priorytet'] ?? 1;
    $data      = $_POST['data'] ?? '';
    $godzina   = $_POST['godzina'] ?? '';
    $status    = $_POST['status'] ?? '';
    $szczegoly = trim($_POST['szczegoly'] ?? '');

    // WALIDACJA
    if ($tytul === '' || $kategoria === '' || $data === '') {
        $komunikat = "Błąd: Pola tytuł, kategoria i data są wymagane.";
    } else {
        // Aktualizacja zadania
        $sql1 = "UPDATE zadania SET nazwa = ?, piorytet = ?, kategoria = ? WHERE id = ?";
        $stmt1 = $conn->prepare($sql1);
        if ($stmt1) {
            $stmt1->bind_param("sisi", $tytul, $priorytet, $kategoria, $id_zadania);
            $stmt1->execute();
            $stmt1->close();
        }

        // Aktualizacja szczegółów
        $sql2 = "UPDATE szczegoly_zad SET data = ?, godzina = ?, stan_realizacji = ?, szczegoly = ? WHERE id_zadania = ?";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2) {
            $stmt2->bind_param("ssssi", $data, $godzina, $status, $szczegoly, $id_zadania);
            if ($stmt2->execute()) {
                $komunikat = "Zadanie zostało zaktualizowane!";
            } else {
                $komunikat = "Błąd podczas aktualizacji: " . $stmt2->error;
            }
            $stmt2->close();
        }
    }
}


// Pobieramy dane do formularza
$sql = "SELECT z.*, s.data, s.godzina, s.stan_realizacji, s.szczegoly 
        FROM zadania z 
        JOIN szczegoly_zad s ON z.id = s.id_zadania 
        WHERE z.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_zadania);
$stmt->execute();
$wynik = $stmt->get_result();
$zadanie = $wynik->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj zadanie</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
<form method="POST" action="edycja_zadania.php">
    <div class="karta">
        <h2>Edytuj zadanie</h2>

        <?php
        if (!empty($komunikat)) {
            echo '<p style="color: green;">' . htmlspecialchars($komunikat) . '</p>';
        }
        ?>

        <input type="hidden" name="id" value="<?= htmlspecialchars($id_zadania) ?>">

        <table>
            <tr>
                <td>Tytuł zadania:</td>
                <td><input type="text" name="tytul" value="<?= htmlspecialchars($zadanie['nazwa']) ?>" required></td>
            </tr>
            <tr>
                <td>Kategoria:</td>
                <td><input type="text" name="kategoria" value="<?= htmlspecialchars($zadanie['kategoria']) ?>" required></td>
            </tr>
            <tr>
                <td>Data:</td>
                <td><input type="date" name="data" value="<?= htmlspecialchars($zadanie['data']) ?>" required></td>
            </tr>
            <tr>
                <td>Godzina:</td>
                <td><input type="time" name="godzina" value="<?= htmlspecialchars($zadanie['godzina']) ?>"></td>
            </tr>
            <tr>
                <td>Priorytet:</td>
                <td>
                    <select name="priorytet">
                        <?php
                        for ($i = 1; $i <= 9; $i++) {
                            $selected = ($zadanie['piorytet'] == $i) ? 'selected' : '';
                            echo "<option value=\"$i\" $selected>$i</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <select name="status">
                        <?php
                        $statusy = [
                            "nie rozpoczęto zadania",
                            "w takcie realizacji",
                            "zakończenie zadania"
                        ];
                        foreach ($statusy as $s) {
                            $selected = ($zadanie['stan_realizacji'] == $s) ? 'selected' : '';
                            echo "<option value=\"$s\" $selected>$s</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Szczegóły:</td>
                <td><textarea name="szczegoly"><?= htmlspecialchars($zadanie['szczegoly']) ?></textarea></td>
            </tr>
        </table>

        <div class="przyciski">
            <button class="butLog" type="submit">Zapisz zmiany</button>
            <a href="StronaUzytkownika.php"><button type="button" class="butLog">Wróć</button></a>
        </div>
    </div>
</form>
</article>

<?php require_once 'elementy/footer.php'; ?>
</body>
</html>
