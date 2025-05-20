<?php
$conn = new mysqli("localhost", "root", "", "harmonogramv2");
session_start();

$id_uzytkownika = $_SESSION['id_uzytkownika'] ?? 0;

$query = "SELECT c.id, c.nazwa, c.kategoria, c.opis, sc.koszty, sc.data_wykonania, sc.okres_trwania, sc.status
          FROM cele c
          JOIN szczegoly_celu sc ON c.id = sc.id_celu
          WHERE c.id_uzytkownika = ?
          ORDER BY sc.data_wykonania ASC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_uzytkownika);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moje cele</title>
    <link rel="stylesheet" href="css/style_zadania.css">
</head>
<body>

<?php require_once 'elementy/header.php'; ?>

<article>
    <h1>Moje cele</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): 
            // Suma wpłat z tabeli kwoty
            $id_celu = $row['id'];
            $wp_query = $conn->prepare("SELECT SUM(kwota) as uzbierane FROM kwoty WHERE id_celu = ?");
            $wp_query->bind_param("i", $id_celu);
            $wp_query->execute();
            $wp_result = $wp_query->get_result()->fetch_assoc();
            $uzbierane = $wp_result['uzbierane'] ?? 0;

            $brakuje = $row['koszty'] - $uzbierane;
            $procent = $row['koszty'] > 0 ? round(($uzbierane / $row['koszty']) * 100) : 0;
        ?>
        <div class="karta">
            <h2><?= htmlspecialchars($row['nazwa']) ?></h2>
            <p><strong>Kategoria:</strong> <?= htmlspecialchars($row['kategoria']) ?></p>
            <p><strong>Opis:</strong> <?= nl2br(htmlspecialchars($row['opis'])) ?></p>
            <p><strong>Data wykonania:</strong> <?= htmlspecialchars($row['data_wykonania']) ?></p>
            <p><strong>Okres trwania:</strong> <?= htmlspecialchars($row['okres_trwania']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>

            <p><strong>Koszty:</strong> <?= htmlspecialchars($row['koszty']) ?> zł</p>
            <p><strong>Uzbierane:</strong> <?= $uzbierane ?> zł</p>
            <p><strong>Brakuje:</strong> <?= $brakuje ?> zł</p>

            <p><strong>Postęp:</strong> <?= $procent ?>%</p>
            <div style="background:#ddd;width:300px;height:20px;border-radius:5px;">
                <div style="width:<?= $procent ?>%;height:100%;background:green;"></div>
            </div>

            <br>
            <form method="get" action="szczegoly_celu.php">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="butLog">Szczegóły celu</button>
            </form>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nie masz jeszcze dodanych celów.</p>
    <?php endif; ?>

</article>

<footer>
    <p id="autor">Wykonawca Natalia xxx</p>
</footer>

</body>
</html>
