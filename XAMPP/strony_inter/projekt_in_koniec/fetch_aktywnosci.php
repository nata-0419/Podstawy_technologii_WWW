<?php
require_once 'baza.php';

$username = $_SESSION['nick'] ?? '';
$aktywnosci = [];

if ($username) {
    $stmt = $conn->prepare("SELECT id FROM uzytkownik WHERE nick = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $id_uzytkownika = $user['id'];
    $stmt->close();

    $sql = "
        SELECT ag.id, ag.nazwa, ag.opis, ag.termin, ag.typ, s.statusZam, s.ikona
        FROM aktywnosci_grupowe ag
        JOIN aktywnosci_uzytkownik au ON ag.id = au.id_aktywnosci
        LEFT JOIN status s ON ag.id = s.id_aktywnosci
        WHERE au.id_uzytkownika = ?
        ORDER BY ag.termin ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_uzytkownika);
    $stmt->execute();
    $result = $stmt->get_result();
    $aktywnosci = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>
