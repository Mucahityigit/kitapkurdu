<?php include "header.php";
$gelenid = $_POST['kitap_id'];
$kitapsorgusu = $db->prepare("SELECT * FROM kitaplar WHERE kitap_id=$gelenid");
$kitapsorgusu->execute();
$kitaplar = $kitapsorgusu->fetch(PDO::FETCH_ASSOC);
echo $gelenid;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary">Kitap Güncelle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/islem.php" enctype="multipart/form-data" method="POST">
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Resmi</label>
                                <input type="file" class="form-control" name="kitap_img">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Adı</label>
                                <input type="text" name="kitap_ad" class="form-control" value="<?php echo $kitaplar['kitap_ad'] ?>">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Yazarı</label>
                                <input type="text" name="kitap_yazar" class="form-control" value="<?php echo $kitaplar['kitap_yazar'] ?>">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>İçerik</label>
                                <textarea name="kitap_icerik" class="form-control"><?php echo $kitaplar['kitap_icerik'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Sayfa Sayısı</label>
                                <input type="text" name="kitap_sayfa" class="form-control" value="<?php echo $kitaplar['kitap_sayfa'] ?>">
                            </div>
                        </div>
                        <input type="hidden" name="kitap_id" value="<?php echo $_POST['kitap_id'] ?>">
                        <button type="submit" class="btn btn-primary" name="kitapguncelle">Güncelle</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>