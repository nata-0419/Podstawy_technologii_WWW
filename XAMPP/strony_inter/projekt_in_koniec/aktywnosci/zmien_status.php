<?php
require_once '../baza.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_zadania = $_POST['id_zadania'] ?? 0;
    $nowy_status = $_POST['status'] ?? '';

    if ($id_zadania && in_array($nowy_status, ['nie rozpoczeto realizacji', 'w trakcie realizacji', 'zakonczono swoja czesc'])) {
        $stmt = $conn->prepare("UPDATE podzial_zad SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $nowy_status, $id_zadania);
        if ($stmt->execute()) {
} else {
    echo "Błąd aktualizacji: " . $stmt->error;
}
exit;
    }
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
