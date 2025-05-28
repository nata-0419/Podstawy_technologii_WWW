<?php
require_once __DIR__ . '/../baza.php';


$id_aktywnosci = $_GET['id'] ?? null;
$id_uzytkownika = $_SESSION['user_id'] ?? 0;

// Sprawdź, czy użytkownik ma dostęp do tej aktywności
$stmt = $conn->prepare("
    SELECT * FROM aktywnosci_uzytkownik 
    WHERE id_uzytkownika = ? AND id_aktywnosci = ?
");
$stmt->bind_param("ii", $id_uzytkownika, $id_aktywnosci);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "Brak dostępu do tej aktywności.";
    exit;
}

$stmt = $conn->prepare("
    SELECT k.komentarz, k.data_dodania, u.nick
    FROM komentarze k
    JOIN aktywnosci_uzytkownik au ON k.id_wsp = au.id_AktUzy
    JOIN uzytkownik u ON au.id_uzytkownika = u.id
    WHERE au.id_aktywnosci = ?
    ORDER BY k.data_dodania ASC
");
$stmt->bind_param("i", $id_aktywnosci);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="komentarze">
    <h3>Komentarze</h3>

    <div class="lista-komentarzy">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="komentarz">
                <strong><?= htmlspecialchars($row['nick']) ?></strong>
                <small><?= $row['data_dodania'] ?></small>
                <p><?= nl2br(htmlspecialchars($row['komentarz'])) ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <form action="aktywnosci/dodaj_komentarz.php" method="post">
        <input type="hidden" name="id_aktywnosci" value="<?= $id_aktywnosci ?>">
        <textarea name="komentarz" required rows="3" placeholder="Napisz komentarz..."></textarea><br>
        <button type="submit">Dodaj komentarz</button>
    </form>
</section>
