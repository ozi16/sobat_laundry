<?php
// Munculkan / Pilih sebuah kolom dari tabel users(database)
$queryUser = mysqli_query($koneksi, "SELECT user.*, level.level_name FROM user LEFT JOIN level ON level.id = user.id_level ORDER BY id DESC");
//untuk menjadikan hasil query(data dari queryUser) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id = '$id'");
    header("Location:?pg=user&hapus=berhasil");
}
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Data User </div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <div align="right" class="mb-3">
                    <a href="?pg=tambah-user" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Level</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowUser = mysqli_fetch_assoc($queryUser)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowUser['level_name'] ?></td>
                                    <td><?php echo $rowUser['name'] ?></td>
                                    <td><?php echo $rowUser['email'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-user?edit=<?php echo $rowUser['id'] ?>">
                                            <span class="tf-icon btn btn-success bx bx-pencil"></span>
                                        </a> |
                                        <a onclick="return confirm('Apakah antum yakin akan menghapus data ini??')" href="?pg=user&delete=<?php echo $rowUser['id'] ?>">
                                            <span class="tf-icon btn btn-danger bx bx-trash bx-12px"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>