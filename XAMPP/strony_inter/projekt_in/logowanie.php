<?php

require_once 'baza.php';
session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $haslo = $_POST['haslo'];
        $nick = $conn->real_escape_string($_POST['nick']);
        echo "POST działa!";


        $stmt = $conn->prepare("SELECT * FROM uzytkownik WHERE nick = ?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($haslo, $user['haslo'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nick'] = $user['nick'];
                header("Location: StronaUzytkownika.php");
                exit();
            } else {
                $error = "Nieprawidłowe hasło.";
            }
        } else {
            $error = "Użytkownik nie istnieje.";
        }    
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Logowanie</title>
</head>
<body>

    <header>
        <h1>Logowanie na harmonogram dnia</h1>
    </header>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>


    <article>
            <div class="karta">
        <h2>Zaloguj się na swoje konto</h2>

        <br>
        <form method="POST">
            <table>
                <tr>
                    <td><label for="nick">Wpisz Nick:</label></td>
                    <td><input type="text" name="nick" id="nick" placeholder="Nick" required></td>
                </tr>
                <tr>
                    <td><label for="haslo">Wpisz Hasło:</label></td>
                    <td><input type="password" name="haslo" id="haslo" placeholder="Hasło" required></td>
                </tr>
            </table>
        <br>
        <div class="przyciski">
            <button class="butLog" type="submit">Zaloguj</button>
            <a href="home.php"><button type="button" class="butLog">Wróć do strony głównej</button></a>
        </div>
</form>
    </article>


    <?php   require_once 'elementy/footer.php';     ?>

    
</body>
</html>