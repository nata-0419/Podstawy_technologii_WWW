<?php

$stmt = $conn->prepare("SELECT sciezka FROM galeria WHERE id_aktywnosci = ?");
$stmt->bind_param("i", $id_aktywnosci);
$stmt->execute();
$result = $stmt->get_result();

$zdjecia = [];
while ($row = $result->fetch_assoc()) {
    $zdjecia[] = $row['sciezka'];
}
?>


<section class="galeria-aktywnosci">
    <h3>Galeria zdjęć</h3>
    <div class="galeria">
        <?php if (empty($zdjecia)): ?>
            <p>Brak zdjęć dla tej aktywności.</p>
        <?php else: ?>
            <?php foreach ($zdjecia as $index => $zdj): ?>
                <a href="#img<?= $index ?>" class="galeria-kafelek">
                    <img src="zdjecia/aktywnosci/<?= htmlspecialchars($zdj) ?>" alt="Zdjęcie">
                </a>
                <div id="img<?= $index ?>" class="modal">
                    <a href="#" class="modal-zamknij">×</a>
                    <img src="zdjecia/aktywnosci/<?= htmlspecialchars($zdj) ?>" alt="Zdjęcie">
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
