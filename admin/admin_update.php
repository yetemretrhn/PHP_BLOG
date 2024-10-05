<?php
session_start();

// Eğer oturum açılmamışsa yönlendir
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("../conn/conn.php");

// Admin bilgilerini çek
$adminName = $_SESSION['admin']; // Oturumdan admin kullanıcı adını al
$admin_stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$admin_stmt->execute([$adminName]);
$admin = $admin_stmt->fetch(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC kullanarak diziyi al

$message = ""; // Mesaj değişkeni
// Bilgi güncelleme işlemi
if (isset($_POST['update'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']); // Şifreyi doğrudan al

    // Admin bilgisini güncelle
    $update_stmt = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
    $update_stmt->execute([$username, $password, $admin['id']]);

    // Oturumda güncellenmiş bilgileri güncelle
    $_SESSION['admin'] = $username; // Oturumda kullanıcı adını güncelle

    $message = "Bilgiler başarıyla güncellendi."; // Mesaj ayarla
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bilgi Güncelleme</title>
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
                        <a class="nav-link" href="post_management.php">Gönderi Yönetimi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_update.php">Admin Güncelle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
            <h2 class="mt-4">Admin Bilgi Güncelleme</h2>

            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($admin['password']); ?>" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Güncelle</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">İptal</a>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
