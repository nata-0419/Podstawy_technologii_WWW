<?php
session_start();
require_once 'baza.php';

$id_celu = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$id_celu || !is_numeric($id_celu)) {
    echo "Brak lub nieprawidłowe ID celu.";
    exit;
}
$id_celu = (int)$id_celu;
$username = $_SESSION['nick'];

    $stmt = $conn->prepare("SELECT id FROM uzytkownik WHERE nick = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();
        if ($user_result->num_rows === 0) {
            echo "Użytkownik nie istnieje.";
            exit;
        }
$id_uzytkownika = $user_result->fetch_assoc()['id'];

$query = "SELECT c.nazwa, c.kategoria, c.opis, c.zdjecie, s.koszty, s.uzbierana_kwota, s.data_rozpoczecia, s.data_zakonczenia, s.status
            FROM cele c JOIN szczegoly_celu s ON c.id = s.id_celu WHERE c.id = ? AND c.id_uzytkownika = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_celu, $id_uzytkownika);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "Nie znaleziono celu.";
        exit;
    }

$cel = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $_POST['nazwa'];
    $kategoria = $_POST['kategoria'];
    $opis = $_POST['opis'];
    $koszty = floatval($_POST['koszty']);
    $uzbierana_kwota = floatval($_POST['uzbierana_kwota']);
    $data_rozpoczecia = $_POST['data_rozpoczecia'];
    $data_zakonczenia = $_POST['data_zakonczenia'];
    $status = $_POST['status'];
    $zdjecie = $cel['zdjecie'];

    if (!empty($_FILES['zdjecie']['name'])) {
        $upload_dir = "zdjecia/cele/";
        $nowe_zdjecie = basename($_FILES["zdjecie"]["name"]);
        $upload_path = $upload_dir . $nowe_zdjecie;
        if (move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $upload_path)) {
            $zdjecie = $nowe_zdjecie;
        } else {
            echo "Błąd przesyłania zdjęcia.";
            exit;
        }
    }
    $stmt1 = $conn->prepare("UPDATE cele SET nazwa=?, kategoria=?, opis=?, zdjecie=? WHERE id=? AND id_uzytkownika=?");
    $stmt1->bind_param("ssssii", $nazwa, $kategoria, $opis, $zdjecie, $id_celu, $id_uzytkownika);
    $stmt1->execute();

    $stmt2 = $conn->prepare("UPDATE szczegoly_celu SET koszty=?, uzbierana_kwota=?, data_rozpoczecia=?, data_zakonczenia=?, status=? WHERE id_celu=?");
    $stmt2->bind_param("ddsssi", $koszty, $uzbierana_kwota, $data_rozpoczecia, $data_zakonczenia, $status, $id_celu);
    $stmt2->execute();

    header("Location: cele_uzytkownika.php");
    exit;
}
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
    <div class="karta">
    <h2>Edytuj plany na przyszlość</h2>

    <?php
        if (!empty($komunikat)) {
            echo '<p style="color: green;">' . $komunikat . '</p>';
        }
    ?>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id_celu ?>">
        <table>
            <tr>
                <td>Podaj nazwę celu:</td>
                <td><input type="text" name="nazwa" value="<?= htmlspecialchars($cel['nazwa']) ?>" required></td>
            </tr>
            <tr>
                <td>Podaj kategorię:</td>
                <td><input type="text" name="kategoria" value="<?= htmlspecialchars($cel['kategoria']) ?>" required></td>
            </tr>
            <tr>
                <td>Podaj opis:</td>
                <td><textarea name="opis" required><?= htmlspecialchars($cel['opis']) ?></textarea></td>
            </tr>
            <tr>
                <td>Podaj zdjęcie:</td>
                <td>
                    <input type="file" name="zdjecie">
                    <?php if (!empty($cel['zdjecie'])): ?>
                        (obecne: <?= htmlspecialchars($cel['zdjecie']) ?>)
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Podaj szacowany koszt:</td>
                <td><input type="number" step="0.01" name="koszty" value="<?= $cel['koszty'] ?>" required></td>
            </tr>
            <tr>
                <td>Podaj zebraną kwotę:</td>
                <td><input type="number" step="0.01" name="uzbierana_kwota" value="<?= $cel['uzbierana_kwota'] ?>" required></td>
            </tr>
            <tr>
                <td>Data rozpoczęcia:</td>
                <td><input type="date" name="data_rozpoczecia" value="<?= $cel['data_rozpoczecia'] ?>" required></td>
            </tr>
            <tr>
                <td>Data zakończenia:</td>
                <td><input type="date" name="data_zakonczenia" value="<?= $cel['data_zakonczenia'] ?>" required></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <select name="status" required>
                        <option value="nie rozpoczęto planowania" <?= $cel['status'] === "nie rozpoczęto planowania" ? "selected" : "" ?>>Nie rozpoczęto planowania</option>
                        <option value="w trakcie planowania" <?= $cel['status'] === "w trakcie planowania" ? "selected" : "" ?>>W trakcie planowania</option>
                        <option value="w trakcie wykonywania" <?= $cel['status'] === "w trakcie wykonywania" ? "selected" : "" ?>>W trakcie wykonywania</option>
                        <option value="ukończony cel" <?= $cel['status'] === "ukończony cel" ? "selected" : "" ?>>Ukończony cel</option>
                    </select>
                </td>
            </tr>
        </table>

    <div class="przyciski">
        <button type="submit" class="butLog">Zapisz zmiany</button>
        <a href="cele_uzytkownika.php"><button type="button" class="butLog">Wróć na stronę planów</button></a>
    </div>
    </form>

    </div>
</article>
        <?php require_once 'elementy/footer.php'; ?>

</body>
</html>
