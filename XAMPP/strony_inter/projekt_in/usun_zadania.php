<?php
session_start();
require_once 'baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_zadania = (int)$_POST['id'];

    $sql1 = "DELETE FROM szczegoly_zad WHERE id_zadania = ?";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1) {
        $stmt1->bind_param("i", $id_zadania);
        $stmt1->execute();
        $stmt1->close();
    }

    $sql2 = "DELETE FROM zadania WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2) {
        $stmt2->bind_param("i", $id_zadania);
        if ($stmt2->execute()) {
            $_SESSION['komunikat'] = "Zadanie zostało usunięte.";
        } else {
            $_SESSION['komunikat'] = "Błąd podczas usuwania zadania: " . $stmt2->error;
        }
        $stmt2->close();
    }
    header("Location: StronaUzytkownika.php");
    exit;
} else {
    die("Brak ID zadania do usunięcia.");
}
?>
