<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";   // Veritabanı sunucusu (genelde 'localhost')
$username = "root";          // Veritabanı kullanıcı adı
$password = "";        // Veritabanı şifresi
$dbname = "vfo_db";  // Bağlanılacak veritabanı adı

try {
    // PDO ile veritabanı bağlantısı oluştur
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // PDO'nun hata modunu Exception atacak şekilde ayarlıyoruz
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

} catch (PDOException $e) {
    // Bağlantı hatası durumunda hata mesajı göster
    echo "Bağlantı hatası: " . $e->getMessage();
}

// Veritabanı bağlantısını kapatmak için
// $conn = null;
?>
