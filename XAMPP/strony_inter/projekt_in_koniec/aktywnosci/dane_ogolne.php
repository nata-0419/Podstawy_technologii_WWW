<?php
$stmt = $conn->prepare("
    SELECT ag.nazwa, ag.opis, ag.termin, ag.typ, s.statusZam, s.ikona
    FROM aktywnosci_grupowe ag
    LEFT JOIN status s ON ag.id = s.id_aktywnosci
    WHERE ag.id = ?
");
$stmt->bind_param("i", $id_aktywnosci);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<section class='aktywnosc-info'><p>Nie znaleziono aktywności.</p></section>";
    return;
}

$aktywnosc = $result->fetch_assoc();
?>

<section class="aktywnosc-info">
    <h3>Dane ogólne </h3>
    <h2><?= htmlspecialchars($aktywnosc['nazwa']) ?></h2>
    <p><strong>Opis:</strong> <?= nl2br(htmlspecialchars($aktywnosc['opis'])) ?></p>
    <p><strong>Termin:</strong> <?= htmlspecialchars($aktywnosc['termin']) ?></p>
    <p><strong>Typ:</strong> <?= htmlspecialchars($aktywnosc['typ']) ?></p>
    <p><strong>Status:</strong> <?= $aktywnosc['ikona'] ?> <?= htmlspecialchars($aktywnosc['statusZam']) ?></p>
</section>
