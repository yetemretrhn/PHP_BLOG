<?php
session_start();

// Eğer oturum açılmamışsa yönlendir
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("../conn/conn.php");

// Kullanıcıları ve gönderileri veritabanından çek
$users_stmt = $conn->prepare("SELECT * FROM kullanici");
$users_stmt->execute();
$users = $users_stmt->fetchAll();

$posts_stmt = $conn->prepare("SELECT * FROM post");
$posts_stmt->execute();
$posts = $posts_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
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
                        <a class="nav-link active" href="admin_dashboard.php">Gösterge Paneli</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_management.php">Kullanıcı Yönetimi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post_management.php">Gönderi Yönetimi</a>
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
            <header class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Paneli</h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </header>

            <h4>Hoşgeldin, <?php echo $_SESSION['admin']; ?>!</h4>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Toplam Kullanıcı</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo count($users); ?></h5>
                            <p class="card-text">Veritabanında kayıtlı kullanıcı sayısı.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Toplam Gönderi</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo count($posts); ?></h5>
                            <p class="card-text">Veritabanında kayıtlı gönderi sayısı.</p>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mt-4">Kullanıcılar</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>E-posta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['isim']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5 class="mt-4">Gönderiler</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td><?php echo htmlspecialchars($post['baslik']); ?></td>
                            <td><?php echo htmlspecialchars(substr($post['icerik'], 0, 50)) . '...'; ?></td>
                            <td><?php echo (new DateTime($post['tarih']))->format('Y-m-d'); ?></td>
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
