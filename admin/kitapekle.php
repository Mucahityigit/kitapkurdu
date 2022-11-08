<?php include "header.php";
$kategorisor = $db->prepare("SELECT * FROM kategori");
$kategorisor->execute();
$kategoricek = $kategorisor->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary">Kitap Ekle</h5>
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
                                <input type="text" name="kitap_ad" class="form-control">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Yazarı</label>
                                <input type="text" name="kitap_yazar" class="form-control">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>İçerik</label>
                                <textarea name="kitap_icerik" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Sayfa Sayısı</label>
                                <input type="text" name="kitap_sayfa" class="form-control">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kitap Kategori</label>
                                <select name="kategori_id" class="form-control">
                                    <?php foreach ($kategoricek as $kategori) { ?>
                                        <option value="<?php echo $kategori['kategori_id'] ?>"><?php echo $kategori['kategori_ad'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="kitapekle">Ekle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>