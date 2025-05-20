 <?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'baza.php';

$username = $_SESSION['nick'];

$query = "SELECT id, zdjecie FROM uzytkownik WHERE nick = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $id_uzytkownika = $user['id'];
    $zdjecie = $user['zdjecie'] ? $user['zdjecie'] : 'zdjecia/default.jpg';

    } else {
        echo "Użytkownik nie został znaleziony.";
        exit;
    }

$stmt->close();
?>
 
 <header>
        <p>Witaj, <?php echo htmlspecialchars($username); ?>!</p>        
        <img class='zdjUzytkownika' src='zdjecia/<?php echo htmlspecialchars($zdjecie); ?>'>
        <a class="wyloguj" href="home.php">Wyloguj się</a>
</header>