<?php
session_start();
include "../database/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryLogin = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");

    if (mysqli_num_rows($queryLogin) > 0) {
        $rowUser = mysqli_fetch_assoc($queryLogin);
        if ($rowUser['password'] == $password) {
            $_SESSION['EMAIL'] = $rowUser['email'];
            $_SESSION['ID'] = $rowUser['id'];
            $_SESSION['id_level'] = $rowUser['id_level'];
            header('location:../index.php?login=berhasil');
        } else {
            header('location:login.php?error=login');
        }
    } else {
        header('location:login.php?error=login');
    }
}

// function loginQuery($koneksi, $kolom, $params)
// {
//     $query = mysqli_query($koneksi, "SELECT * FROM user WHERE $kolom='$params'");
//     if (mysqli_num_rows($query) > 0) {
//         return $query;
//     } else {
//         return false;
//     }
//     // return $query;
// }

// if (isset($_POST['login'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     $queryLogin = loginQuery($koneksi, "name", $email);
//     $queryEmail = loginQuery($koneksi, "email", $email);
//     // print_r($queryLogin);
//     // die;

//     // LOGIN DENGAN USERNAME
//     if ($queryLogin) {
//         $rowLogin = mysqli_fetch_assoc($queryLogin);
//         if ($password == $rowLogin['password']) {
//             $_SESSION['nama'] = $rowLogin['name'];
//             $_SESSION['id'] = $rowLogin['id'];
//             $_SESSION['id_level'] = $rowLogin['id_level'];
//             header('location:../index.php');
//         } else {
//             header('location:login.php?login=gagal');
//         }
//         // LOGIN DENGAN EMAIL 
//     } elseif ($queryEmail) {
//         $rowLogin = mysqli_fetch_assoc($queryEmail);
//         if ($password == $rowLogin['password']) {
//             $_SESSION['nama'] = $rowLogin['name'];
//             $_SESSION['id'] = $rowLogin['id'];
//             $_SESSION['id_level'] = $rowLogin['id_level'];
//             header('location: ../index.php');
//         } else {
//             header('location: login.php?login=gagal');
//         }
//     }
// }
