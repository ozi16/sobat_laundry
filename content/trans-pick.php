<?php

// Munculkan / Pilih sebuah kolom dari tabel users(database)
$queryTransOrder = mysqli_query($koneksi, "SELECT customer.customer_name, trans_order.* FROM trans_order LEFT JOIN customer ON customer.id = trans_order.id_customer ORDER BY id DESC");
//untuk menjadikan hasil query(data dari queryTransOrder) = menjadi sebuah data objek
//Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM trans_order WHERE id = '$id'");
    header("Location:?pg=trans_order&hapus=berhasil");
}
?>




<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Pengambilan Laundry</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <div align="right" class="mb-3">
                    <a href="?pg=tambah-trans" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>No Invoice</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Laundry</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            include 'helper.php';
                            while ($row_trans = mysqli_fetch_assoc($queryTransOrder)) { ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row_trans['order_code'] ?></td>
                                    <td><?php echo $row_trans['customer_name'] ?></td>
                                    <td><?php echo $row_trans['order_date'] ?></td>
                                    <td><?php echo $row_trans['order_end'] ?></td>
                                    <td>
                                        <?php
                                        echo changeStatus($row_trans['status'])
                                        ?>
                                    </td>
                                    <td>
                                        <a href="?pg=tambah-trans&detail=<?php echo $row_trans['id'] ?>">
                                            <span class="tf-icon btn btn-primary bx bx-show"></span>
                                        </a> |
                                        <a target="_blank" href="?pg=print&id=<?php echo $row_trans['id'] ?>">
                                            <span class="tf-icon btn btn-success bx bx-printer"></span>
                                        </a> |
                                        <a onclick="return confirm('Apakah antum yakin akan menghapus data ini??')" href="?pg=trans_order&delete=<?php echo $row_trans['id'] ?>">
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


<!-- / Content -->