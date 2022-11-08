<?php 
    try{
        //$db = new PDO("mysql:host=localhost;dbname=xne33esa_kitapkurdu;charset=utf8","xne33esa_mucahit","~6S)8xETMSt^");
        $db = new PDO("mysql:host=localhost;dbname=kitapkurdu;charset=utf8","root","");
    }catch(PDOException $hata){
        echo $hata->getMessage();
    }


    $ayarsor = $db->prepare("SELECT * FROM ayarlar");
    $ayarsor->execute();
    $ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);
