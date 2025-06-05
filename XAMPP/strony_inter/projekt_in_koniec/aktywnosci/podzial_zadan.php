<?php

$stmt = $conn->prepare("
    SELECT u.nick, pz.id, pz.trescZadania, pz.status, pz.dataUkonczenia FROM podzial_zad pz
    JOIN aktywnosci_uzytkownik au ON pz.id_wsp = au.id_AktUzy JOIN uzytkownik u ON au.id_uzytkownika = u.id
    WHERE au.id_aktywnosci = ?
");

$stmt->bind_param("i", $id_aktywnosci);
$stmt->execute();
$result = $stmt->get_result();

?>

<section class="podzial-zadan">
    <h3> Podział zadań</h3>

    <?php if ($result->num_rows === 0): ?>
        <p>Brak przypisanych zadań.</p>
    <?php else: ?>
    <table class="zadania-tabela">
        <thead>
            <tr>
                <th>Użytkownik</th>
                <th>Zadanie</th>
                <th>Status</th>
                <th>Data ukończenia</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nick']) ?></td>
                    <td><?= htmlspecialchars($row['trescZadania']) ?></td>
                    <td>
                            <form action="aktywnosci/zmien_status.php" method="post">
                                <input type="hidden" name="id_zadania" value="<?= $row['id'] ?>">
                                <select name="status">
                                    <option value="nie rozpoczeto realizacji" <?= $row['status'] == 'nie rozpoczeto realizacji' ? 'selected' : '' ?>>Oczekujące do realizacji</option>
                                    <option value="w trakcie realizacji" <?= $row['status'] == 'w trakcie realizacji' ? 'selected' : '' ?>>W trakcie realizacji</option>
                                    <option value="zakonczono swoja czesc" <?= $row['status'] == 'zakonczono swoja czesc' ? 'selected' : '' ?>>Zakończono swoje zadanie</option>
                                </select>
                                <button type="submit">Zmień</button>
                            </form>
                    </td>
                    <td><?= $row['dataUkonczenia'] ?: '—' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>
