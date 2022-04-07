<?php include "header.php";
$kategorisorgusu = $db->prepare("SELECT * FROM kategori");
$kategorisorgusu->execute();
$kategoriler = $kategorisorgusu->fetchAll(PDO::FETCH_ASSOC);
$say = 1;
?>
<link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="card">
        <div class="card-header">
            <h6 class="font-weight-bold text-primary">Kategoriler</h6>
            <a href="kategoriekle.php" style="text-decoration: none; color:white"><button class="btn btn-primary">Ekle</button></a>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="musteritablosu" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori ID</th>
                                <th>Kategori Üst ID</th>
                                <th>Kategori Adı</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategoriler as $kategori) { ?>
                                <tr>
                                    <td><?php echo $say ?></td>
                                    <td><?php echo $kategori['kategori_id'] ?></td>
                                    <td><?php echo $kategori['kategori_ust'] ?></td>
                                    <td><?php echo $kategori['kategori_ad'] ?></td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <form action="kategoriguncelle.php" method="POST">
                                                <input type="hidden" name="kategori_id" value="<?php echo $kategori['kategori_id'] ?>">
                                                <button type="submit" name="guncelle" class="btn btn-success btn-sm btn-icon-split">
                                                    <span class="icon text-white-60">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                </button>
                                            </form>
                                            <form class="mx-1" action="islemler/islem.php" method="POST">
                                                <input type="hidden" name="kategori_id" value="<?php echo $kategori['kategori_id'] ?>">
                                                <button type="submit" name="kategorisil" class="btn btn-danger btn-sm btn-icon-split">
                                                    <span class="icon text-white-60">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php $say++;
                            }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kategori ID</th>
                                <th>Kategori Üst ID</th>
                                <th>Kategori Adı</th>
                                <th>İşlemler</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    $("#musteritablosu").DataTable();
</script>

<?php
if (isset($_GET['durum'])) {
    if ($_GET['durum'] == "ok") { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'İşlem Başarılı',
                text: 'İşleminiz başarıyla gerçekleştirilmiştir.',
                confirmButtonText: "Tamam"
            })
        </script>

    <?php } else { ?>

        <script>
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'İşleminiz başarısız. Lütfen tekrar deneyin.',
                confirmButtonText: "Tamam"
            })
        </script>

<?php }
} ?>