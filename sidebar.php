<!-- MAİN CATEGORY -->
<div id="main-category">
    <div id="search-area">
        <input id="search-area-input" type="text" placeholder="Neyi aramak istersiniz?">
        <span id="search-area-icon"><i class="fas fa-search"></i></span>
        <div id="links-container">
            <?php
            $KategoriSorgu = $db->prepare("SELECT * FROM kategori");
            $KategoriSorgu->execute();
            $KategoriCek = $KategoriSorgu->fetchAll(PDO::FETCH_ASSOC);
            foreach ($KategoriCek as $Kategori) { ?>
                <a class="links" href="kategori.php?kategori_id=<?php echo $Kategori['kategori_id'] ?>"><?php echo $Kategori['kategori_ad'] ?></a>
            <?php } ?>
        </div>
    </div>

    <!-- EN ÇOK OKUNANLAR BÖLÜMÜ  -->
    <div id="en-cok-okunan">
        <h3 class="title">En Çok Okunanlar</h3>
        <?php
        $EnCokOkunanSorgusu = $db->prepare("SELECT * FROM kitaplar ORDER BY okunmasayisi DESC LIMIT 4");
        $EnCokOkunanlariCek = $EnCokOkunanSorgusu->execute();
        $EnCokOkunanlariCek = $EnCokOkunanSorgusu->fetchAll(PDO::FETCH_ASSOC);
        $say = 0;
        foreach ($EnCokOkunanlariCek as $EnCokOkunan) {
            $say++;
        ?>
            <a class="en-cok-okunanlar-btn" href="icerik.php?kitap_id=<?php echo $EnCokOkunan['kitap_id'] ?>">
                <div class="okunanlar-sirasi">
                    <div class="image">
                        <img src="admin/dosyalar/<?php echo $EnCokOkunan['kitap_img'] ?>" alt="">
                    </div>
                    <div class="bilgi-bolumu">
                        <div class="kitap-adi"><?php echo $EnCokOkunan['kitap_ad'] ?></div>
                        <div class="yazar-adi"><?php echo $EnCokOkunan['kitap_yazar'] ?></div>
                        <div class="okunma-sayisi"><i class="fas fa-book-reader"></i><span class="okunma-sayi-degeri"><?php echo $EnCokOkunan['okunmasayisi'] ?></span></div>
                    </div>
                </div>
            </a>
        <?php    }  ?>
    </div>
    <!-- EN ÇOK OKUNANLAR BÖLÜMÜ SON -->

    <!-- EN SON EKLENENLER BÖLÜMÜ  -->
    <div id="en-son-eklenenler">
        <h3 class="title">En Son Eklenenler</h3>
        <?php
        $EnSonEklenenlerSorgusu = $db->prepare("SELECT * FROM kitaplar ORDER BY kitap_eklenme_tarih DESC LIMIT 4");
        $EnSonEklenenlerCek = $EnSonEklenenlerSorgusu->execute();
        $EnSonEklenenlerCek = $EnSonEklenenlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        $say = 0;
        foreach ($EnSonEklenenlerCek as $EnSonEklenenler) {
            $say++;
        ?>
            <a class="en-son-eklenenler-btn" href="icerik.php?kitap_id=<?php echo $EnSonEklenenler['kitap_id'] ?>">
                <div class="okunanlar-sirasi">
                    <div class="image">
                        <img src="admin/dosyalar/<?php echo $EnSonEklenenler['kitap_img'] ?>" alt="">
                    </div>
                    <div class="bilgi-bolumu">
                        <div class="kitap-adi"><?php echo $EnSonEklenenler['kitap_ad'] ?></div>
                        <div class="yazar-adi"><?php echo $EnSonEklenenler['kitap_yazar'] ?></div>
                        <div class="okunma-sayisi"><i class="far fa-calendar-alt"></i></i><span class="okunma-sayi-degeri"><?php echo date("d-m-Y", strtotime($EnSonEklenenler['kitap_eklenme_tarih'])) ?></span></div>
                    </div>
                </div>
            </a>
        <?php    }  ?>
    </div>
    <!-- EN SON EKLENENLER BÖLÜMÜ  SON -->

    <div id="share-area">
        <div id="facebook">Facebook <i class="fab fa-facebook-f"></i></div>
        <div id="twitter">Twitter <i class="fab fa-twitter"></i></div>
        <div id="instagram">İnstagram <i class="fab fa-instagram"></i></div>
        <div id="mail">Mail <i class="fas fa-envelope"></i></div>
    </div>
    <div id="reklamAlani">
        REKLAM ALANI
    </div>
</div>
</div>