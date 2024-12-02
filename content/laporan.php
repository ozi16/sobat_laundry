<?php

// Munculkan / Pilih sebuah kolom dari tabel users(database)
$tanggal_dari = isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : '';
$tanggal_sampai = isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$query = "SELECT customer.customer_name, trans_order.* FROM trans_order LEFT JOIN customer ON customer.id = trans_order.id_customer WHERE 1 ";

// JIKA STATUS TIDAK KOSONG
if ($tanggal_dari != "") {
    $query .= " AND tanggal_laundry >= '$tanggal_dari'";
}

if ($tanggal_sampai != "") {
    $query .= " AND tanggal_laundry <= '$tanggal_sampai'";
}

if ($status != "") {
    $query .= " AND status = $status";
}
$query .= " ORDER BY trans_order.id DESC";

$queryTransOrder = mysqli_query($koneksi, $query);
// //untuk menjadikan hasil query(data dari queryTransOrder) = menjadi sebuah data objek
// //Delete 
// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];
//     $delete = mysqli_query($koneksi, "DELETE FROM trans_order WHERE id = '$id'");
//     header("Location:trans_order.php?hapus=berhasil");
// }
?>


<div class="row">
    <div class="col-sm-12">
        <div class="card mt-5">
            <div class="card-header">Transaksi Laundry</div>
            <div class="card-body">
                <?php if (isset($_GET['hapus'])) : ?>
                    <div class="alert alert-success" role="alert">
                        Data berhasil Di hapus
                    </div>
                <?php endif; ?>
                <!-- FILTER DATA TRANSAKSI -->
                <form action="" method="get">
                    <div class="mb-3 row">
                        <div class="col-sm-3">
                            <label for="">Tanggal dari</label>
                            <input type="date" name="tanggal_dari" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="">Tanggal sampai</label>
                            <input type="date" name="tanggal_sampai" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="">--Pilih Status--</option>
                                <option value="0">Baru</option>
                                <option value="1">Sudah Dikembalikan</option>
                            </select>
                        </div>
                        <div class="col-sm-3 d-flex align-items-end">
                            <button name="filter" class="btn btn-primary">Tampilkan Laporan</button>
                        </div>
                    </div>
                </form>
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

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>