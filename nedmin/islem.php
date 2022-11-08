<?php
include 'baglan.php';


if (isset($_POST['yorumekle'])) {
    $gelenkitapid = $_POST['kitap_id'];
    $yorum_tarih = date("Y-m-d");

    if (!empty($_POST['yorum_icerik']) and !empty($_POST['kullanici_isim'])) {
        $kitapsorgu = $db->prepare("INSERT INTO yorumlar SET
        kitap_id=:kitap_id,
        kullanici_isim=:kullanici_isim,
        yorum_icerik=:yorum_icerik,
        yorum_tarih=:yorum_tarih
    ");
        $kaydet = $kitapsorgu->execute(array(
            'kitap_id' => $gelenkitapid,
            'kullanici_isim' => $_POST['kullanici_isim'],
            'yorum_icerik' => $_POST['yorum_icerik'],
            'yorum_tarih' => $yorum_tarih
        ));
        if ($kaydet) {
            header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarili");
        } else {
            header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarisiz");
        }
    } else {
        header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=eksik");
    }
}


/*
$servername = "localhost";
$database = "xne33esa_kitapkurdu";
$username = "xne33esa_mucahit";
$password = "~6S)8xETMSt^";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['yorumekle'])) {
    $gelenkitapid = $_POST['kitap_id'];
    $kullanici_isim =  $_POST['kullanici_isim'];
    $yorum_icerik =  $_POST['yorum_icerik'];
    $yorum_tarih = date("Y-m-d");
}
$sql = "INSERT INTO yorumlar (kitap_id, kullanici_isim, yorum_icerik, yorum_tarih) VALUES ('" . "'$gelenkitapid'" . ",'$kullanici_isim'," . "'$yorum_icerik'," . "'$yorum_tarih')";
if (mysqli_query($conn, $sql)) {
    header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarili");
} else {
    header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarisiz");
}
mysqli_close($conn);*/



/*if (isset($_POST['yorumekle'])) {
    $gelenkitapid = $_POST['kitap_id'];
    $yorum_tarih = date("Y-m-d");
    $kullanici_isim = $_POST['kullanici_isim'];
    $yorum_icerik =  $_POST['yorum_icerik'];

    if (!empty($_POST['yorum_icerik']) and !empty($_POST['kullanici_isim'])) {
        $kitapsorgu = $db->prepare("INSERT INTO yorumlar (kitap_id,kullanici_isim,yorum_icerik,yorum_tarih) values (?, ?, ?, ?)");
        $kaydet = $kitapsorgu->execute([$gelenkitapid, $kullanici_isim, $yorum_icerik, $yorum_tarih]);
        if ($kaydet) {
            header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarili");
        } else {
            header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=basarisiz");
        }
    } else {
        header("Location:../icerik.php?kitap_id=$gelenkitapid&yorumekleme=eksik");
    }
}*/




if (isset($_POST['begenmebutonu'])) {
    $gelenyorumid = $_POST['yorum_id'];
    $sorgusor = $db->prepare("SELECT * FROM yorumlar WHERE yorum_id=$gelenyorumid");
    $sorgucek = $sorgusor->execute();
    $sorgucek = $sorgusor->fetch(PDO::FETCH_ASSOC);
    $begenmesayisi = $sorgucek['yorum_begenme_sayisi'];
    $gidilecekkitapid = $sorgucek['kitap_id'];
    $sorgu = $db->prepare("UPDATE yorumlar SET 
        yorum_begenme_sayisi=:yorum_begenme_sayisi
        WHERE yorum_id=:yorum_id
    ");

    $guncelle = $sorgu->execute(array(
        'yorum_begenme_sayisi' => $begenmesayisi + 1,
        'yorum_id' => $gelenyorumid
    ));

    if ($guncelle) {
        header("Location:../icerik.php?kitap_id=$gidilecekkitapid");
    } else {
        header("Location:../icerik.php?kitap_id=$gidilecekkitapid");
    }
}
if (isset($_POST['begenmemebutonu'])) {
    $gelenyorumid = $_POST['yorum_id'];
    $sorgusor = $db->prepare("SELECT * FROM yorumlar WHERE yorum_id=$gelenyorumid");
    $sorgucek = $sorgusor->execute();
    $sorgucek = $sorgusor->fetch(PDO::FETCH_ASSOC);
    $begenmemesayisi = $sorgucek['yorum_begenmeme_sayisi'];
    $gidilecekkitapid = $sorgucek['kitap_id'];
    $sorgu = $db->prepare("UPDATE yorumlar SET 
        yorum_begenmeme_sayisi=:yorum_begenmeme_sayisi
        WHERE yorum_id=:yorum_id
    ");

    $guncelle = $sorgu->execute(array(
        'yorum_begenmeme_sayisi' => $begenmemesayisi + 1,
        'yorum_id' => $gelenyorumid
    ));

    if ($guncelle) {
        header("Location:../icerik.php?kitap_id=$gidilecekkitapid");
    } else {
        header("Location:../icerik.php?kitap_id=$gidilecekkitapid");
    }
}
