<?php

if (isset($_POST['simpan'])) {
    $nama = $_POST['name'];
    $addres = $_POST['adress'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO customer (customer_name, phone, adress) VALUES ('$nama','$phone','$addres')";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        header("Location:?pg=customer");
    } else {
        echo "Error disimpan";
        echo mysqli_error($koneksi);
    }
}
// Parameter Edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM customer WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama = $_POST['name'];
    $addres = $_POST['adres'];
    $phone = $_POST['phone'];

    $update = mysqli_query($koneksi, "UPDATE customer SET customer_name='$nama', phone='$phone', adress='$addres' WHERE id='$id'");
    header("location:?pg=customer&ubah=berhasil");
}


?>


<style>
    placeholder {
        margin-top: 2rem;
    }
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> customer</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <div class="col-sm-12 mb-4">
                            <label for="">Nama customer</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Masukan Nama customer" value="<?php echo isset($_GET['edit']) ? $rowEdit['customer_name'] : '' ?>" required>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="">Nomor Telepon</label>
                            <input type="number" class="form-control" name="phone" id="" placeholder="Masukan Nomor Telepon" value="<?php echo isset($_GET['edit']) ? $rowEdit['phone'] : '' ?>" required>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="">Alamat</label>
                            <input type="text" class="form-control" name="adress" id="" placeholder="Masukan Alamat" value="<?php echo isset($_GET['edit']) ? $rowEdit['adress'] : '' ?>" required>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>