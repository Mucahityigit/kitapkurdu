<?php include "header.php";

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary">Kategori Ekle</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/islem.php" enctype="multipart/form-data" method="POST">
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kategori Adı</label>
                                <input type="text" name="kategori_ad" class="form-control">
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-center">
                            <div class="col-md-6 form-group">
                                <label>Kategori Sıra</label>
                                <input type="text" name="kategori_sira" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="kategoriekle">Ekle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>