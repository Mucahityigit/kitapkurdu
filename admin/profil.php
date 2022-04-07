<?php include "header.php";

    $profilsor = $db->prepare("SELECT * FROM kullanicilar WHERE kul_id=:kul_id");
    $profilsor->execute(array(
        'kul_id' => $_SESSION['kul_id']
    ));

    $profilcek = $profilsor->fetch(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary">Profil</h5>
                </div>
                <div class="card-body">
                    <form action="islemler/islem.php" method="POST">
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>İsim</label>
                                <input type="text" name="kul_isim" class="form-control" value="<?php echo $profilcek['kul_isim'] ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mail</label>
                                <input type="text" name="kul_mail" class="form-control" value="<?php echo $profilcek['kul_mail'] ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label>Sifre <small>(Boş Bırakırsanız Şifre Değişmez)</small> </label>
                                <input type="password" name="kul_sifre" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Tel</label>
                                <input type="text" name="kul_tel" class="form-control" value="<?php echo $profilcek['kul_tel'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="profilkaydet">Kaydet</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>










<?php include "footer.php" ?>