<?php
include("../conn/conn.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 5 Navbar</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
<body>
    <?php include("./components/header.php");?>

<br>
<section class="about py-5 mb-0">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="public/images/emre.jpg" alt="" class="img-fluid rounded">
      </div>
      <div class="col-lg-6">
        <div class="about-text text-light">
          <h1 class="mt-5">Hakkımızda</h1>
          <h5>Web Developer <span>& Designer</span></h5>
          <p>
            VFÖ Blog, her türlü konuyu özgürce paylaşabileceğiniz, geniş bir yelpazede bilgi ve deneyimlerin buluştuğu bir platformdur. Teknoloji, sanat, bilim, kişisel gelişim, seyahat ve daha birçok konuda özgün yazılar yazarak, farklı görüşleri bir araya getiriyoruz.
            <br><br>
            Bu site, HTML, CSS, Bootstrap, JavaScript ve PHP gibi modern web teknolojileri kullanılarak, kullanıcı dostu ve esnek bir yapı üzerine inşa edilmiştir. Amacımız, yazarlara ve okurlara rahat bir deneyim sunarak, fikirlerin kolayca paylaşılabileceği bir ortam sağlamaktır.
            <br><br>
            VFÖ Blog’da siz de dilediğiniz konuda yazılar yazabilir, diğer kullanıcılarla bilgi alışverişinde bulunabilirsiniz. İster bir konuda uzman olun, ister sadece fikirlerinizi paylaşmak isteyin, bu platform tam size göre!
          </p>
          <a href="./index.php" class="btn btn-primary">Ana Sayfa</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("./components/footer.php");?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>