<?php
session_start();
require_once 'baza.php';

$komunikat = "";

// Pobieranie ID celu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $_SESSION['id_celu'] = $_POST['id'];
}
$id_celu = $_SESSION['id_celu'] ?? null;

if (!$id_celu) {
    die("Brak ID celu do edycji.");
}

// Obsługa zapisu formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nazwa'])) {
    $nazwa     = trim($_POST['nazwa'] ?? '');
    $kategoria = trim($_POST['kategoria'] ?? '');
    $opis      = trim($_POST['opis'] ?? '');
    $koszty    = floatval($_POST['koszty'] ?? 0);
    $data      = $_POST['data_wykonania'] ?? '';
    $okres     = $_POST['okres_trwania'] ?? '';
    $status    = $_POST['status'] ?? '';

    if ($nazwa === '' || $kategoria === '' || $data === '') {
        $komunikat = "Błąd: Pola nazwa, kategoria i data są wymagane.";
    } else {
        // aktualizacja tabeli cele
        $sql1 = "UPDATE cele SET nazwa = ?, kategoria = ?, opis = ? WHERE id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("sssi", $nazwa, $kategoria, $opis, $id_celu);
        $stmt1->execute();
        $stmt1->close();

        // aktualizacja szczegoly_celu
        $sql2 = "UPDATE szczegoly_celu SET koszty = ?, data_wykonania = ?, okres_trwania = ?, status = ? WHERE id_celu = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("dsssi", $koszty, $data, $okres, $status, $id_celu);
        if ($stmt2->execute()) {
            $komunikat = "Cel został zaktualizowany!";
        } else {
            $komunikat = "Błąd podczas aktualizacji: " . $stmt2->error;
        }
        $stmt2->close();
    }
}

// Pobieranie danych celu do formularza
$sql = "SELECT c.*, s.koszty, s.data_wykonania, s.okres_trwania, s.status
        FROM cele c
        JOIN szczegoly_celu s ON c.id = s.id_celu
        WHERE c.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_celu);
$stmt->execute();
$wynik = $stmt->get_result();
$cel = $wynik->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edytuj cel</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
<form method="POST" action="edycja_celu.php">
    <div class="karta">
        <h2>Edytuj cel</h2>

        <?php if (!empty($komunikat)): ?>
            <p style="color: green;"><?= htmlspecialchars($komunikat) ?></p>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?= htmlspecialchars($id_celu) ?>">

        <table>
            <tr>
                <td>Nazwa celu:</td>
                <td><input type="text" name="nazwa" value="<?= htmlspecialchars($cel['nazwa']) ?>" required></td>
            </tr>
            <tr>
                <td>Kategoria:</td>
                <td><input type="text" name="kategoria" value="<?= htmlspecialchars($cel['kategoria']) ?>" required></td>
            </tr>
            <tr>
                <td>Opis:</td>
                <td><textarea name="opis"><?= htmlspecialchars($cel['opis']) ?></textarea></td>
            </tr>
            <tr>
                <td>Koszty (zł):</td>
                <td><input type="number" step="0.01" name="koszty" value="<?= htmlspecialchars($cel['koszty']) ?>" required></td>
            </tr>
            <tr>
                <td>Data wykonania:</td>
                <td><input type="date" name="data_wykonania" value="<?= htmlspecialchars($cel['data_wykonania']) ?>" required></td>
            </tr>
            <tr>
                <td>Okres trwania:</td>
                <td><input type="text" name="okres_trwania" value="<?= htmlspecialchars($cel['okres_trwania']) ?>"></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <select name="status">
                        <?php
                        $statusy = [
                            "nie rozpoczęto",
                            "w trakcie realizacji",
                            "ukończony"
                        ];
                        foreach ($statusy as $s) {
                            $selected = ($cel['status'] === $s) ? 'selected' : '';
                            echo "<option value=\"$s\" $selected>$s</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>

        <div class="przyciski">
            <button class="butLog" type="submit">Zapisz zmiany</button>
            <a href="cele_uzytkownika.php"><button type="button" class="butLog">Wróć</button></a>
        </div>
    </div>
</form>
</article>

<?php require_once 'elementy/footer.php'; ?>
</body>
</html>
