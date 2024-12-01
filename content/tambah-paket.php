<?php

if (isset($_POST['simpan'])) {
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $sql = "INSERT INTO type_of_service (service_name, description, price) VALUES ('$nama_paket','$deskripsi','$harga')";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        header("Location: ?pg=paket");
    } else {
        echo "Error disimpan";
        echo mysqli_error($koneksi);
    }
}
// Parameter Edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM type_of_service WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($koneksi, "UPDATE type_of_service SET service_name='$nama_paket', description='$deskripsi', price='$harga' WHERE id='$id'");
    header("location:?pg=paket&ubah=berhasil");
}

// if (isset($_GET['delete'])) {
//   $id = $_GET['id'];
//   $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
//   header("location:user.php?delete=berhasil");
// }
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
                            <label for="">Nama Paket</label>
                            <input type="text" class="form-control" name="nama_paket" id="" placeholder="Masukan Nama customer" value="<?php echo isset($_GET['edit']) ? $rowEdit['service_name'] : '' ?>" required>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="">Harga</label>
                            <input type="number" class="form-control" name="harga" id="" placeholder="Masukan Nomor Telepon" value="<?php echo isset($_GET['edit']) ? $rowEdit['price'] : '' ?>" required>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="" placeholder="Masukan Alamat" value="<?php echo isset($_GET['edit']) ? $rowEdit['description'] : '' ?>" required>
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