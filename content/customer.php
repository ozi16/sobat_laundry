<?php

// Munculkan / Pilih sebuah kolom dari tabel users(database)
$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer ORDER BY id DESC");
//untuk menjadikan hasil query(data dari queryCustomer) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM customer WHERE id = '$id'");
    header("Location:?pg=customer&hapus=berhasil");
}
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Data Customer</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <div align="right" class="mb-3">
                    <a href="?pg=tambah-customer" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama Pelanggan</th>
                                <th>Nomor telepon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($rowCustomer = mysqli_fetch_assoc($queryCustomer)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $rowCustomer['customer_name'] ?></td>
                                    <td><?php echo $rowCustomer['phone'] ?></td>
                                    <td><?php echo $rowCustomer['adress'] ?></td>
                                    <td>
                                        <a href="?pg=tambah-customer&edit=<?php echo $rowCustomer['id'] ?>">
                                            <span class="tf-icon btn btn-success bx bx-pencil"></span>
                                        </a> |
                                        <a onclick="return confirm('Apakah antum yakin akan menghapus data ini??')" href="?pg=customer&delete=<?php echo $rowCustomer['id'] ?>">
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
</div>

<!-- / Content -->