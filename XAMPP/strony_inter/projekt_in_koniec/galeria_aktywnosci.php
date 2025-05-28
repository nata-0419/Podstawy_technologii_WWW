<?php
require_once 'baza.php';
$aktywnosc_id = $_GET['id'] ?? 0;

if (!$aktywnosc_id) {
    echo "Brak wybranego wydarzenia.";
    exit;
}

// Pobieramy dane wydarzenia
$stmt = $pdo->prepare("SELECT nazwa, termin FROM aktywnosci_grupowe WHERE id = ?");
$stmt->execute([$aktywnosc_id]);
$aktywnosc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aktywnosc) {
    echo "Nie znaleziono wydarzenia o podanym ID.";
    exit;
}

// Pobieramy zdjęcia powiązane z aktywnością
$stmt = $pdo->prepare("SELECT sciezka FROM galeria WHERE id_aktywnosci = ?");
$stmt->execute([$aktywnosc_id]);
$zdjecia = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Galeria - <?= htmlspecialchars($aktywnosc['nazwa']) ?></title>
  <style>
    .galeria-wrapper {
      max-width: 900px;
      margin: 20px auto;
      font-family: Arial, sans-serif;
      padding: 0 10px;
    }
    .galeria-wrapper h2 {
      margin-bottom: 5px;
    }
    .galeria-wrapper p {
      margin: 0 0 10px;
      color: #555;
    }
    .galeria {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .galeria img {
      width: 200px;
      height: auto;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s;
    }
    .galeria img:hover {
      transform: scale(1.05);
    }
    #lightbox {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    #lightbox img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<main class="galeria-wrapper">
  <h2><?= htmlspecialchars($aktywnosc['nazwa']) ?></h2>
  <p><strong>Data:</strong> <?= htmlspecialchars($aktywnosc['termin']) ?></p>

  <?php if (!empty($zdjecia)): ?>
    <div class="galeria">
      <?php foreach ($zdjecia as $z): ?>
        <img src="zdjecia/aktywnosci/<?= htmlspecialchars($z['sciezka']) ?>" alt="Zdjęcie" onclick="powiekszObraz(this)">
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>Brak zdjęć dla tego wydarzenia.</p>
  <?php endif; ?>
</main>

<div id="lightbox" onclick="zamknijLightbox()">
  <img id="powiekszone-zdjecie" src="" alt="Powiększone zdjęcie">
</div>

<script>
function powiekszObraz(img) {
  const lightbox = document.getElementById('lightbox');
  const powiekszone = document.getElementById('powiekszone-zdjecie');
  powiekszone.src = img.src;
  lightbox.style.display = 'flex';
}

function zamknijLightbox() {
  document.getElementById('lightbox').style.display = 'none';
}
</script>

</body>
</html>
