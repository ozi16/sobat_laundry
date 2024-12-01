<?php

// Munculkan / Pilih sebuah kolom dari tabel users(database)
$queryPaket = mysqli_query($koneksi, "SELECT * FROM type_of_service ORDER BY id DESC");
//untuk menjadikan hasil query(data dari queryPaket) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM type_of_service WHERE id = '$id'");
    header("Location:?pg=paket&hapus=berhasil");
}
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Data paket</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <div align="right" class="mb-3">
                    <a href="?pg=tambah-paket" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowPaket = mysqli_fetch_assoc($queryPaket)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowPaket['service_name'] ?></td>
                                    <td><?php echo "Rp. " . number_format($rowPaket['price']) ?></td>
                                    <td><?php echo $rowPaket['description'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-paket&edit=<?php echo $rowPaket['id'] ?>">
                                            <span class="tf-icon btn btn-success bx bx-pencil"></span>
                                        </a> |
                                        <a onclick="return confirm('Apakah antum yakin akan menghapus data ini??')" href="?pg=paket&delete=<?php echo $rowPaket['id'] ?>">
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