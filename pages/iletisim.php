<?php
// Veritabanı bağlantısını dahil et
include('../conn/conn.php');
session_start();

// Form gönderildiğinde
if (isset($_POST['gonder'])) {
    // Formdan gelen verileri al
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Veriyi iletim tablosuna ekle
    try {
        $stmt = $conn->prepare("INSERT INTO iletisim (ad, email, mesaj) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);

        echo "<div class='alert alert-success mt-5'>Mesajınız başarıyla gönderildi!</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger mt-3'>Veritabanı hatası: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include("./components/header.php");
    ?>

    <br>
    <br>
    <div class="container mb-5">
        <h1 class="mb-4 mt-5">İletişim Formu</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Adınız</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Mesajınız</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" name="gonder" class="btn btn-primary">Gönder</button>
        </form>
    </div>
    <?php include("./components/footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
