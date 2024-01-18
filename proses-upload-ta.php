<?php

require('fungsi.php');

session_start();

if($_SESSION['role'] != 'mhs-ta') header('location:index.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])){
        var_dump($_POST);
        echo "<br/><br/>";
        var_dump($_FILES);
        $judul_laporan = antiInjection($_POST['judul_laporan']);
        $abstrak = antiInjection($_POST['abstrak']);
        $nim = $_SESSION['id'];
        $file = antiInjection($_FILES['file']['name']);

        $target_dir = "ta/";
        $ekstensi = ["pdf"];
        $errorIndex = upload_file($_FILES, $ekstensi, $target_dir);//akan mengembalikan nama file yg disimpan jika upload sukses
        echo "<br/> <br/>" . $errorIndex. " ". gettype($errorIndex). " ". is_string($errorIndex);
        // die;
      
            if(!empty(trim($judul_laporan)) && !empty(trim($abstrak)) && !empty(trim($nim))  && $errorIndex == $file && !empty(trim($status))){
                
                $query = "INSERT INTO lap_ta(id_laporan, judul_laporan, abstrak, nim, file, status, create_date) VALUES
                            (NULL, '$judul_laporan', '$abstrak', '$nim', '$file', 'Proses', CURRENT_TIMESTAMP());";
                $sql = mysqli_query($conn, $query);

                if($sql){
                    echo "<script>alert('Sukses Upload TA')</script>";
                    header('location:index.php');
                    die();
                } else {
                    echo "<script>alert('Gagal menyimpan Laporan')</script>";
                }
            } else {
                echo "<script>alert('Data tidak boleh kosong')</script>";
                unlink("ta/". $errorIndex);
        }
    }
}