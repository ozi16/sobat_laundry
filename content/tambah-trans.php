<?php

if (isset($_POST['simpan'])) {
    // Mengambil nilai dari form input dengan attr name=""
    $id_customer = $_POST['id_customer'];
    $no_transaksi = $_POST['no_transaksi'];
    $tanggal_laundry = $_POST['tanggal_laundry'];
    $laundry_pengembalian = $_POST['laundry_pengembalian'];
    $status = $_POST['status'];
    $total_price = $_POST['total_price'];
    $order_pay = $_POST['order_pay'];
    $order_change = $_POST['order_change'];

    $id_paket = $_POST['id_service'];
    $qty = $_POST['qty'];
    // INSERT KE TABLE TRANS_ORDER
    $insertTransOrder = mysqli_query($koneksi, "INSERT INTO trans_order(id_customer, order_code, order_date, order_end, status, total_price, order_pay,order_change) VALUES ('$id_customer','$no_transaksi','$tanggal_laundry','$laundry_pengembalian','$status', '$total_price', '$order_pay','$order_change')");

    $last_id = mysqli_insert_id($koneksi);
    // INSERT KE TABLE TRANS_DETAIL_ORDER
    // MENGAMBIL NILAI LEBIH DARI SATU, LOOPING DENGAN FOREACH
    foreach ($id_paket as $key => $value) {
        $id_paket = array_filter($_POST['id_service']);
        $qty = array_filter($_POST['qty']);
        $id_paket = $_POST['id_service'][$key];
        $qty = $_POST['qty'][$key];

        // MENGAMBIL HARGA PAKET DARI DATABASE(table paket)
        $queryPaket = mysqli_query($koneksi, "SELECT id, price FROM type_of_service WHERE id='$id_paket'");
        $rowPaket = mysqli_fetch_assoc($queryPaket);
        $harga = isset($rowPaket['price']) ? $rowPaket['price'] : '';
        // SUBTOTAL
        // $subtotal = (int)$qty * (int)$harga;
        $subtotal = round((float)$qty * $harga, 2); // Menghitung subtotal dengan desimal

        if ($id_paket > 0) {
            $insertTransDetail = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES ('$last_id','$id_paket','$qty','$subtotal')");
            // print_r($insertTransDetail);
            // die;
        }
    }

    header("Location:?pg=trans-order&tambah=berhasil");

    // foreach ($id_paket as $key => $value) {
    //     $id_paket = array_filter($_POST['id_service']);
    //     $qty = array_filter($_POST['qty']);
    //     $id_paket = $_POST['id_service'][$key];
    //     $qty = $_POST['qty'][$key]; // Berat dalam kg, bisa memiliki nilai desimal

    //     // MENGHITUNG HARGA BERDASARKAN PAKET
    //     $harga = 0;
    //     switch ($id_paket) {
    //         case '1': // Cuci dan Gosok
    //             $harga = 5000;
    //             break;
    //         case '2': // Hanya Cuci
    //             $harga = 4500;
    //             break;
    //         case '3': // Hanya Gosok
    //             $harga = 5000;
    //             break;
    //         case '4': // Cuci Besar
    //             $harga = 7000;
    //             break;
    //         default:
    //             $harga = 0; // Jika tidak ada paket yang cocok
    //     }

    //     // SUBTOTAL
    //     $subtotal = round((float)$qty * $harga, 2); // Menghitung subtotal dengan desimal

    //     if ($id_paket > 0) {
    //         $insertTransDetail = mysqli_query($koneksi, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal) VALUES ('$last_id','$id_paket','$qty','$subtotal')");
    //     }
    // }
}

$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$id = isset($_GET['detail']) ? $_GET['detail'] : '';
$queryTransDetail = mysqli_query($koneksi, "SELECT customer.customer_name,customer.phone, customer.adress, trans_order.order_code, trans_order.order_date,trans_order.order_end, trans_order.status, trans_order.total_price, trans_order.order_pay, trans_order.order_change, type_of_service.service_name, type_of_service.price, trans_order_detail.* FROM trans_order_detail LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order LEFT JOIN customer ON customer.id = trans_order.id_customer WHERE trans_order_detail.id_order = '$id'");
// $data = mysqli_fetch_assoc($queryTransDetail);
// die;
$row = [];
while ($dataTrans = mysqli_fetch_assoc($queryTransDetail)) {
    $row[] = $dataTrans;
    //     print_r($row);
    //     die;
}

// echo "<pre>";
// print_r($row);
// die;


$queryService = mysqli_query($koneksi, "SELECT * FROM type_of_service");
// $rowPaket = [];
// while ($data = mysqli_fetch_assoc($queryService)) {
//     $rowPaket[] = $data;
// }


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


    header("Location:?pg=trans_order&tambah=berhasil");
}


$queryPaketDetail = mysqli_query($koneksi, "SELECT customer.customer_name, customer.phone, customer.adress, trans_order.order_code, trans_order.order_date, trans_order.status, trans_order.id_customer, type_of_service.service_name, type_of_service.price, trans_order_detail.* FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order LEFT JOIN customer ON customer.id = trans_order.id_customer");
// $rowPaketDetail = mysqli_fetch_assoc($queryPaketDetail);
// echo "<pre>";
$rowPickup = [];
while ($dataPickup = mysqli_fetch_assoc($queryPaketDetail)) {
    $rowPickup[] = $dataPickup;
}
// print_r($rowPickup);
// die;

if (isset($_POST['ambil'])) {
    // print_r($_POST);
    // die;
    $id_customer = $_POST['id_customer'];
    $id_order = $_POST['id_order'];
    $pickup_date = date("Y-m-d");

    $sqlInsertTransaksi = mysqli_query($koneksi, "INSERT INTO trans_laundry_pickup (id_customer, id_order, pickup_date) VALUES ('$id_customer', '$id_order', '$pickup_date')");

    // ubah status order
    $updateTransaksiStatus = mysqli_query($koneksi, "UPDATE trans_order SET status = 1 WHERE id = '$id_order'");

    header('location: ?pg=trans_order.php?insert-berhasil');
}

?>



<style>
    .placeholder {
        margin-top: 2rem;
    }
</style>


<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <?php if (isset($_GET['detail'])) : ?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>Transaksi Laundry <?php echo $row[0]['customer_name'] ?></h5>
                                </div>
                                <div class="col-sm-6" align="right">
                                    <a href="?pg=trans-order" class="btn btn-secondary">Kembali</a>
                                    <a href="?pg=print.php&id=<?php echo $row[0]['id_order'] ?>" class="btn btn-success">Print</a>

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
                                    <td><?php echo $row[0]['order_code'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laundry</th>
                                    <td><?php echo $row[0]['order_date'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laundry pengembalian</th>
                                    <td><?php echo $row[0]['order_end'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php echo changeStatus($row[0]['status']) ?>
                                    </td>
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
                                    <td><?php echo $row[0]['customer_name']
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td><?php echo $row[0]['phone']
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?php echo $row[0]['adress']
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <form action="" method="post">


                        <div class="card-header">
                            <h5>Transaksi Detail</h5>
                        </div>
                        <div class="card-body">
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
                                    foreach ($row as $key => $value) : ?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo $value['service_name'] ?></td>
                                            <td><?php echo $value['qty'] ?></td>
                                            <td><?php echo "Rp . " . number_format($value['price'])  ?></td>
                                            <td><?php echo "Rp . " . number_format($value['subtotal'])  ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right">Total</td>
                                        <td>
                                            <input type="number" name="total" class="total-harga form-control" value="<?= $row[0]['total_price'] ?>">
                                        </td>
                                        <input type="hidden" name="id_customer" value="<?= $rowPickup[0]['id_customer'] ?>">
                                        <input type="hidden" name="id_order" value="<?= $rowPickup[0]['id_order'] ?>">
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">Bayar</td>
                                        <td>
                                            <input type="number" name="pickup_pay" class="bayar form-control" value="<?= $row[0]['order_pay'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="right">kembalian</td>
                                        <td>
                                            <input type="number" name="pickup_change" class="bayar form-control" value="<?= $row[0]['order_change'] ?>">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($row[0]['status'] == 0) { ?>
                                <button href="?pg=tambah-trans-pickup&ambil=<?php echo $row[0]['id_order'] ?>" name="ambil" class="btn btn-warning mb-3">Ambil Cucian</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm">
                        <div class="card mt-5">
                            <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                            <div class="card-body">
                                <?php if (isset($_GET['hapus'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        Data berhasil Di hapus
                                    </div>
                                <?php endif; ?>
                                <div class="mb-3 row">
                                    <div class="col-sm-6 mb-4">
                                        <label for="">No. Invoice</label>
                                        <input type="text" class="form-control" name="no_transaksi" id="" placeholder="kode transaksi" value="#<?php echo $code ?>" readonly required>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label for="">Qty</label>
                                        <input type="number" class="form-control qty" name="qty" id="" placeholder="qty" value="#<?php echo $code ?>" required>
                                    </div>
                                    <div class="col-sm-12 mb-4">
                                        <label for="">Pelanggan</label>
                                        <select class="form-control" name="id_customer" id="">
                                            <option value="">--Pilih Pelanggan--</option>
                                            <?php while ($rowCustomer = mysqli_fetch_assoc($queryCustomer)) { ?>
                                                <option value="<?php echo $rowCustomer['id'] ?>"><?php echo $rowCustomer['customer_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 mb-4">
                                        <label for="">Paket</label>
                                        <select class="form-control" name="" id="id_service">
                                            <option value="">--Pilih Paket--</option>
                                            <?php while ($rowPaket = mysqli_fetch_assoc($queryService)) { ?>
                                                <option value="<?php echo $rowPaket['id'] ?>" data-price="<?= $rowPaket['price'] ?>"><?php echo $rowPaket['service_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 mb-4">
                                        <label for="">Tanggal Laundry</label>
                                        <input type="date" class="form-control" name="tanggal_laundry" id="" placeholder="Masukan tanggal laundry anda" value="<?php echo isset($_GET['edit']) ? $rowEdit['name'] : '' ?>" required>
                                    </div>
                                    <div class="col-sm-6 mb-4">
                                        <label for="">Tanggal pengembalian</label>
                                        <input type="date" class="form-control" name="laundry_pengembalian" id="" placeholder="Masukan tanggal laundry anda" value="<?php echo isset($_GET['edit']) ? $rowEdit['name'] : '' ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="card mt-3">
                            <div class="card-header">Detail Transaksi</div>
                            <div class="card-body">
                                <?php if (isset($_GET['hapus'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        Data berhasil Di hapus
                                    </div>
                                <?php endif; ?>
                                <div class="btn d-flex justify-content-end">
                                    <button class="btn btn-primary add-row">Tambah </button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Paket</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-parent">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" align="right">Total</td>
                                                <td>
                                                    <input type="number" name="total_price" class="total-harga form-control">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="4" align="right">Bayar</td>
                                                <td>
                                                    <input type="number" name="order_pay" class="bayar form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" align="right">kembalian</td>
                                                <td>
                                                    <input type="number" name="order_change" class="bayar form-control">
                                                </td>
                                            </tr>
                                        </tfoot>

                                    </table>
                                    <div class="btn">
                                        <button class="btn btn-success" name="simpan">Kirim</button>
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