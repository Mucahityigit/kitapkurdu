<?php
require "baglan.php";

if (isset($_POST['ayarkaydet'])) {



    $ayarguncelle = $db->prepare("UPDATE ayarlar SET 
            site_baslik=:site_baslik,
            site_aciklama=:site_aciklama,
            site_link=:site_link,
            site_sahip_mail=:site_sahip_mail,
            site_mail_host=:site_mail_host,
            site_mail_mail=:site_mail_mail,
            site_mail_port=:site_mail_port,
            site_mail_sifre=:site_mail_sifre WHERE id=1
        ");

    $guncelle = $ayarguncelle->execute(array(
        'site_baslik' => $_POST['site_baslik'],
        'site_aciklama' => $_POST['site_aciklama'],
        'site_link' => $_POST['site_link'],
        'site_sahip_mail' => $_POST['site_sahip_mail'],
        'site_mail_host' => $_POST['site_mail_host'],
        'site_mail_mail' => $_POST['site_mail_mail'],
        'site_mail_port' => $_POST['site_mail_port'],
        'site_mail_sifre' => $_POST['site_mail_sifre']
    ));

    if ($_FILES['site_logo']['error'] == "0") {
        $gecici_ismi = $_FILES['site_logo']['tmp_name'];
        $dosya_ismi = rand(100000, 999999) . $_FILES['site_logo']['name'];
        move_uploaded_file($gecici_ismi, "../dosyalar/$dosya_ismi");

        $ayarguncelle = $db->prepare("UPDATE ayarlar SET 
                site_logo=:site_logo 
        ");

        $guncelle = $ayarguncelle->execute(array(
            'site_logo' => $dosya_ismi
        ));
    }

    if ($guncelle) {
        header("Location:../ayarlar.php?durum=ok");
    } else {
        header("Location:../ayarlar.php?durum=no");
    }
    exit;
}

if (isset($_POST['oturumacma'])) {
    $gelen_mail = $_POST['kul_mail'];
    $gelen_sifre = md5($_POST['kul_sifre']);
    $kullanicisor = $db->prepare("SELECT * FROM kullanicilar WHERE kul_mail = ?  AND kul_sifre = ?");
    $kullanicisor->execute([$gelen_mail, $gelen_sifre]);
    $say = $kullanicisor->rowCount();
    $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

    if ($say == 0) {
        header("Location:../login.php?durum=no");
    } else {
        $_SESSION['kul_isim'] = $kullanicicek['kul_isim'];
        $_SESSION['kul_mail'] = $kullanicicek['kul_mail'];
        $_SESSION['kul_id'] = $kullanicicek['kul_id'];
        header("Location:../index.php?durum=ok");
    }
}


if (isset($_POST['profilkaydet'])) {

    $profilguncelle = $db->prepare("UPDATE kullanicilar SET 
            kul_isim=:kul_isim,
            kul_mail=:kul_mail,
            kul_tel=:kul_tel WHERE kul_id=:kul_id       
        ");

    $guncelle = $profilguncelle->execute(array(
        'kul_isim' => $_POST['kul_isim'],
        'kul_mail' => $_POST['kul_mail'],
        'kul_tel' => $_POST['kul_tel'],
        'kul_id' => $_SESSION['kul_id']
    ));

    if (strlen($_POST['kul_sifre']) > 0) {
        $profilguncelle = $db->prepare("UPDATE kullanicilar SET 
            kul_sifre=:kul_sifre
             WHERE kul_id=:kul_id       
        ");

        $guncelle = $profilguncelle->execute(array(
            'kul_sifre' => md5($_POST['kul_sifre']),
            'kul_id' => $_SESSION['kul_id']
        ));
    }

    if ($guncelle) {
        header("Location:../profil.php?durum=ok");
    } else {
        header("Location:../profil.php?durum=no");
    }
}

// KİTAP EKLEME ALANI

if (isset($_POST['kitapekle'])) {
    /* KİTAP LİNK ÜRETME
    $kitapaditurkce = $_POST['kitap_ad'];
    $bulunacak = array('ç', 'Ç', 'ı', 'İ', 'ğ', 'Ğ', 'ü', 'ö', 'Ş', 'ş', 'Ö', 'Ü', ' ');
    $degistir  = array('c', 'C', 'i', 'I', 'g', 'G', 'u', 'o', 'S', 's', 'O', 'U', '-');
    $kitapadiorginal = str_replace($bulunacak, $degistir, $kitapaditurkce);*/

    $kita_eklenme_tarih = date("Y-m-d");
    $gecici_ismi = $_FILES['kitap_img']['tmp_name'];
    $dosya_ismi = rand(100000, 999999) . $_FILES['kitap_img']['name'];
    move_uploaded_file($gecici_ismi, "../dosyalar/$dosya_ismi");
    $kitapekle = $db->prepare("INSERT INTO kitaplar SET
        kategori_id=:kategori_id,
        kitap_ad=:kitap_ad,
        kitap_yazar=:kitap_yazar,
        kitap_sayfa=:kitap_sayfa,
        kitap_icerik=:kitap_icerik,
        kitap_img=:kitap_img,
        kitap_link=:kitap_link,
        kitap_eklenme_tarih=:kitap_eklenme_tarih
    ");
    $ekle = $kitapekle->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'kitap_ad' => $_POST['kitap_ad'],
        'kitap_yazar' => $_POST['kitap_yazar'],
        'kitap_sayfa' => $_POST['kitap_sayfa'],
        'kitap_icerik' => $_POST['kitap_icerik'],
        'kitap_img' => $dosya_ismi,
        'kitap_link' => " ",
        'kitap_eklenme_tarih' => $kita_eklenme_tarih

    ));

    /* KİTAP İCERİK DOSYASI ÜRETİP KLASÖRE KAYDETME
    $Dosya = "../../$kitapadiorginal.php";
    chmod($Dosya, 0777);
    $DosyaAc = fopen($Dosya, "w");
    $Icerik = "
    <?php include 'icerik.php' ?>
";
    fwrite($DosyaAc, $Icerik);
    fclose($DosyaAc);*/


    if ($ekle) {
        header("Location:../kitaplar.php?durum=ok");
        exit;
    } else {
        header("Location:../kitaplar.php?durum=no");
        exit;
    }
}

// KİTAP GÜNCELLEME ALANI

if (isset($_POST['kitapguncelle'])) {
    $gelenid = $_POST['kitap_id'];
    $kitapsor = $db->prepare("UPDATE kitaplar SET 
            kitap_ad=:kitap_ad,
            kitap_yazar=:kitap_yazar,
            kitap_sayfa=:kitap_sayfa,
            kitap_icerik=:kitap_icerik
            WHERE kitap_id=:kitap_id
        ");
    $guncelle = $kitapsor->execute(array(
        'kitap_ad' => $_POST['kitap_ad'],
        'kitap_yazar' => $_POST['kitap_yazar'],
        'kitap_sayfa' => $_POST['kitap_sayfa'],
        'kitap_icerik' => $_POST['kitap_icerik'],
        'kitap_id' => $gelenid
    ));

    if ($_FILES['kitap_img']['error'] == "0") {
        $gecici_ismi = $_FILES['kitap_img']['tmp_name'];
        $dosya_ismi = rand(100000, 999999) . $_FILES['kitap_img']['name'];
        move_uploaded_file($gecici_ismi, "../dosyalar/$dosya_ismi");

        $kitapsor = $db->prepare("UPDATE kitaplar SET 
            kitap_img=:kitap_img WHERE kitap_id=:kitap_id
    ");

        $guncelle = $kitapsor->execute(array(
            'kitap_img' => $dosya_ismi,
            'kitap_id' => $gelenid
        ));
    }


    if ($guncelle) {
        header("Location:../kitaplar.php?durum=ok");
        exit;
    } else {
        header("Location:../kitaplar.php?durum=no");
        exit;
    }
}

/* KATEGORİ EKLEME ALANI */

if (isset($_POST['kategoriekle'])) {
    $kategoriekle = $db->prepare("INSERT INTO kategori SET 
        kategori_ad=:kategori_ad,
        kategori_sira=:kategori_sira
    ");
    $ekle = $kategoriekle->execute(array(
        'kategori_ad' => $_POST['kategori_ad'],
        'kategori_sira' => $_POST['kategori_sira']
    ));

    if ($ekle) {
        header("Location:../kategoriler.php?durum=ok");
    } else {
        header("Location:../kategoriler.php?durum=no");
    }
}
