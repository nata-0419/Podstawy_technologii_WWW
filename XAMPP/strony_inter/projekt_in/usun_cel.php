<?php
session_start();
require_once 'baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_celu = (int)$_POST['id'];
    $id_uzytkownika = $_SESSION['user_id'] ?? null;

    if (!$id_uzytkownika) {
        die("Musisz być zalogowany, aby usunąć cel.");
    }

    // Najpierw sprawdź, czy cel należy do zalogowanego użytkownika
    $checkSql = "SELECT id FROM cele WHERE id = ? AND id_uzytkownika = ?";
    $stmtCheck = $conn->prepare($checkSql);
    $stmtCheck->bind_param("ii", $id_celu, $id_uzytkownika);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows === 0) {
        $stmtCheck->close();
        die("Cel nie istnieje lub nie masz uprawnień do jego usunięcia.");
    }
    $stmtCheck->close();

    // Usuwanie powiązanych rekordów z tabeli kwoty (finanse), jeśli istnieje
    $delFinanseSql = "DELETE FROM kwoty WHERE id_celu = ?";
    $stmtDelFinanse = $conn->prepare($delFinanseSql);
    $stmtDelFinanse->bind_param("i", $id_celu);
    $stmtDelFinanse->execute();
    $stmtDelFinanse->close();

    // Usuwanie celu
    $delCelSql = "DELETE FROM cele WHERE id = ?";
    $stmtDel = $conn->prepare($delCelSql);
    $stmtDel->bind_param("i", $id_celu);

    if ($stmtDel->execute()) {
        $stmtDel->close();
        header("Location: StronaUzytkownika.php?msg=Cel został usunięty");
        exit;
    } else {
        $stmtDel->close();
        die("Błąd podczas usuwania celu.");
    }

} else {
    die("Brak ID celu do usunięcia.");
}
