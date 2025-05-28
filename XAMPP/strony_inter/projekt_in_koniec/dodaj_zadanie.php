<?php
session_start();
require_once 'baza.php';

$komunikat = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_uzytkownika = $_SESSION['id_uzytkownika'] ?? 1;
    $tytul = $_POST['tytul'];
    $kategoria = $_POST['kategoria'];
    $priorytet = $_POST['priorytet'];
    $data = $_POST['data'];
    $godzina = $_POST['godzina'];
    $status = $_POST['status'];
    $szczegoly = $_POST['szczegoly'];

    $sql1 = "INSERT INTO zadania (id_uzytkownika, nazwa, piorytet, kategoria) VALUES (?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1) {
        $stmt1->bind_param("isis", $id_uzytkownika, $tytul, $priorytet, $kategoria);
        if ($stmt1->execute()) {
            $id_zadania = $conn->insert_id;
            $sql2 = "INSERT INTO szczegoly_zad (id_zadania, data, godzina, stan_realizacji, szczegoly) VALUES (?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            if ($stmt2) {
                $stmt2->bind_param("issss", $id_zadania, $data, $godzina, $status, $szczegoly);
                if ($stmt2->execute()) {
                    $komunikat = "Zadanie zostało dodane poprawnie! (ID zadania: $id_zadania)";
                } else {
                    $komunikat = "Błąd przy dodawaniu szczegółów: " . $stmt2->error;
                }
                $stmt2->close();
            } else {
                $komunikat = "Błąd przygotowania zapytania do szczegółów.";
            }
        } else {
            $komunikat = "Błąd przy dodawaniu zadania: " . $stmt1->error;
        }
        $stmt1->close();
    } else {
        $komunikat = "Błąd przygotowania zapytania do zadań.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj zadanie</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

    <?php require_once 'elementy/header.php'; ?>

    <article>

           <form method="POST" action="dodaj_zadanie.php">
    <div class="karta">
        <h2>Dodaj nowe zadanie</h2>

         <?php
                if (!empty($komunikat)) {
                    echo '<p style="color: green;">' . $komunikat . '</p>';
                }
        ?>

        <table>
            <tr>
                <td>Podaj tytul zadania:</td>
                <td><input type="text" name="tytul" placeholder="nazwa" required></td>
            </tr>
            <tr>
                <td>Podaj kategorię zadania:</td>
                <td><input type="text" name="kategoria" placeholder="kategoria" required></td>
            </tr>
            <tr>
                <td>Podaj data wykonania:</td>
                <td><input type="date" name="data" required></td>
            </tr>
            <tr>
                <td>Podaj godzinę wykonania:</td>
                <td><input type="time" name="godzina" placeholder="godzina" ></td>
            </tr>
            <tr>
                <td>Wybierz priorytet:</td>
                <td>
                    <select name="priorytet">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Wybierz aktualny status realizacji:</td>
                <td>
                    <select name="status">
                        <option value="nie rozpoczęto zadania">Nie rozpoczęto zadania</option>
                        <option value="w trakcie realizacji">W trakcie realizacji</option>
                        <option value="zakończenie zadania">Zakończenie zadania</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Podaj szczególy zadania:</td>
                <td><textarea name="szczegoly" placeholder="szczegoly" ></textarea></td>
            </tr>
        </table>

        <div class="przyciski">
            <button class="butLog" type="submit">Dodaj zadanie</button>
            <a href="StronaUzytkownika.php"><button type="button" class="butLog">Wróć na stronę użytkownika</button></a>
        </div>
    </div>
</form>

        </div>
    </article>

    <?php require_once 'elementy/footer.php'; ?>
</body>
</html>
