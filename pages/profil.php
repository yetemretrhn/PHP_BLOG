<?php
// Veritabanı bağlantısını sağlamak için conn.php dosyasını dahil edin.
include ("../conn/conn.php");
session_start();

// Post verilerini eklemek için kontrol
if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    
    // Resmi yüklemek için dizin
    $target_dir = "public/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Resim yükleme kontrolü
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message = "Bu dosya bir resim değil.";
            $uploadOk = 0;
        }
    }

    // Dosya zaten varsa kontrol et
    if (file_exists($target_file)) {
        $message = "Üzgünüm, bu dosya zaten mevcut.";
        $uploadOk = 0;
    }

    // Dosya boyutu kontrolü
    if ($_FILES["image"]["size"] > 500000) {
        $message = "Üzgünüm, dosya çok büyük.";
        $uploadOk = 0;
    }

    // Belirli dosya formatlarına izin ver
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $message = "Üzgünüm, yalnızca JPG, JPEG, PNG ve GIF dosyaları yükleyebilirsiniz.";
        $uploadOk = 0;
    }

    // Herhangi bir hata yoksa dosyayı yükle
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Veritabanına ekleme işlemi
            $stmt = $conn->prepare("INSERT INTO post (baslik, icerik, resim, tarih) VALUES (?, ?, ?, NOW())");
            
            // PDO kullanarak execute metodunu kullanın
            if ($stmt->execute([$title, $content, $_FILES["image"]["name"]])) {
                $message = "Post başarıyla eklendi!";
            } else {
                $message = "Bir hata oluştu: " . $stmt->errorInfo()[2];
            }
            $stmt->closeCursor(); // PDO için kullanışlı
        } else {
            $message = "Üzgünüm, dosyayı yüklerken bir hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #007bff;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php
include("./components/header.php");
?>

<div class="container mt-5">
    <div class="profile-header">
        <img src="public/images/pro.png" alt="Profil Resmi" class="profile-image img-fluid mt-5">
        <h1><?=$kullanici_adi?></h1>
      
    </div>

    <h2 class="mt-4">Yeni Post Ekle</h2>
    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Post Başlığı</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Post İçeriği</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Post Resmi</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Postu Ekle</button>
    </form>

    <div class="col-lg-12 mb-5 mt-5">
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
<?php include("./components/footer.php");?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
