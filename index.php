<?php
include "header.php";

if (isset($_REQUEST['Sayfalama'])) {
    $GelenSayfalama       = $_REQUEST['Sayfalama'];
} else {
    $GelenSayfalama       = 1;
    echo "yok";
}
$SayfalamaIcinSolVeSagButonSayisi = 2;
$SayfaBasinaGosterilecekKayitSayisi = 6;
$ToplamKitapSayisiSorgusu = $db->prepare("SELECT * FROM kitaplar");
$ToplamKitapSayisiSorgusu->execute();
$ToplamKitapSayisi        = $ToplamKitapSayisiSorgusu->rowCount();
$SayfalamayaBaslanilacakKayitSayisi = ($GelenSayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
$BulunanSayfaSayisi = ceil($ToplamKitapSayisi / $SayfaBasinaGosterilecekKayitSayisi);
?>


<!-- MAİN CONTAİNER  -->

<div id="main-container">

    <!--  MAİN PAGE   -->
    <div id="main-page">
        <?php
        if (isset($_GET['aranan'])) {
            $aranan = $_GET['aranan'];
            $ToplamSayiSorgusu = $db->prepare("SELECT * FROM kitaplar WHERE kitap_ad LIKE '%$aranan%' OR kitap_yazar LIKE '%$aranan%'");
            $ToplamSayiSorgusu->execute();
            $AramaSonucuToplamKitapSayisi = $ToplamSayiSorgusu->rowCount();
            $AramaSonucuBulunanSayfaSayisi = ceil($AramaSonucuToplamKitapSayisi / $SayfaBasinaGosterilecekKayitSayisi);
            $sorgu = $db->prepare("SELECT * FROM kitaplar WHERE kitap_ad LIKE '%$aranan%' OR kitap_yazar LIKE '%$aranan%' LIMIT $SayfalamayaBaslanilacakKayitSayisi , $SayfaBasinaGosterilecekKayitSayisi");
            $sorgu->execute();
            $sonuclar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
            foreach ($sonuclar as $sonuc) { ?>
                <div class="card">
                    <div class="card-content">
                        <div class="image-area">
                            <img src="admin/dosyalar/<?php echo $sonuc['kitap_img'] ?>" alt="">
                        </div>
                        <div class="card-information">
                            <div class="information book-name">Kitap Adı : <span class="book-text"><?php echo $sonuc['kitap_ad'] ?></span></div>
                            <div class="information author-name">Yazarın Adı : <span class="author-text"><?php echo $sonuc['kitap_yazar'] ?></span></div>
                            <div class="information number-of-page">Sayfa Sayısı : <span class="page-text"><?php echo $sonuc['kitap_sayfa'] ?></span></div>
                            <div class="information publication-year">Yayın Yılı : <span class="publication-text"></span></div>
                        </div>
                    </div>
                    <div class="card-text">
                        <div class="content-text">
                            <p> <?php
                                $yazi = $sonuc['kitap_icerik'];
                                $kelime = strlen($yazi);
                                $sinir = 350;

                                if ($kelime > $sinir) {
                                    $yazi = substr($yazi, 0, $sinir) . "...";
                                }
                                echo $yazi;
                                ?></p>
                        </div>
                        <a class="btn" href="icerik.php?kitap_id=<?php echo $sonuc['kitap_id'] ?>">Devamını Oku</a>
                    </div>
                </div>
            <?php } ?>
            <!-- PAGİNATİONS ARAMA SONRASI -->
            <div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
                Toplam <?php echo $AramaSonucuBulunanSayfaSayisi ?> sayfada, <?php echo $AramaSonucuToplamKitapSayisi ?> adet kitap bulunmaktadır.
            </div>
            <div class="SayfalamaAlaniIciNumaralandirmaAlaniKapsayicisi">
                <?php
                if ($GelenSayfalama > 1) {
                    echo "<a href='index.php?Sayfalama=1&aranan=$aranan'><div class='Sayfalama'><<</div></a> ";
                    $SayfalamaIcinSayfaDegeriniBirGeriAl = $GelenSayfalama - 1;
                    echo "<a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "&aranan=$aranan'><div class='Sayfalama'><</div></a>";
                }

                for ($SayfalamaIcinSayfaIndexDegeri = $GelenSayfalama - $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri <= $GelenSayfalama + $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++) {
                    if (($SayfalamaIcinSayfaIndexDegeri > 0) and ($SayfalamaIcinSayfaIndexDegeri <= $AramaSonucuBulunanSayfaSayisi)) {
                        if ($GelenSayfalama == $SayfalamaIcinSayfaIndexDegeri) {
                            echo "<div class='Sayfalama aktif'> " . $SayfalamaIcinSayfaIndexDegeri . "</div>";
                        } else {
                            echo " <a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaIndexDegeri . "&aranan=$aranan'>" . "<div class='Sayfalama'>" . $SayfalamaIcinSayfaIndexDegeri . "</div></a> ";
                        }
                    }
                }
                if ($GelenSayfalama != $AramaSonucuBulunanSayfaSayisi) {
                    $SayfalamaIcinSayfaDegeriniBirIleriAl = $GelenSayfalama + 1;
                    echo "<a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "&aranan=$aranan'><div class='Sayfalama'>></div></a>";

                    echo "<a href='index.php?Sayfalama=" . $AramaSonucuBulunanSayfaSayisi . "&aranan=$aranan'><div class='Sayfalama'>>></div></a>";
                }
                ?>
            </div>
            <!-- PAGİNATİONS ARAMA SONRASI-->
            <?php } else {
            $kitapsor = $db->prepare("SELECT * FROM kitaplar LIMIT $SayfalamayaBaslanilacakKayitSayisi , $SayfaBasinaGosterilecekKayitSayisi");
            $kitapsor->execute();
            while ($kitapcek = $kitapsor->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="card">
                    <div class="card-content">
                        <div class="image-area">
                            <img src="admin/dosyalar/<?php echo $kitapcek['kitap_img'] ?>" alt="">
                        </div>
                        <div class="card-information">
                            <div class="information book-name">Kitap Adı : <span class="book-text"><?php
                                                                                                    $yazi = $kitapcek['kitap_ad'];
                                                                                                    $kelime = strlen($yazi);
                                                                                                    $sinir = 23;

                                                                                                    if ($kelime < $sinir) {
                                                                                                        echo $yazi;
                                                                                                    } else {
                                                                                                        $yazi = substr($yazi, 0, $sinir) . ".";
                                                                                                        echo $yazi;
                                                                                                    }

                                                                                                    ?></span></div>
                            <div class="information author-name">Yazarın Adı : <span class="author-text"><?php
                                                                                                            $yazi = $kitapcek['kitap_yazar'];
                                                                                                            $kelime = strlen($yazi);
                                                                                                            $sinir = 20;

                                                                                                            if ($kelime < $sinir) {
                                                                                                                echo $yazi;
                                                                                                            } else {
                                                                                                                $yazi = substr($yazi, 0, $sinir) . ".";
                                                                                                                echo $yazi;
                                                                                                            }
                                                                                                            ?></span></div>
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

                                if ($kelime < $sinir) {
                                    echo $yazi;
                                } else {
                                    $yazi = substr($yazi, 0, $sinir) . "...";
                                    echo $yazi;
                                }

                                ?></p>
                        </div>

                        <a class="btn" href="icerik.php?kitap_id=<?php echo $kitapcek['kitap_id'] ?>">Devamını Oku</a>
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
                    echo "<a href='index.php?Sayfalama=1'><div class='Sayfalama'><<</div></a> ";
                    $SayfalamaIcinSayfaDegeriniBirGeriAl = $GelenSayfalama - 1;
                    echo "<a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><div class='Sayfalama'><</div></a>";
                }

                for ($SayfalamaIcinSayfaIndexDegeri = $GelenSayfalama - $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri <= $GelenSayfalama + $SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++) {
                    if (($SayfalamaIcinSayfaIndexDegeri > 0) and ($SayfalamaIcinSayfaIndexDegeri <= $BulunanSayfaSayisi)) {
                        if ($GelenSayfalama == $SayfalamaIcinSayfaIndexDegeri) {
                            echo "<div class='Sayfalama aktif'> " . $SayfalamaIcinSayfaIndexDegeri . "</div>";
                        } else {
                            echo " <a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaIndexDegeri . "'>" . "<div class='Sayfalama'>" . $SayfalamaIcinSayfaIndexDegeri . "</div></a> ";
                        }
                    }
                }
                if ($GelenSayfalama != $BulunanSayfaSayisi) {
                    $SayfalamaIcinSayfaDegeriniBirIleriAl = $GelenSayfalama + 1;
                    echo "<a href='index.php?Sayfalama=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'><div class='Sayfalama'>></div></a>";

                    echo "<a href='index.php?Sayfalama=" . $BulunanSayfaSayisi . "'><div class='Sayfalama'>>></div></a>";
                }
                ?>
            </div>
            <!-- PAGİNATİONS HEPSİ-->

        <?php  } ?>

        <div id="mainReklamAlani">
            REKLAM ALANI
        </div>

    </div>


    <?php include 'sidebar.php'; ?>
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    </body>

    </html>