<?php

require "fungsi.php";

session_start();

if($_SESSION['username'] != 'admin') header('location:index.php');

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
        echo "<br/>";
        var_dump($_FILES);
        
        $judul_buku = antiInjection($_POST['judul_buku']);
        $deskripsi = antiInjection($_POST['deskripsi']);
        $pengarang = antiInjection($_POST['pengarang']);
        $jenis_buku = antiInjection($_POST['jenis_buku']);
        $id_admin = $_SESSION['id'];
        $file = antiInjection(basename($_FILES['file']['name']));

        $target_dir = "buku/";
        $ekstensi = ["pdf"];
        $errorIndex = upload_file($_FILES, $ekstensi, $target_dir);//akan mengembalikan nama file yg disimpan jika upload sukses
        echo "<br/> " . $errorIndex. " ". gettype($errorIndex). " ". is_string($errorIndex);
        // die;
      
            if(!empty(trim($judul_buku)) && !empty(trim($deskripsi)) && !empty(trim($pengarang))  && !empty(trim($jenis_buku))
                && !empty(trim($id_admin)) && $errorIndex == $file){
                
                $query = "INSERT INTO buku(id_buku, judul_buku, deskripsi, pengarang, jenis_buku, id_admin, file, create_date) VALUES
                            (NULL, '$judul_buku', '$deskripsi', '$pengarang', '$jenis_buku', '$id_admin', '$file', CURRENT_TIMESTAMP())";
                $sql = mysqli_query($conn, $query);

                if($sql){
                    echo "<script>alert('Sukses Upload buku')</script>";
                    header('location:index.php');
                    die();
                } else {
                    echo "<script>alert('Gagal menyimpan buku')</script>";
                }
            } else {
                echo "<script>alert('Data tidak boleh kosong')</script>";
                unlink("buku/". $errorIndex);
                $errorIndex = 5;
            } 
    }

    if(!empty($errorIndex)){
        echo $error[$errorIndex];
        header("location:form-tambah-edit-buku.php?msg=$error[$errorIndex]");
    }
}