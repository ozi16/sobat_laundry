<?php

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    $sql = "INSERT INTO level (level_name) VALUES ('$nama')";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        header("Location: ?pg=level");
    } else {
        echo "Error disimpan";
        echo mysqli_error($koneksi);
    }
}
// Parameter Edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM level WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama = $_POST['nama'];
    //jika password di isi oleh user
    $update = mysqli_query($koneksi, "UPDATE level SET level_name='$nama' WHERE id='$id'");
    header("location:?pg=level&ubah=berhasil");
}

// if (isset($_GET['delete'])) {
//   $id = $_GET['id'];
//   $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
//   header("location:user.php?delete=berhasil");
// }

$queryLevel = mysqli_query($koneksi, "SELECT * FROM level");
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Level</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <div class="col-sm-12 mb-4">
                            <label for="">Nama Level</label>
                            <input type="text" class="form-control" name="nama" id="" placeholder="Masukan Nama Level" value="<?php echo isset($_GET['edit']) ? $rowEdit['level_name'] : '' ?>" required>
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