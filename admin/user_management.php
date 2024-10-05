<?php
session_start();

// Eğer oturum açılmamışsa yönlendir
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include("../conn/conn.php");

// Kullanıcıları veritabanından çek
$users_stmt = $conn->prepare("SELECT * FROM kullanici");
$users_stmt->execute();
$users = $users_stmt->fetchAll();

// Kullanıcı silme işlemi
if (isset($_GET['delete'])) {
    $userId = (int)$_GET['delete'];

    // Kullanıcıyı silme işlemi
    $delete_stmt = $conn->prepare("DELETE FROM kullanici WHERE id = ?");
    $delete_stmt->execute([$userId]);

    header("Location: user_management.php");
    exit();
}

// Kullanıcı ekleme işlemi
$message = ""; // Mesaj değişkeni
if (isset($_POST['add_user'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); // Şifreyi al

    // Kullanıcıyı ekleme işlemi
    $insert_stmt = $conn->prepare("INSERT INTO kullanici (isim, email, sifre) VALUES (?, ?, ?)");
    if ($insert_stmt->execute([$username, $email, $password])) {
        $message = "Kullanıcı başarıyla eklendi.";
    } else {
        $message = "Kullanıcı eklenirken bir hata oluştu.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Yönetimi</title>
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
                        <a class="nav-link active" href="user_management.php">Kullanıcı Yönetimi</a>
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
            <h2 class="mt-4">Kullanıcı Yönetimi</h2>

            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Kullanıcı Ekleme Formu -->
            <h3 class="mt-4">Kullanıcı Ekle</h3>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="add_user" class="btn btn-primary">Ekle</button>
            </form>

            <!-- Kullanıcı Listesi -->
            <h3 class="mt-4">Mevcut Kullanıcılar</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kullanıcı Adı</th>
                        <th>E-posta</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['isim']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="?delete=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">Sil</a>
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
