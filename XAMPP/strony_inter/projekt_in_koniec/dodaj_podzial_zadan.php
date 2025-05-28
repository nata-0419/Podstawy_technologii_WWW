<?php
require_once 'baza.php';
session_start();

$id_aktywnosci = $_GET['id'] ?? null;
if (!$id_aktywnosci || !is_numeric($id_aktywnosci)) die("Nieprawidłowe ID aktywności.");

$stmtUsers = $conn->prepare("
    SELECT u.id, u.nick 
    FROM uzytkownik u
    JOIN aktywnosci_uzytkownik au ON au.id_uzytkownika = u.id
    WHERE au.id_aktywnosci = ?
");
$stmtUsers->bind_param("i", $id_aktywnosci);
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_uzytkownika = $_POST['id_uzytkownika'] ?? null;
    $tekstZadania = trim($_POST['tekstZadania'] ?? '');
    $status = $_POST['status'] ?? 'nie rozpoczęto realizacji';
    $dataUkonczenia = $_POST['dataUkonczenia'] ?? null;

    if (!$id_uzytkownika || !is_numeric($id_uzytkownika)) {
        $error = "Nie wybrano użytkownika.";
    } elseif ($tekstZadania === '') {
        $error = "Treść zadania nie może być pusta.";
    } else {
        $stmtCheck = $conn->prepare("SELECT id_AktUzy FROM aktywnosci_uzytkownik WHERE id_aktywnosci = ? AND id_uzytkownika = ?");
        $stmtCheck->bind_param("ii", $id_aktywnosci, $id_uzytkownika);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $row = $resultCheck->fetch_assoc();
            $id_wsp = $row['id_AktUzy'];
        } else {
            $stmtInsert = $conn->prepare("INSERT INTO aktywnosci_uzytkownik (id_aktywnosci, id_uzytkownika) VALUES (?, ?)");
            $stmtInsert->bind_param("ii", $id_aktywnosci, $id_uzytkownika);
            $stmtInsert->execute();
            if ($stmtInsert->affected_rows > 0) {
                $id_wsp = $conn->insert_id;
            } else {
                $error = "Błąd podczas tworzenia powiązania aktywności z użytkownikiem.";
            }
            $stmtInsert->close();
        }
        $stmtCheck->close();

        if (!$error) {
            $stmtZadanie = $conn->prepare("INSERT INTO podzial_zad (id_wsp, trescZadania, status, dataUkonczenia) VALUES (?, ?, ?, ?)");
            $stmtZadanie->bind_param("isss", $id_wsp, $tekstZadania, $status, $dataUkonczenia);
            $stmtZadanie->execute();

            if ($stmtZadanie->affected_rows > 0) {
                $success = "Zadanie dodane pomyślnie.";
                $tekstZadania = '';
                $status = 'nie rozpoczęto realizacji';
                $dataUkonczenia = null;
            } else {
                $error = "Błąd podczas dodawania zadania.";
            }
            $stmtZadanie->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj podział zadań</title>
    <link rel="stylesheet" href="css/styleAktywnosciSz.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
    <div class="panel-boczny">
        <h3>Nawigacja</h3>
        <ul>
            <li><a href="aktywnosci_grupowe.php">Wróć do strony aktywności</a></li>
            <li><a href="aktywnosc_szczegoly.php?id=<?= htmlspecialchars($id_aktywnosci) ?>">Powrót do szczegółów aktywności</a></li>
        </ul>
    </div>

    <div class="szczegoly-aktywnosci">
        <h2>Dodaj zadanie do aktywności</h2>

        <?php if (!empty($error)): ?>
            <div class="blad" style="color: red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="sukces" style="color: green;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" class="zadanie-form">
            <label for="id_uzytkownika">Użytkownik:</label><br>
            <select name="id_uzytkownika" id="id_uzytkownika" required>
                <option value="">-- Wybierz użytkownika --</option>
                <?php while ($user = $resultUsers->fetch_assoc()): ?>
                    <option value="<?= $user['id'] ?>" <?= (isset($id_uzytkownika) && $id_uzytkownika == $user['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user['nick']) ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="tekstZadania">Treść zadania:</label><br>
            <textarea id="tekstZadania" name="tekstZadania" rows="4" cols="50" required><?= isset($tekstZadania) ? htmlspecialchars($tekstZadania) : '' ?></textarea><br><br>

            <label for="status">Status zadania:</label><br>
            <select name="status" id="status">
                <option value="nie rozpoczęto realizacji" <?= (isset($status) && $status == 'nie rozpoczęto realizacji') ? 'selected' : '' ?>>Nie rozpoczęto realizacji</option>
                <option value="w trakcie realizacji" <?= (isset($status) && $status == 'w trakcie realizacji') ? 'selected' : '' ?>>W trakcie realizacji</option>
                <option value="ukonczono" <?= (isset($status) && $status == 'ukonczono') ? 'selected' : '' ?>>Ukończono</option>
            </select><br><br>

            <label for="dataUkonczenia">Data ukończenia:</label><br>
            <input type="date" id="dataUkonczenia" name="dataUkonczenia" value="<?= isset($dataUkonczenia) ? htmlspecialchars($dataUkonczenia) : '' ?>"><br><br>

            <button type="submit">Dodaj zadanie</button>
        </form>
    </div>
</article>

<?php require_once 'elementy/footer.php'; ?>
</body>
</html>
