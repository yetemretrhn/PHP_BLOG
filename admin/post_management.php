<?php
session_start();

// Eğer oturum açılmamışsa yönlendir
if (!isset($_SESSION['admin'])) {
    header("Location: admin_giris.php");
    exit();
}

include("../conn/conn.php");

// Gönderileri veritabanından çek
$posts_stmt = $conn->prepare("SELECT * FROM post");
$posts_stmt->execute();
$posts = $posts_stmt->fetchAll();

// Gönderi silme işlemi
if (isset($_GET['delete'])) {
    $postId = (int)$_GET['delete'];

    // Silinecek gönderinin resim yolunu al
    $getPost_stmt = $conn->prepare("SELECT resim FROM post WHERE id = ?");
    $getPost_stmt->execute([$postId]);
    $postToDelete = $getPost_stmt->fetch();

    // Gönderiyi silme işlemi
    $delete_stmt = $conn->prepare("DELETE FROM post WHERE id = ?");
    $delete_stmt->execute([$postId]);

    // Resmi sil
    if (!empty($postToDelete['resim'])) {
        $imagePath = '../pages/public/images/' . $postToDelete['resim'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Dosyayı sil
        }
    }

    header("Location: post_management.php");
    exit();
}

// Gönderi düzenleme işlemi
$post = null; // Başlangıçta post nesnesini null yap
if (isset($_GET['edit'])) {
    $postId = (int)$_GET['edit'];
    $post_stmt = $conn->prepare("SELECT * FROM post WHERE id = ?");
    $post_stmt->execute([$postId]);
    $post = $post_stmt->fetch();
}

// Gönderi güncelleme işlemi
if (isset($_POST['update'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $postId = (int)$_POST['post_id'];

    // Resim yükleme işlemi
    $imagePath = $post['resim']; // Varsayılan olarak mevcut resmi al

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
        $imagePath = $imageName; // Resim dosya yolu

        // Resmi yükle
        if (move_uploaded_file($imageTmpPath, '../pages/public/images/' . $imageName)) {
            // Resim başarıyla yüklendi
        } else {
            echo '<div class="alert alert-danger">Resim yüklenirken bir hata oluştu.</div>';
        }
    }

    // Gönderiyi güncelleme işlemi
    $update_stmt = $conn->prepare("UPDATE post SET baslik = ?, icerik = ?, resim = ? WHERE id = ?");
    $update_stmt->execute([$title, $content, $imagePath, $postId]);

    header("Location: post_management.php");
    exit();
}

// Gönderi ekleme işlemi
$message = ""; // Mesaj değişkeni
if (isset($_POST['add_post'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    // Resim yükleme işlemi
    $imagePath = ''; // Varsayılan olarak boş

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . '-' . basename($_FILES['image']['name']);
        $imagePath = $imageName; // Resim dosya yolu

        // Resmi yükle
        if (!move_uploaded_file($imageTmpPath, '../pages/public/images/' . $imageName)) {
            echo '<div class="alert alert-danger">Resim yüklenirken bir hata oluştu.</div>';
        }
    }

    // Gönderiyi ekleme işlemi
    $insert_stmt = $conn->prepare("INSERT INTO post (baslik, icerik, resim) VALUES (?, ?, ?)");
    if ($insert_stmt->execute([$title, $content, $imagePath])) {
        $message = "Gönderi başarıyla eklendi.";
    } else {
        $message = "Gönderi eklenirken bir hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gönderi Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="position-sticky">
                <h5 class="mt-3 text-white">Admin Paneli</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Gösterge Paneli</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_management.php">Kullanıcı Yönetimi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="post_management.php">Gönderi Yönetimi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_update.php">Admin Güncelle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
            <h2 class="mt-4">Gönderi Yönetimi</h2>

            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Gönderi Ekleme Formu -->
            <?php if (!$post): ?>
                <h3 class="mt-4">Gönderi Ekle</h3>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">İçerik</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Resim</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="add_post" class="btn btn-primary">Ekle</button>
                </form>
            <?php else: ?>
                <h4>Düzenle: <?php echo htmlspecialchars($post['baslik']); ?></h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                    <div class="mb-3">
                        <label for="title" class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['baslik']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">İçerik</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required><?php echo htmlspecialchars($post['icerik']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Resim</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <?php if (!empty($post['resim'])): ?>
                            <img src="../pages/public/images/<?php echo htmlspecialchars($post['resim']); ?>" alt="Mevcut Resim" class="img-thumbnail mt-2" style="max-width: 200px;">
                        <?php endif; ?>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                    <a href="post_management.php" class="btn btn-secondary">İptal</a>
                </form>
            <?php endif; ?>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>Resim</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td><?php echo htmlspecialchars($post['baslik']); ?></td>
                            <td><?php echo htmlspecialchars(substr($post['icerik'], 0, 50)) . '...'; ?></td>
                            <td>
                                <?php if (!empty($post['resim'])): ?>
                                    <img src="../pages/public/images/<?php echo htmlspecialchars($post['resim']); ?>" alt="Gönderi Resmi" class="img-thumbnail" style="max-width: 100px;">
                                <?php else: ?>
                                    <span>Resim yok</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo (new DateTime($post['tarih']))->format('Y-m-d'); ?></td>
                            <td>
                                <a href="?edit=<?php echo htmlspecialchars($post['id']); ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                <a href="?delete=<?php echo htmlspecialchars($post['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu gönderiyi silmek istediğinize emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
