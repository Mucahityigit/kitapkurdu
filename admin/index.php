<?php  include "header.php"; ?>




<?php include "footer.php"; ?>

<?php 
if(isset($_GET['durum'])){
    if($_GET['durum']=="ok"){ ?>
       <script>
            Swal.fire({
            icon: 'success',
            title: 'İşlem Başarılı',
            text: 'İşleminiz başarıyla gerçekleştirilmiştir.',
            confirmButtonText: "Tamam"
            })
       </script>

<?php }else{ ?>

        <script>
            Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'İşleminiz başarısız. Lütfen tekrar deneyin.',
            confirmButtonText: "Tamam"
            })
        </script>

<?php } } ?>