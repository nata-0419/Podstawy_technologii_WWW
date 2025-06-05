<?php
session_start();
require_once 'baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_celu = (int)$_POST['id'];

    $sql1 = "DELETE FROM szczegoly_celu WHERE id_celu = ?";
    $stmt1 = $conn->prepare($sql1);
    if ($stmt1) {
        $stmt1->bind_param("i", $id_celu);
        $stmt1->execute();
        $stmt1->close();
    }

    $sql2 = "DELETE FROM cele WHERE id = ?";
    $stmt2 = $conn->prepare($sql2);
    if ($stmt2) {
        $stmt2->bind_param("i", $id_celu);
        if ($stmt2->execute()) {
            $_SESSION['komunikat'] = "Cel został usunięty.";
        } else {
            $_SESSION['komunikat'] = "Błąd podczas usuwania celu: " . $stmt2->error;
        }
        $stmt2->close();
    }

    header("Location: cele_uzytkownika.php");
    exit;
} else {
    die("Brak ID celu do usunięcia.");
}
?>
