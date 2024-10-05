<?php

include("../conn/conn.php");
session_start(); // Oturumu başlat
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 5 Navbar</title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  <header class="vh-100">
<?php include("./components/header.php");?>
<div class="container h-100 d-flex align-items-center justify-content-center">
    <div class="text-center">
        <h1 class="display-4 text-light">Blog Sayfama Hoşgeldiniz.</h1>
        <p class="lead text-light">Teknoloji, yazılım ve tasarım hakkındaki düşüncelerinizi ve fikirlerinizi paylaşın.</p>
        <a href="#latest-posts" class="btn btn-primary btn-lg mt-3">Bloglara Gidin.</a>
    </div>
</div>
</header>
<?php

// Postları veritabanından çek
$query = "SELECT * FROM post"; // Tüm postları seç
$stmt = $conn->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Tüm sonuçları al

?>

<div class="container mt-3 mb-4">
    <div class="row g-3">
        <?php foreach ($posts as $post): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card" id="latest-posts">
                    <img src="./public/images/<?php echo htmlspecialchars($post['resim']); ?>" alt="" class="card-img-top img-fluid d-block mx-auto"> <!-- Post için resim -->
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($post['baslik']); ?></h5> <!-- Post başlığı -->
                        <p class="card-text">
                            <?php 
                            // İçeriği 50 karakterle sınırla
                            echo htmlspecialchars(mb_substr($post['icerik'], 0, 50)); 
                            if (mb_strlen($post['icerik']) > 50) {
                                echo '...'; // 50 karakterden fazlaysa '...' ekle
                            }
                            ?>
                        </p> <!-- Post içeriği -->
                        <p class="card-text"><?php echo (new DateTime($post['tarih']))->format('Y-m-d'); ?></p> <!-- Tarih -->
                        <a href="./icerik.php?id=<?php echo $post['id']; ?>">
                            <button type="button" class="btn btn-primary">Daha Fazla</button>
                        </a> <!-- ID eklendi --> <!-- Buton -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php include("./components/footer.php");?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>