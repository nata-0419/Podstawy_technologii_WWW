<?php
$conn = new mysqli("localhost", "root", "", "harmonogram");

$id_zadania = $_GET['id'];

$query = " SELECT z.nazwa, z.piorytet, z.kategoria, sz.stan_realizacji, sz.szczegoly, sz.data, sz.godzina
    FROM zadania z JOIN szczegoly_zad sz ON z.id = sz.id_zadania WHERE z.id = ? ";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_zadania);
$stmt->execute();

$result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Nie znaleziono szczegółów dla tego zadania.</p>";
    }

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_zadania.css">
    <title>Szczegóły Zadania</title>
</head>
<body>


    <?php   require_once 'elementy/header.php';     ?>


<main class="main-content">
<article>

<div class="karta">
    <h1>Szczegóły zadania: <?php echo htmlspecialchars($row['nazwa']); ?></h1><br>

    <div class="szczegoly-zadania">
        <p><strong>Priorytet:</strong> <?php echo htmlspecialchars($row['piorytet']); ?></p>
        <p><strong>Kategoria:</strong> <?php echo htmlspecialchars($row['kategoria']); ?></p>
        <p><strong>Stan realizacji:</strong> <?php echo htmlspecialchars($row['stan_realizacji']); ?></p>
        <p><strong>Szczegóły:</strong> <?php echo nl2br(htmlspecialchars($row['szczegoly'])); ?></p>
        <p><strong>Data:</strong> <?php echo htmlspecialchars($row['data']); ?></p>
        <p><strong>Godzina:</strong> <?php echo htmlspecialchars($row['godzina']); ?></p>
    </div>
<br><br>
    <div class="przyciski">
        <br>
        <form action="edycja_zadania.php" method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id_zadania) ?>">
            <button type="submit" class="butLog">Edycja zadania</button>
        </form>

        <form method="POST" action="usun_zadania.php" onsubmit="return confirm('Czy na pewno chcesz usunąć to zadanie?');">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id_zadania) ?>">
            <button type="submit" class="butLog">Usuń zadanie</button>
        </form>


        <a href="StronaUzytkownika.php"><button type="button" class="butLog">Wróć do harmonogramu</button></a>
    </div>
</div>
</article>

<?php   require_once 'elementy/footer.php';     ?>
</main>

</body>
</html>
