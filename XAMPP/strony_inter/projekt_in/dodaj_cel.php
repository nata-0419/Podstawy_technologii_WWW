<?php
session_start();
require_once 'baza.php';

$komunikat = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza
    $id_uzytkownika = $_SESSION['user_id'] ?? null; // załóżmy, że masz zalogowanego usera w sesji
    $nazwa = trim($_POST['nazwa'] ?? '');
    $kategoria = trim($_POST['kategoria'] ?? '');
    $opis = trim($_POST['opis'] ?? '');

    // Walidacja
    if (!$id_uzytkownika) {
        $komunikat = "Musisz być zalogowany, aby dodać cel.";
    } elseif ($nazwa === '' || $kategoria === '') {
        $komunikat = "Nazwa i kategoria są wymagane.";
    } else {
        // Wstaw do bazy
        $sql = "INSERT INTO cele (id_uzytkownika, nazwa, kategoria, opis) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isss", $id_uzytkownika, $nazwa, $kategoria, $opis);
            if ($stmt->execute()) {
                $komunikat = "Cel został dodany pomyślnie!";
            } else {
                $komunikat = "Błąd podczas dodawania celu: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $komunikat = "Błąd przygotowania zapytania.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Dodaj nowy cel</title>
    <link rel="stylesheet" href="css/style_cel.css" />
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
    <div class="karta">
        <h2>Dodaj nowy cel</h2>

        <?php if ($komunikat): ?>
            <p style="color: <?= strpos($komunikat, 'Błąd') === false ? 'green' : 'red' ?>;">
                <?= htmlspecialchars($komunikat) ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="dodaj_cel.php">
            <table>
                <tr>
                    <td>Nazwa celu:</td>
                    <td><input type="text" name="nazwa" required></td>
                </tr>
                <tr>
                    <td>Kategoria:</td>
                    <td><input type="text" name="kategoria" required></td>
                </tr>
                <tr>
                    <td>Opis:</td>
                    <td><textarea name="opis" rows="4"></textarea></td>
                </tr>
            </table>
            <div class="przyciski">
                <button class="butLog" type="submit">Dodaj cel</button>
                <a href="StronaUzytkownika.php"><button type="button" class="butLog">Wróć</button></a>
            </div>
        </form>
    </div>
</article>

<?php require_once 'elementy/footer.php'; ?>

</body>
</html>
