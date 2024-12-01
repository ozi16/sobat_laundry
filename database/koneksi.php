<?php
$host_koneksi = 'localhost';
$username_koneksi = 'root';
$password_koneksi = '';
$database_koneksi = 'laundry_kalisari';

$koneksi = mysqli_connect($host_koneksi, $username_koneksi, $password_koneksi, $database_koneksi);
if (!$koneksi) {
    echo "Koneksi Gagal";
}
