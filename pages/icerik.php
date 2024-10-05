<?php
include("../conn/conn.php"); // Veritabanı bağlantısını sağla
session_start();

// Makale ID'sini al
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Eğer id yoksa 0 olarak ayarla

// Veritabanından makaleyi al
$query = "SELECT * FROM post WHERE id = :id"; // Post tablosundan ilgili makaleyi al
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Eğer makale bulunamazsa, hata mesajı göster
if (!$post) {
    echo "<h2>Makale bulunamadı.</h2>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makale İçeriği</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-wrapper {
            overflow-wrap: break-word; /* Uzun kelimelerin satır sonlarında kırılmasını sağlar */
            word-wrap: break-word; /* Eski tarayıcı desteği için */
            white-space: normal; /* Metnin normal bir şekilde sarılmasını sağlar */
            hyphens: auto; /* Heceleme için */
        }
    </style>
</head>

<body>

<?php include("./components/header.php") ?>
  <section class="article-content py-5">
    <div class="container">
      <!-- Makale Başlığı ve Detayları -->
      <div class="row">
        <div class="col-12">
          <h1 class="display-4 mb-4 mt-5"><?php echo htmlspecialchars($post['baslik']); ?></h1>
          <p class="text-muted">Yazar: <strong><?php echo htmlspecialchars($post['yazar']); ?></strong> | Yayınlanma Tarihi: <strong><?php echo (new DateTime($post['tarih']))->format('Y-m-d'); ?></strong></p>
        </div>
      </div>

      <!-- Kapak Resmi -->
      <div class="row mb-5">
        <div class="col-12">
          <img src="./public/images/<?php echo htmlspecialchars($post['resim']); ?>" alt="Makale Kapak Resmi" class="img-fluid rounded shadow"> <!-- Kapak resmi dinamik olarak alınıyor -->
        </div>
      </div>

      <!-- Makale İçeriği -->
      <div class="row">
      <div class="col-lg-8">
    <article>
        <div class="content-wrapper">
            <p class="lead"><?php echo nl2br(htmlspecialchars($post['icerik'])); ?></p> <!-- Makale içeriği -->
        </div>
    </article>
</div>


        <!-- Yan Panel (Önerilen Makaleler) -->
        <div class="col-lg-4">
    <aside>
        <h4 class="mb-3">Önerilen Makaleler</h4>
        <ul class="list-group">
            <?php
            // Önerilen makaleleri almak için SQL sorgusu
            $query = "SELECT * FROM post ORDER BY tarih DESC LIMIT 5"; // Son 5 makale
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $recommendedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Eğer 5'ten az makale varsa, o kadarını gösterecektir
            foreach ($recommendedPosts as $recommendedPost) {
            ?>
                <li class="list-group-item">
                    <a href="./icerik.php?id=<?php echo $recommendedPost['id']; ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($recommendedPost['baslik']); ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </aside>
</div>

      </div>
    </div>
  </section>
  <?php include("./components/footer.php");?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
