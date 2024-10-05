<?php
// Veritabanı bağlantısı dahil ediliyor
include("../conn/conn.php");

if (isset($_POST["gonder"])) {
    // Kullanıcıdan gelen form verileri
    $isim = $_POST["isim"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    
    try {
        // Aynı e-posta adresine sahip bir kayıt olup olmadığını kontrol et
        $sql = "SELECT * FROM kullanici WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // E-posta zaten mevcutsa hata mesajı göster
        if ($stmt->rowCount() > 0) {
            echo "Bu e-posta adresiyle zaten kayıt olunmuş!";
        } else {
            // Aynı e-posta yoksa yeni kullanıcıyı veritabanına ekle
            $sql = "INSERT INTO kullanici (isim, email, sifre) VALUES (:isim, :email, :sifre)";
            $stmt = $conn->prepare($sql);
            
            // Değerleri bağla (hash kullanmadan)
            $stmt->bindParam(':isim', $isim);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':sifre', $sifre); // Şifreyi hash'lemeden kaydet

            // Sorguyu çalıştır
            $stmt->execute();
            
            // Kayıt başarılı, yönlendirme yap
            header("Location: giris.php"); // index.php sayfasına yönlendir
            exit(); // Çıkış yaparak diğer kodların çalışmasını durdur
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
  <title>Kayıt Ol</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include("./components/header.php");
?>
  <section class="register-section py-5 mt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
          <div class="card shadow-lg">
            <div class="card-body">
              <h2 class="card-title text-center mb-4">Kayıt Ol</h2>
              
              <form action="" method="post"> <!-- Formun action'ı ayarlandı -->
                <!-- Kullanıcı Adı -->
                <div class="mb-3">
                  <label for="username" class="form-label">Kullanıcı Adı</label>
                  <input type="text" class="form-control" id="username" name="isim" placeholder="Kullanıcı adınızı girin" required>
                </div>
                
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

                <!-- Kayıt Butonu -->
                <div class="d-grid">
                  <button type="submit" name="gonder" class="btn btn-primary">Kayıt Ol</button>
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
