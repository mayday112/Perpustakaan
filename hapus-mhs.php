<?php

include 'fungsi.php';

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');

$nim = antiInjection($_GET['nim']);

// echo $id_user;
// cek apakah id user yang akan dihapus tersedia
$query1 = "SELECT * FROM mhs WHERE nim = $nim;";
$sql1 = mysqli_query($conn, $query1);
$rows = mysqli_num_rows($sql1);
// hapus user

if($rows != 0){

    $query = "DELETE FROM mhs WHERE nim = '$nim';";
    $sql = mysqli_query($conn, $query);
    
    if ($sql) {
        $_SESSION['msg'] = "Sukses menghapus!";
    } else {
        $_SESSION['msg'] = "Gagal menghapus!";
    }
} else {
    $_SESSION['msg'] = "Gagal menghapus!";
}

header('location:data-mhs.php');



