<script>
function sortTableByDate(colIndex) {
  const table = document.querySelector(".aktywnosci-tabela");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.rows);
  const isAsc = table.getAttribute("data-sort") !== "asc";

  rows.sort((a, b) => {
    const dateA = new Date(a.cells[colIndex].innerText.trim());
    const dateB = new Date(b.cells[colIndex].innerText.trim());
    return isAsc ? dateA - dateB : dateB - dateA;
  });

  rows.forEach(row => tbody.appendChild(row));
  table.setAttribute("data-sort", isAsc ? "asc" : "desc");
}
</script>

<script>
function wyszukajAktywnosc() {
    const input = document.getElementById("wyszukajInput").value.toLowerCase();
    const rows = Array.from(document.querySelectorAll(".aktywnosci-tabela tbody tr"));

    rows.forEach(row => row.classList.remove("highlight")); // usuń podświetlenia

    const znalezione = rows.filter(row => {
        const nazwa = row.cells[1].innerText.toLowerCase();
        return nazwa.includes(input);
    });

    const tbody = document.querySelector(".aktywnosci-tabela tbody");
    znalezione.reverse().forEach(row => {
        row.classList.add("highlight");
        tbody.prepend(row);
    });
}
</script>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleAktywnosci.css">
    <title>Strona użytkownika</title>
</head>
<body>
    
    <?php   require_once 'elementy/header.php';     ?>

<article>

<div class="Aktywnosci">

    <nav class="Nawigacja">
        <ul>
            <li><a href="aktywnosci_grupowe.php">Wróć do strony aktywności</a></li>
            <li><a href="dodaj_aktywnosci.php">Dodaj aktywność</a></li>
            <div class="wyszukiwarka-kompakt">
                <input type="text" id="wyszukajInput" placeholder="Szukaj aktywności...">
                <button onclick="wyszukajAktywnosc()">🔍</button>
            </div>
        </ul>
    </nav>


    <div class="Tabela">
        <br>
            <h3>Twoje aktywności grupowe</h3>
        <br>
    <?php require_once 'fetch_aktywnosci.php'; ?>
<table class="aktywnosci-tabela">
    <thead>
        <tr>
            <th>#</th>
            <th>Nazwa</th>
            <th>Opis</th>
            <th onclick="sortTableByDate(3)" style="cursor: pointer;">▲ Termin ▼</th>
            <th>Typ</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($aktywnosci)): ?>
            <?php
            foreach ($aktywnosci as $a):
                $klasa_statusu = strtolower(str_replace(' ', '_', $a['statusZam']));
            ?>
            <tr class="<?= $klasa_statusu ?>">
                <td><?= $a['id'] ?></td>
                <td>
                    <a href="aktywnosc_szczegoly.php?id=<?= $a['id'] ?>">
                        <?= htmlspecialchars($a['nazwa']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($a['opis']) ?></td>
                <td><?= $a['termin'] ?></td>
                <td><?= htmlspecialchars($a['typ']) ?></td>
                <td><?= $a['ikona'] . ' ' . $a['statusZam'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Brak aktywności przypisanych do Ciebie.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>
</div>

    <div class="Menu">
        <h3>Menu</h3>
        <ul>
            <li><a href="StronaUzytkownika.php">Strona główna użytkownika</a></li>
            <li><a href="cele_uzytkownika.php">Wyświetl zaplanowane cele</a></li>
            <li><a href="aktywnosci_grupowe.php">Wyświetl zadania rodzinne</a></li>
        </ul>
    </div>
    </article>

    <?php   require_once 'elementy/footer.php';     ?>

</body>
</html>