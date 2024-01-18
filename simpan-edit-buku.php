<?php

require("fungsi.php");

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');

$error = [  "Masukkan File!",
            "File yang dapat diupload hanya pdf, doc, dan docx !",
            "File harus berukuran dibawah 100 MB !", 
            "Terjadi masalah ketika upload !",
            "Buku sudah ada !",
            "Data Tidak boleh Kosong!"];
    
$errorIndex = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['upload'])){
        var_dump($_POST);
        echo "<br />";
        var_dump($_FILES);

        
        $id_buku = antiInjection($_POST['id_buku']);
        $judul_buku = antiInjection($_POST['judul_buku']);
        $deskripsi = antiInjection($_POST['deskripsi']);
        $pengarang = antiInjection($_POST['pengarang']);
        $jenis_buku = antiInjection($_POST['jenis_buku']);
        $id_admin = $_SESSION['id'];
        $file = $_POST['file_lama'];

        if($_FILES['file']['error'] == 0){
            $target_dir = "buku/";
            $ekstensi = ["pdf"];
            $errorIndex = upload_file($_FILES, $ekstensi, $target_dir);
            $file = $errorIndex;
        }
        echo "<br/> " . $errorIndex;

      
        if(!empty(trim($id_buku)) && !empty(trim($judul_buku)) && !empty(trim($deskripsi)) && !empty(trim($pengarang))  && !empty(trim($jenis_buku))
            && !empty(trim($id_admin)) && ($errorIndex == null or $errorIndex == $file)){
                
            $query = "UPDATE buku SET judul_buku = '$judul_buku', deskripsi = '$deskripsi', pengarang = '$pengarang',
                        jenis_buku = '$jenis_buku', id_admin = '$id_admin', file = '$file', create_date = CURRENT_TIMESTAMP()
                        WHERE id_buku = '$id_buku'";
            $sql = mysqli_query($conn, $query);

            if($sql){
                echo "sukses menyimpaaaan";
                header('location:index.php');
                die();
            } else {
                echo "gagal menyimpaaaan!";
            }
        } else {
            echo "Data tidak boleh kosong";
            $errorIndex = 5;
        }

        if(!empty($errorIndex)){
            echo $error[$errorIndex];
            header("location:form-tambah-edit-buku.php?id_buku=$id_buku&msg=$error[$errorIndex]");
        }
    } 
}
