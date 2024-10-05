<?php
// Kullanıcı ID'sini oturumdan al
$kul_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$kullanici_adi = null;

// Kullanıcı adını veritabanından al
if ($kul_id) {
    $kullanici_sec = $conn->prepare("SELECT isim FROM kullanici WHERE id = ?");
    $kullanici_sec->execute([$kul_id]);

    if ($kullanici_sec->rowCount() > 0) {
        $kullanici = $kullanici_sec->fetch(PDO::FETCH_ASSOC);
        $kullanici_adi = $kullanici['isim'];
    }
}

// Çıkış işlemi için kontrol
if (isset($_GET['cikis'])) {
    session_destroy(); // Oturumu sonlandır
    header("Location: ./giris.php"); // Ana sayfaya yönlendir
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-black text-white">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#">VFÖ BLOG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark bg-black" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-white" id="offcanvasDarkNavbarLabel">VFÖ BLOG</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase text-white" aria-current="page" href="./index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase text-white" href="hakkimda.php">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase text-white" href="iletisim.php">İletişim</a>
                    </li>
                </ul>
                <!-- Kullanıcı adı burada gösteriliyor -->
                <?php if ($kullanici_adi): ?>
                    <a href="./profil.php"><button class="btn btn-primary text-uppercase m-3 mt-lg-0" type="button"><?=$kullanici_adi?></button></a>
                    <a href="?cikis=true"><button class="btn btn-danger text-uppercase m-3 mt-lg-0" type="button">Çıkış Yap</button></a>
                <?php else: ?>
                    <a href="./giris.php"><button class="btn btn-warning text-uppercase m-3 mt-lg-0" type="button">Giriş Yap</button></a>
                    <a href="./kayit.php"><button class="btn btn-danger text-uppercase m-3 mt-lg-0" type="button">Kayıt Ol</button></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
