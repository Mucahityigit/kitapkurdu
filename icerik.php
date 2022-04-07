<?php include 'header.php';

$gelenkitapid = $_GET['kitap_id'];
$kitapsor = $db->prepare('SELECT * FROM kitaplar WHERE kitap_id = ?');
$kitapsor->execute([$gelenkitapid]);
$kitapcek = $kitapsor->fetch(PDO::FETCH_ASSOC);
if (isset($_GET['kitap_id'])) {
    $sorgusor = $db->prepare("SELECT * FROM kitaplar WHERE kitap_id=$gelenkitapid");
    $sorgucek = $sorgusor->execute();
    $sorgucek = $sorgusor->fetch(PDO::FETCH_ASSOC);

    $okunmasayisi = $sorgucek['okunmasayisi'];
    $sorgu = $db->prepare("UPDATE kitaplar SET 
        okunmasayisi=:okunmasayisi
        WHERE kitap_id=:kitap_id
    ");
    $guncelle = $sorgu->execute(array(
        'okunmasayisi' => $okunmasayisi + 1,
        'kitap_id' => $gelenkitapid
    ));
}


?>

<!-- MAİN CONTAİNER  -->

<div id='main-container'>

    <!--  MAİN PAGE   -->
    <div id='main-page'>
        <div class='icerik-baslik'>
            <div id='tarih'>Eklenme tarihi <span id='tarihayar'><?php echo date("d-m-Y", strtotime($kitapcek['kitap_eklenme_tarih'])) ?></span></div>
            <div id='baslik'>
                <h1><?php echo $kitapcek['kitap_ad'] ?></h1>
            </div>
            <div class='card-content'>
                <div id='icerik'>
                    <div class='image-area'>
                        <img src='admin/dosyalar/<?php echo $kitapcek['kitap_img'] ?>' alt=''>
                    </div>
                    <p><?php echo $kitapcek['kitap_icerik'] ?></p>
                </div>
            </div>
        </div>
        <!-- YAZARIN DİĞER KİTAPLARI ALANI  -->
        <?php
        $kitapyazar = $kitapcek['kitap_yazar'];
        $kitapid = $kitapcek['kitap_id'];
        $yazarindigerkitaplari = $db->prepare("SELECT * FROM kitaplar WHERE kitap_yazar = ? LIMIT 5");
        $yazarindigerkitaplari->execute([$kitapyazar]);
        $kitapsay = $yazarindigerkitaplari->rowCount();
        $kitaplar = $yazarindigerkitaplari->fetchAll(PDO::FETCH_ASSOC);

        if ($kitapsay > 1) { ?>
            <div class="yazarin-diger-kitaplari-text">
                <div class="cizgi-ustu-text">Yazarın göz atmak isteyebileceğiniz bazı kitapları</div>
                <div class="cizgi-alani">
                    <span class="cizgi1"></span>
                    <span class="kutu"></span>
                    <span class="cizgi2"></span>
                </div>
            </div>
            <div class="yazarin-diger-kitaplari-container">
                <?php foreach ($kitaplar as $kitap) {
                    if ($kitapid != $kitap['kitap_id']) {
                ?>
                        <a class="yazarin-diger-kitaplari-btn" href="icerik.php?kitap_id=<?php echo $kitap['kitap_id'] ?>">
                            <div class="yazarin-diger-kitaplari">
                                <img src="admin/dosyalar/<?php echo $kitap['kitap_img'] ?>" alt="">
                            </div>
                        </a>
                <?php }
                } ?>
            </div>
        <?php } ?>


        <!-- YAZARIN DİĞER KİTAPLARI ALANI SON  -->

        <!-- AYNI KATEGORİYE SAHİP KİTAPLAR ALANI  -->
        <?php
        $kategori = $kitapcek['kategori_id'];
        $kitapid = $kitapcek['kitap_id'];
        $kategorikitaplari = $db->prepare("SELECT * FROM kitaplar WHERE kategori_id = ? LIMIT 5");
        $kategorikitaplari->execute([$kategori]);
        $kategorikitapsay = $kategorikitaplari->rowCount();
        $kategorikitaplar = $kategorikitaplari->fetchAll(PDO::FETCH_ASSOC);

        if ($kategorikitapsay > 1) { ?>
            <div class="yazarin-diger-kitaplari-text">
                <div class="cizgi-ustu-text">

                    <?php
                    $kategoriler = $db->prepare("SELECT * FROM kategori WHERE kategori_id = ?");
                    $kategoriler->execute([$kategori]);
                    $kategoriadi = $kategoriler->fetch(PDO::FETCH_ASSOC);

                    echo $kategoriadi['kategori_ad'];
                    ?>

                    kategorisine ait bazı kitaplar



                </div>
                <div class="cizgi-alani">
                    <span class="cizgi1"></span>
                    <span class="kutu"></span>
                    <span class="cizgi2"></span>
                </div>
            </div>
            <div class="yazarin-diger-kitaplari-container">
                <?php foreach ($kategorikitaplar as $kategorikitap) {
                    if ($kitapid != $kategorikitap['kitap_id']) {
                ?>
                        <a class="yazarin-diger-kitaplari-btn" href="icerik.php?kitap_id=<?php echo $kategorikitap['kitap_id'] ?>">
                            <div class="yazarin-diger-kitaplari">
                                <img src="admin/dosyalar/<?php echo $kategorikitap['kitap_img'] ?>" alt="">
                            </div>
                        </a>
                <?php }
                } ?>
            </div>
        <?php } ?>


        <!--  AYNI KATEGORİYE SAHİP KİTAPLAR ALANI SON  -->

        <!-- YORUM ALANI   -->
        <div class="YorumAlani">
            <div class="FormAlani">
                <form action="nedmin/islem.php" method="POST">
                    <div class="YorumBaslik">Bu kitap için yorumunuzu aşağıya yazabilirsiniz.</div>
                    <div class="cizgi-alani">
                        <span class="cizgi1"></span>
                        <span class="kutu"></span>
                        <span class="cizgi2"></span>
                    </div>
                    <div class="TextareaAlani">
                        <textarea name="yorum_icerik" placeholder="Yorumunuzu buraya yazabilirsiniz."></textarea>
                    </div>
                    <div class="InputAlani">
                        <input type="text" name="kullanici_isim" placeholder="Lütfen Adınızı Yazınız.">
                    </div>
                    <input type="hidden" name="kitap_id" value="<?php echo $gelenkitapid ?>">
                    <button class="YorumBtn" type="submit" name="yorumekle">Yorum Yap</button>
                </form>
            </div>
            <?php
            $yorumsorgusu = $db->prepare("SELECT * FROM yorumlar WHERE kitap_id=$gelenkitapid LIMIT 4");
            $yorumsorgusu->execute();
            $yorumlar = $yorumsorgusu->fetchAll(PDO::FETCH_ASSOC);
            foreach ($yorumlar as $yorum) {
            ?>
                <div class="YorumlarBolumu">
                    <span class="yorum-kullanici"><?php echo $yorum['kullanici_isim'] ?></span>
                    <span class="yorum-tarih"><?php echo date("d-m-Y", strtotime($yorum['yorum_tarih'])); ?></span>
                    <div class="yorum-icerik"><?php echo $yorum['yorum_icerik'] ?></div>
                    <div class="begenme-buton-alani">
                        <form action="nedmin/islem.php" method="POST">
                            <input type="hidden" name="yorum_id" value="<?php echo $yorum['yorum_id'] ?>">
                            <button type="submit" name="begenmebutonu" class="yorum-begenme-butonu"><i class="far fa-thumbs-up"></i> <span class="yorum-begenme-sayisi">(<?php echo $yorum['yorum_begenme_sayisi'] ?>)</span>
                            </button>
                        </form>
                    </div>
                    <div class="begenmeme-buton-alani">
                        <form action="nedmin/islem.php" method="POST">
                            <input type="hidden" name="yorum_id" value="<?php echo $yorum['yorum_id'] ?>">
                            <button type="submit" name="begenmemebutonu" class="yorum-begenmeme-butonu"><i class="far fa-thumbs-down"></i> <span class="yorum-begenmeme-sayisi">(<?php echo $yorum['yorum_begenmeme_sayisi'] ?>)</span></button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- YORUM ALANI  SON -->
    </div>
    <?php include 'sidebar.php'; ?>
    <?php include 'footer.php'; ?>


    <script src='script.js'></script>
    </body>

    </html>