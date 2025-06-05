<?php
session_start();
require_once __DIR__ . '/../baza.php';

if (!isset($_SESSION['user_id'])) {
    die("Brak dostępu – musisz być zalogowany.");
}

$id_uzytkownika = $_SESSION['user_id'];
$id_aktywnosci = $_POST['id_aktywnosci'] ?? null;
$komentarz = trim($_POST['komentarz'] ?? '');

if (!$id_aktywnosci || !$komentarz) {
    die("Nieprawidłowe dane.");
}

$stmt = $conn->prepare("
    SELECT id_AktUzy 
    FROM aktywnosci_uzytkownik 
    WHERE id_uzytkownika = ? AND id_aktywnosci = ?
");
$stmt->bind_param("ii", $id_uzytkownika, $id_aktywnosci);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $id_wsp = $row['id_AktUzy'];

    $stmt = $conn->prepare("
        INSERT INTO komentarze (id_wsp, komentarz, data_dodania) 
        VALUES (?, ?, NOW())
    ");
    $stmt->bind_param("is", $id_wsp, $komentarz);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("SELECT nick FROM uzytkownik WHERE id = ?");
        $stmt->bind_param("i", $id_uzytkownika);
        $stmt->execute();
        $userRes = $stmt->get_result();
        $nick = htmlspecialchars($userRes->fetch_assoc()['nick'] ?? 'Nieznany');

        echo '<div class="komentarz">';
            echo '<strong>' . $nick . '</strong> ';
            echo '<small>' . date('Y-m-d') . '</small>';
            echo '<p>' . nl2br(htmlspecialchars($komentarz)) . '</p>';
        echo '</div>';
        exit;
    } else {
        echo "Błąd przy dodawaniu komentarza: " . $stmt->error;
    }

} else {
    echo "Nie masz dostępu do tej aktywności – komentarz nie może być dodany.";
}