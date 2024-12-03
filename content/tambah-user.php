<?php


if (isset($_POST['simpan'])) {
    $nama = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $id_level = $_POST['id_level'];

    $sql = "INSERT INTO user (id_level,name,email,password) VALUES ('$id_level','$nama','$email','$password')";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        header("Location: ?pg=user");
    } else {
        echo "Error disimpan";
        echo mysqli_error($koneksi);
    }
}
// Parameter Edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_level = $_POST['id_level'];

    //jika password di isi oleh user
    if ($_POST['password']) {
        $password = $_POST['password'];
    } else {
        $password = $rowEdit['password'];
    }

    $update = mysqli_query($koneksi, "UPDATE user SET id_level='$id_level', name='$nama', email='$email', password='$password' WHERE id='$id'");
    header("location:?pg=user&ubah=berhasil");
}

// if (isset($_GET['delete'])) {
//   $id = $_GET['id'];
//   $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
//   header("location:user.php?delete=berhasil");
// }

$queryLevel = mysqli_query($koneksi, "SELECT * FROM level");
?>


<style>
    placeholder {
        margin-top: 2rem;
    }
</style>



<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> User</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <div class="col-sm-6 mb-4">
                            <label for="">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="" placeholder="Masukan Nama anda" value="<?php echo isset($_GET['edit']) ? $rowEdit['name'] : '' ?>" required>
                        </div>

                        <div class="col-sm-6 mb-4">
                            <label for="">Masukan Email</label>
                            <input type="email" class="form-control" name="email" id="" placeholder="Masukan email anda" value="<?php echo isset($_GET['edit']) ? $rowEdit['email'] : '' ?>" required>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <label for="">Pilih Level</label>
                            <select class="form-control" name="id_level" id="">
                                <option value="">--Pilih Level--</option>
                                <?php while ($rowLevel = mysqli_fetch_assoc($queryLevel)) {

                                ?>
                                    <option <?php echo isset($_GET['edit']) ? ($rowLevel['id'] == $rowEdit['id_level'] ? 'selected' : '') : '' ?> value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['level_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" id="" placeholder="Masukan password anda">
                        </div>
                        <!-- <div class="col-sm-6">
                          <label for="">Uplode Foto</label>
                          <input type="file" class="form-control" name="foto" id="">
                        </div> -->
                        <div class="col-sm-6">
                            <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>