<?php include "nedmin/baglan.php"; ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/345bcb7635.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <title>Web Sitesi Uygulama</title>
</head>

<body>
    <!-- HEADER AREA -->

    <div id="header-container">
        <div id="header">
            <div id="logo-container">
                <a id="logo-text" href="index.php">KitapÖzet<span id="logo-span">.com</span></a>
            </div>
            <div id="search-container">
                <form action="index.php" method="GET">
                    <input id="search-input" name="aranan" type="text" placeholder="Kitap veya yazar adını giriniz">
                    <button id="search-btn" type="submit"><span id="search-icon"><i class="fas fa-search"></i></span></button>
                </form>
            </div>
            <div id="menu-container">
                <ul id="menu-list">
                    <li class="menu-item"><a class="menu-item-a" href="index.php">Ana Sayfa</a> </li>
                    <li class="menu-item"><a class="menu-item-a" href="#">Kategoriler</a> </li>
                    <li class="menu-item"><a class="menu-item-a" href="#">İletişim</a> </li>
                </ul>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['yorumekleme'])) {
        if ($_GET['yorumekleme'] == 'eksik') { ?>
            <div id="modal-back">
                <div id="modal-container">
                    <div class="modal-baslik">
                        <h4>Uyarı!</h4><span id="modal-kapat"><i class="fas fa-times"></i></span>
                    </div>
                    <div class="modal-icerik">Yorum içerik kısmı veya kullanıcı ismi boş bırakılamaz.</div>
                </div>
            </div>
    <?php }
    } ?>