<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once 'baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $nick = $_POST['nick'] ?? '';
    $haslo = $_POST['haslo'] ?? '';
    $haslo_powtorz = $_POST['haslo_powtorz'] ?? '';    
    $zdjecie = $_POST['zdjecie'] ?? '';

    if (empty($imie) || empty($nazwisko) || empty($nick) || empty($haslo) || empty($haslo_powtorz)) {
        $error = "Wszystkie pola są wymagane.";
    } elseif ($haslo !== $haslo_powtorz) {
        $error = "Hasła nie są identyczne.";
    } elseif (strlen($haslo) < 6) {
        $error = "Hasło musi mieć co najmniej 6 znaków.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM uzytkownik WHERE nick = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Użytkownik o podanym nicku już istnieje.";
        } else {

            $hashed_password = password_hash($haslo, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO uzytkownik (imie, nazwisko, nick, haslo, zdjecie) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $imie, $nazwisko, $nick, $hashed_password, $zdjecie);

            if ($stmt->execute()) {
                $sukces = "Użytkownik $imie $nazwisko o nicku '$nick' został dodany do bazy.";
            } else {
                $error = "Błąd podczas zapisu: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}
?>




<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Rejestracja</title>
</head>
<body>

    <header>
        <h1>Rejestracja do aplikacji "harmonogram dnia"</h1>
    </header>

    <article>
 <div class="karta">
    <h2>Zarejestruj się</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <span class="alert-icon"></span>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($sukces)): ?>
            <div class="alert alert-success">
                <span class="alert-icon"></span>
                <?php echo htmlspecialchars($sukces); ?>
            </div>
        <?php endif; ?>

        <br>
        <p>Wprowadź swoje dane, aby założyć konto:</p>



        <form action="rejestracja.php" method="POST">
            <table>
                <tr>
                    <td><label for="imie">Imię:</label></td>
                    <td><input type="text" name="imie" id="imie" placeholder="Imie" required></td>
                </tr>
                <tr>
                    <td><label for="nazwisko">Nazwisko:</label></td>
                    <td><input type="text" name="nazwisko" id="nazwisko" placeholder="Nazwisko" required></td>
                </tr>
                <tr>
                    <td><label for="nick">Nick:</label></td>
                    <td><input type="text" name="nick" id="nick" placeholder="Nick "required></td>
                </tr>
                <tr>
                    <td><label for="haslo">Hasło:</label></td>
                    <td><input type="password" name="haslo" id="haslo"  placeholder="Hasło" required></td>
                </tr>
                <tr>
                    <td><label for="haslo_powtorz">Powtórz hasło:</label></td>
                    <td><input type="password" name="haslo_powtorz" id="haslo_powtorz"  placeholder="Powtórz hasło"required></td>
                </tr>
                <tr>
                    <td><label for="zdjecie">Zdjęcie:</label></td>
                    <td><input type="text" name="zdjecie" id="zdjecie" placeholder="Zdjęcie"required></td>
                </tr>
            </table>

            <div class="przyciski">
                <button type="submit" class="butLog">Zarejestruj</button>
                <a href="home.php"><button type="button" class="butLog">Wróć do strony głównej</button></a>
            </div>
        </form>

    </div>
    </article>


    <?php    require_once 'elementy/footer.php';     ?>


</body>
</html>
