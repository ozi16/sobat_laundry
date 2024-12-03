<?php

if (isset($_POST['simpan_transaksi'])) {
    // Mengambil nilai dari form input dengan attr name=""
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_pay = $_POST['pickup_pay'];
    $pickup_change = $_POST['pickup_change'];
    $pickup_date = date("Y-m-d");

    // INSERT KE TABLE TRANS_ORDER
    $insertTransPickup = mysqli_query($koneksi, "INSERT INTO trans_laundry_pickup(id_customer, id_order, pickup_pay, pickup_change, pickup_date) VALUES ('$id_customer','$id_order','$pickup_pay','$pickup_change','$pickup_date')");

    // ubah status order jadi 1 / sudah di ambil
    $updateTransOrder = mysqli_query($koneksi, "UPDATE trans_order SET status = 1 WHERE id = '$id_order'");

    // menghitung pembayaran


    header("Location:?pg=trans-order&tambah=berhasil");
}

$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$id = isset($_GET['ambil']) ? $_GET['ambil'] : '';
$queryTransDetail = mysqli_query($koneksi, "SELECT customer.id AS id_customer, customer.customer_name,customer.phone, customer.adress, trans_order.order_code, trans_order.order_date, trans_order.status, type_of_service.service_name, type_of_service.price, trans_order_detail.* FROM trans_order_detail LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order LEFT JOIN customer ON customer.id = trans_order.id_customer WHERE trans_order_detail.id_order = '$id'");
$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
}

// echo "<pre>";
// print_r($row);
// die;


$queryPaket = mysqli_query($koneksi, "SELECT * FROM type_of_service");
$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

$queryTransPickup = mysqli_query($koneksi, "SELECT * FROM trans_laundry_pickup WHERE id_order = '$id'");


// NO INVOICE CODE
// 001, jika ada autp increment id + 1 = 002, selain itu 001
// MAX : terbesar, MIN : terkecil
$queryInvoice = mysqli_query($koneksi, "SELECT MAX(id) AS no_invoice FROM trans_order");
//JIKA DI DALAM TABLE TRANS ORDER ADA DATANYA
$str_unique = "INV";
$date_now = date("dmy");
if (mysqli_num_rows($queryInvoice) > 0) {
    $rowInvoice = mysqli_fetch_assoc($queryInvoice);
    $incrementPlus = $rowInvoice['no_invoice'] + 1;
    $code = $str_unique . "-" . $date_now . "-" . "000" . $incrementPlus;
} else {
    # JIKA DI DALAM TABLE TRANS ORDER TIDAK ADA DATANYA
    $code = $str_unique . "-" . $date_now . "-" . "0001";
}

?>




<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <?php if (isset($_GET['ambil'])) : ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Pengambilan Laundry <?php echo $row[0]['customer_name'] ?></h5>
                                </div>
                                <div class="col-sm-6" align="right">
                                    <a href="?pg=trans-order" class="btn btn-secondary">Kembali</a>
                                    <a href="?pg=print&id=<?php echo $id ?>" class="btn btn-success">Print</a>
                                    <a href="" class="btn btn-warning">Ambil Cucian</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5>Data Transaksi</h5>
                        </div>
                        <?php include 'helper.php' ?>
                        <div class="card-body">
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>No. Invoice</th>
                                    <td><?php echo $row[0]['order_code'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laundry</th>
                                    <td><?php echo $row[0]['order_date'] ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo changeStatus($row[0]['status']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5>Data Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>Nama</th>
                                    <td><?php echo $row[0]['customer_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?php echo $row[0]['phone'] ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?php echo $row[0]['adress'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5>Transaksi Detail</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <table class="table table-bordered table-stripped">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Paket</th>
                                            <th>Quantity</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        $total = 0;
                                        foreach ($row as $key => $value) : ?>
                                            <tr>
                                                <td><?php echo $no++ ?></td>
                                                <td><?php echo $value['service_name'] ?></td>
                                                <td><?php echo $value['qty'] ?></td>
                                                <td><?php echo "Rp . " . number_format($value['price'])  ?></td>
                                                <td><?php echo "Rp . " . number_format($value['subtotal'])  ?></td>
                                            </tr>
                                            <?php
                                            $total += $value['subtotal'];
                                            ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td class="" colspan="4" align="right"><strong>Total Keseluruhan</strong></td>
                                            <td class=""><strong>Rp <?php echo number_format($total) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td class="" colspan="4" align="right"><strong>Bayar</strong></td>
                                            <td class="">
                                                <strong>
                                                    <?php if (mysqli_num_rows($queryTransPickup) > 0) : ?>
                                                        <?php $rowTransPickup = mysqli_fetch_assoc($queryTransPickup); ?>
                                                        <input class="form-control" value="<?php echo number_format($rowTransPickup['pickup_pay'])  ?>" type="text" readonly name="pickup_pay">
                                                    <?php else : ?>
                                                        <input class="form-control" value="<?php echo isset($_POST['pickup_pay']) ? $_POST['pickup_pay'] : '' ?>" placeholder="Masukkan Nominal Bayar" type="number" name="pickup_pay">
                                                    <?php endif ?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="" colspan="4" align="right"><strong>Kembalian</strong></td>
                                            <?php
                                            if (isset($_POST['proses_kembalian'])) {
                                                $total = $_POST['total'];
                                                $dibayar = $_POST['pickup_pay'];
                                                $kembalian = 0;
                                                $kembalian = (int)$dibayar - (int)$total;
                                            } ?>
                                            <td class="">
                                                <input type="hidden" name="total" value="<?php echo $total ?>">
                                                <input type="hidden" name="id_customer" value="<?php echo $row[0]['id_customer'] ?>">
                                                <input type="hidden" name="id_order" value="<?php echo $row[0]['id_order'] ?>">
                                                <?php if (mysqli_num_rows($queryTransPickup) > 0) : ?>
                                                    <strong>
                                                        <input class="form-control" type="text" readonly value="<?php echo number_format($rowTransPickup['pickup_change']) ?>">
                                                    </strong>
                                                <?php else : ?>
                                                    <strong>
                                                        <input class="form-control" placeholder="Nominal Kembalian" type="number" name="pickup_change" readonly value="<?php echo isset($kembalian) ? $kembalian : 0 ?>">
                                                    </strong>

                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <?php if ($row[0]['status'] == 0) : ?>
                                            <tr>
                                                <td colspan="5">
                                                    <div class="d-flex justify-content-evenly">
                                                        <button class="btn btn-primary" name="proses_kembalian">Proses Kembalian</button>
                                                        <button class="btn btn-success" name="simpan_transaksi">Simpan Transaksi</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card mt-5">
                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                            <div class="card-body">
                                <?php if (isset($_GET['hapus'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        Data berhasil Di hapus
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3 row">
                                    <div class="col-sm-12 mb-4">
                                        <label for="">Pelanggan</label>
                                        <select class="form-control" name="id_customer" id="">
                                            <option value="">--Pilih Pelanggan--</option>
                                            <?php while ($rowCustomer = mysqli_fetch_assoc($queryCustomer)) { ?>
                                                <option value="<?php echo $rowCustomer['id'] ?>"><?php echo $rowCustomer['customer_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label for="">No. Invoice</label>
                                        <input type="text" class="form-control" name="no_transaksi" id="" placeholder="Masukan Nama anda" value="#<?php echo $code ?>" readonly required>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label for="">Tanggal Laundry</label>
                                        <input type="date" class="form-control" name="tanggal_laundry" id="" placeholder="Masukan tanggal_laundry anda" value="<?php echo isset($_GET['edit']) ? $rowEdit['name'] : '' ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card mt-5">
                            <div class="card-header">Detail Transaksi</div>
                            <div class="card-body">
                                <?php if (isset($_GET['hapus'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        Data berhasil Di hapus
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3 row">
                                    <div class="row mb-4">
                                        <div class="col-sm-3 mb-4">
                                            <label for="">Paket</label>
                                        </div>
                                        <div class="col-sm-9 mb-4">
                                            <select class="form-control" name="id_paket[]" id="">
                                                <option value="">--Pilih Paket--</option>
                                                <?php foreach ($rowPaket as $key => $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mb-4">
                                            <label for="">QTY</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="qty[]" id="" placeholder="Masukan Quantity">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-3 mb-4">
                                            <label for="">Paket</label>
                                        </div>
                                        <div class="col-sm-9 mb-4">
                                            <select class="form-control" name="id_paket[]" id="">
                                                <option value="">--Pilih Paket--</option>
                                                <?php foreach ($rowPaket as $key => $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 mb-4">
                                            <label for="">QTY</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="qty[]" id="" placeholder="Masukan Quantity">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    <?php endif ?>
</div>
<!-- / Content -->