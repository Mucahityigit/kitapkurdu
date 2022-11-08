<?php
include "header.php";
$GelenKategoriId = $_GET['kategori_id'];
if (isset($_REQUEST['Sayfalama'])) {
    $GelenSayfalama       = $_REQUEST['Sayfalama'];
} else {
    $GelenSayfalama       = 1;
}
$ToplamKitapSayisiSorgusu = $db->prepare("SELECT * FROM kitaplar WHERE kategori_id=$GelenKategoriId");
$ToplamKitapSayisiSorgusu->execute();
$SayfalamaIcinSolVeSagButonSayisi = 2;
$SayfaBasinaGosterilecekKayitSayisi = 6;
$ToplamKitapSayisi        = $ToplamKitapSayisiSorgusu->rowCount();
$SayfalamayaBaslanilacakKayitSayisi = ($GelenSayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
$BulunanSayfaSayisi = ceil($ToplamKitapSayisi / $SayfaBasinaGosterilecekKayitSayisi);
?>


<!-- MAİN CONTAİNER  -->

<div id="main-container">

    <!--  MAİN PAGE   -->
    <div id="main-page">
        <?php
        $kitapsor = $db->prepare("SELECT * FROM kitaplar WHERE kategori_id=$GelenKategoriId LIMIT $SayfalamayaBaslanilacakKayitSayisi , $SayfaBasinaGosterilecekKayitSayisi");
        $kitapsor->execute();
        while ($kitapcek = $kitapsor->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="card">
                <div class="card-content">
                    <div class="image-area">
                        <img src="admin/dosyalar/<?php echo $kitapcek['kitap_img'] ?>" alt="">
                    </div>
                    <div class="card-information">
                        <div class="information book-name">Kitap Adı : <span class="book-text"><?php echo $kitapcek['kitap_ad'] ?></span></div>
                        <div class="information author-name">Yazarın Adı : <span class="author-text"><?php echo $kitapcek['kitap_yazar'] ?></span></div>
                        <div class="information number-of-page">Sayfa Sayısı : <span class="page-text"><?php echo $kitapcek['kitap_sayfa'] ?></span></div>
                        <div class="information publication-year">Yayın Yılı : <span class="publication-text"></span></div>
                    </div>
                </div>
                <div class="card-text">
                    <div class="content-text">
                        <p> <?php
                            $yazi = $kitapcek['kitap_icerik'];
                            $kelime = strlen($yazi);
                            $sinir = 350;

                            if ($kelime > $sinir) {
                                $yazi = substr($yazi, 0, $sinir) . "...";
                            }
                            echo $yazi;
                            ?></p>
                    </div>
                    <form action="nedmin/islem.php" method="POST">
                        <input type="hidden" name="kitap_id" value="<?php echo $kitapcek['kitap_id'] ?>">
                        <button type="submit" name="devaminioku" class="btn">Devamını Oku</button>
                    </form>
                </div>
            </div>
        <?php } ?>
        <!-- PAGİNATİONS HEPSİ -->
        <div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
            Toplam <?php echo $BulunanSayfaSayisi ?> sayfada, <?php echo $ToplamKitapSayisi ?> adet kitap bulunmaktadır.
        </div>
        <div class="SayfalamaAlaniIciNumaralandirmaAlaniKapsayicisi">
            <?php
            if ($GelenSayfalama > 1) {
                echo "<a href='kategori.php?Sayfalama=1&kategori_id=$GelenKategoriId'><div class='Sayfalama'><<</div></a> ";
                $SayfalamaIcinSayfaDegeriniBirGeriAl = $GelenSayfalama - 1;
                echo "<a href='kategori.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "&kategori_id=$GelenKategoriId'><div class='Sayfalama'><</div></a>";
            }

            for ($SayfalamaIcinSayfaIndexDegeri = $GelenSayfalama - $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri <= $GelenSayfalama + $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++) {
                if (($SayfalamaIcinSayfaIndexDegeri > 0) and ($SayfalamaIcinSayfaIndexDegeri <= $BulunanSayfaSayisi)) {
                    if ($GelenSayfalama == $SayfalamaIcinSayfaIndexDegeri) {
                        echo "<div class='Sayfalama aktif'> " . $SayfalamaIcinSayfaIndexDegeri . "</div>";
                    } else {
                        echo " <a href='kategori.php?Sayfalama=" . $SayfalamaIcinSayfaIndexDegeri . "&kategori_id=$GelenKategoriId'>" . "<div class='Sayfalama'>" . $SayfalamaIcinSayfaIndexDegeri . "</div></a> ";
                    }
                }
            }
            if ($GelenSayfalama != $BulunanSayfaSayisi) {
                $SayfalamaIcinSayfaDegeriniBirIleriAl = $GelenSayfalama + 1;
                echo "<a href='kategori.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "&kategori_id=$GelenKategoriId'><div class='Sayfalama'>></div></a>";

                echo "<a href='kategori.php?Sayfalama=" . $BulunanSayfaSayisi . "&kategori_id=$GelenKategoriId'><div class='Sayfalama'>>></div></a>";
            }
            ?>
        </div>
        <!-- PAGİNATİONS HEPSİ-->



    </div>


    <?php include 'sidebar.php'; ?>
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    </body>

    </html>