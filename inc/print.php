<?php
session_start();
include "../database/koneksi.php";
$id = isset($_GET['id']) ? $_GET['id'] : "";

// QUERY MENGAMBIL DATA DETAIL PENJUAL DAN PENJUALAN
$queryDetail = mysqli_query($koneksi, "SELECT trans_order.id, type_of_service.service_name, type_of_service.price , trans_order_detail.*,trans_order.* FROM trans_order_detail LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order LEFT JOIN type_of_service ON type_of_service.id = trans_order_detail.id_service WHERE trans_order_detail.id_order='$id'");
$row = [];
while ($rowDetail = mysqli_fetch_assoc($queryDetail)) {
    $row[] = $rowDetail;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi : </title>
    <style>
        body {
            margin: 20px;
        }

        .struk {
            width: 80mm;
            max-width: 100%;
            border: 1px solid #000000;
            padding: 10px;
            margin: 0 auto;
        }

        .struk-header,
        .struk-footer {
            text-align: center;
            margin-bottom: 10px;
        }

        .struk-header h1 {
            font-size: 18px;
            margin: 0;
        }

        .struk-body {
            margin-bottom: 10px;
            /* border-top: 1px solid #000000; */
        }

        .struk-body table {
            border-collapse: collapse;
            width: 100%;
        }

        .struk-body table th,
        .struk-body table td {
            padding: 5px;
            text-align: left;
        }

        .struk-body table th {
            border-bottom: 1px solid #000000;
        }

        .total,
        .payment,
        .change {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-weight: bold;
        }

        .total {
            margin-top: 10px;
            border-top: 1px solid #000000;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .struk {
                width: auto;
                border: none;
                margin: 0;
                padding: 0;
            }

            .struk-header h1,
            .struk-footer {
                font-size: 14px;
            }

            .struk-body table th,
            .struk-body table td {
                padding: 2px;
            }

            .total,
            .payment,
            .change {
                padding: 2px 0;
            }
        }
    </style>
</head>

<body>

    <div class="struk">
        <div class="struk-header">
            <h1>Sobat laundry</h1>
            <p>jl.jakarta Timur, Jaktim</p>
            <p>Telp: 021-123456789</p>
        </div>
        <div class="struk-body mt-3">
            <table>
                <thead>
                    <tr>
                        <th>Paket</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $key => $rowDetail): ?>
                        <tr>
                            <td><?php echo $rowDetail['service_name'] ?></td>
                            <td><?php echo $rowDetail['qty'] ?> Kg</td>
                            <td><?php echo "Rp. " . number_format($rowDetail['price']) ?></td>
                            <td><?php echo "Rp. " . number_format($rowDetail['subtotal']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <div class="total">
                <span>Total : </span>
                <span><?php echo "Rp ." . number_format($row[0]['total_price']) ?></span>
            </div>
            <div class="payment">
                <span>Bayar : </span>
                <span><?php echo "Rp ." . number_format($row[0]['order_pay']) ?></span>
            </div>
            <div class="change">
                <span>Kembali : </span>
                <span><?php echo "Rp ." . number_format($row[0]['order_change']) ?></span>
            </div>
        </div>
        <div class="struk-footer">
            <p>Terima Kasih Atas Kunjungan Anda</p>
            <p>JANGAN LUPA DATANG LAGI </p>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>