<?php
session_start();
include "../database/koneksi.php";

// function loginQuery($koneksi, $kolom, $params)
// {
//     $query = mysqli_query($koneksi, "SELECT * FROM user WHERE $kolom='$params'");
//     if (mysqli_num_rows($query) > 0) {
//         return $query;
//     } else {
//         return false;
//     }
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // $queryLogin = loginQuery($koneksi, 'username', $email);
    // $queryEmail = loginQuery($koneksi, 'email', $email);
    // // login dengan username
    // if ($queryLogin) {
    //     $rowLogin = mysqli_fetch_assoc($queryLogin);
    //     if ($rowUser['password'] == $password) {
    //         $_SESSION['EMAIL'] = $rowLogin['email'];
    //         $_SESSION['ID'] = $rowLogin['id'];
    //         $_SESSION['id_level'] = $rowLogin['id_level'];
    //         header('location:../index.php?login=berhasil');
    //     } else {
    //         header('location:login.php?error=login');
    //     }
    // } elseif ($queryEmail) {
    //     $rowLogin = mysqli_fetch_assoc($queryEmail);
    //     if ($password == $rowLogin['password']) {
    //         header("location:../index.php");
    //     } else {
    //         header('location:login.php?error=login');
    //     }
    // }

    // login dengan email 

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
