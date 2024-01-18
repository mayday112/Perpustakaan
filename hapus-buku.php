<?php

require('fungsi.php');

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');

$id_buku = antiInjection($_GET['id_buku']);

echo $id_buku."<br/>";

$query = "SELECT file FROM buku WHERE id_buku = '$id_buku';";
$sql  = mysqli_query($conn, $query);
$file_path = "buku/". mysqli_fetch_assoc($sql)['file'];

echo $file_path;

if(unlink($file_path)){
    $queryDel = "DELETE FROM buku WHERE id_buku='$id_buku';";
    $sqlDel = mysqli_query($conn, $queryDel);
    if($sqlDel) {
        echo "berhasil menghapus";
        $_SESSION['msg'] = "Berhasil Menghapus Buku";
        header('location:index.php');
    }
} else {
    echo "gagal menghapus";
}

