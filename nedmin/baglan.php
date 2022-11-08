<?php
    try {
        //$db = new PDO("mysql:host=localhost;dbname=xne33esa_kitapkurdu;charset=utf8","xne33esa_mucahit","~6S)8xETMSt^");
        $db=new PDO("mysql:host=localhost;dbname=kitapkurdu;charset=utf8","root","");
       // echo "veri tabanı bağlantısı başarılı";
    } catch(PDOException $e){
        echo $e->getMessage();
    }
?>