<?php
include("../conn/conn.php");

if (isset($_POST["giris"])) {
    // Kullanıcıdan gelen form verileri
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    
    try {
        // E-posta ile kullanıcıyı bul
        $sql = "SELECT * FROM kullanici WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Kullanıcı bulundu mu kontrol et
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Şifreyi kontrol et (hash kullanmadığın için doğrudan karşılaştır)
            if ($user['sifre'] === $sifre) {
                // Giriş başarılı, oturumu başlat
                session_start();
                $_SESSION['user_id'] = $user['id']; // Kullanıcı ID'sini oturuma kaydet
                
                // Ana sayfaya yönlendir
                header("Location: index.php");
                exit();
            } else {
                echo "E-posta veya şifre yanlış!";
            }
        } else {
            echo "E-posta veya şifre yanlış!";
        }
    } catch (PDOException $e) {
        echo "Bir hata oluştu: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giriş Yap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include("./components/header.php")
?>
  <section class="login-section py-5 mt-5 mb-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7 col-sm-9">
          <div class="card shadow-lg">
            <div class="card-body">
              <h2 class="card-title text-center mb-4">Giriş Yap</h2>

              <form method="POST">
                <!-- E-Posta -->
                <div class="mb-3">
                  <label for="email" class="form-label">E-Posta Adresi</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="E-posta adresinizi girin" required>
                </div>

                <!-- Şifre -->
                <div class="mb-3">
                  <label for="password" class="form-label">Şifre</label>
                  <input type="password" class="form-control" id="password" name="sifre" placeholder="Şifrenizi girin" required>
                </div>

                <!-- Giriş Butonu -->
                <div class="d-grid">
                  <button type="submit" name="giris" class="btn btn-primary">Giriş Yap</button>
                </div>
              </form>


             
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include("./components/footer.php");?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
