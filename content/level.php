<?php

// Munculkan / Pilih sebuah kolom dari tabel users(database)
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level ORDER BY id DESC");
//untuk menjadikan hasil query(data dari queryLevel) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM level WHERE id = '$id'");
    header("Location:?pg=level&hapus=berhasil");
}
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Data Level </div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <div align="right" class="mb-3">
                    <a href="?pg=tambah-level" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowLevel = mysqli_fetch_assoc($queryLevel)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowLevel['level_name'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-level&edit=<?php echo $rowLevel['id'] ?>">
                                            <span class="tf-icon btn btn-success bx bx-pencil"></span>
                                        </a> |
                                        <a onclick="return confirm('Apakah antum yakin akan menghapus data ini??')" href="?pg=level.php&delete=<?php echo $rowLevel['id'] ?>">
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