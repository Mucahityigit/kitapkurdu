<?php 
    function oturumkontrol(){
        if(!isset($_SESSION['kul_mail']) OR !isset($_SESSION['kul_isim']) OR !isset($_SESSION['kul_id'])){
            session_destroy();
            header("Location:login.php");
            exit;
        }
    }






?>