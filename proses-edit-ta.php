<?php

require('fungsi.php');

session_start();

if($_SESSION['role'] != 'mhs-ta') header('location:index.php');

$error = [  "Masukkan File!",
            "File yang dapat diupload hanya pdf, doc, dan docx !",
            "File harus berukuran dibawah 100 MB !", 
            "Terjadi masalah ketika upload !",
            "Buku sudah ada !",
            "Data Tidak boleh Kosong!"];
    
$errorIndex = null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])){
        var_dump($_POST);
        echo "<br/><br/>";
        var_dump($_FILES);
    
        $id_laporan = antiInjection($_POST['id_laporan']);
        $judul_laporan = antiInjection($_POST['judul_laporan']);
        $abstrak = antiInjection($_POST['abstrak']);
        $nim = $_SESSION['id'];
        $file = antiInjection($_POST['file_lama']);

        echo $file;
        if($_FILES['file']['error'] == 0){
            $target_dir = "ta/";
            $ekstensi = ["pdf"];
            $errorIndex = upload_file($_FILES, $ekstensi, $target_dir);
            $file = $errorIndex;
        }

        echo "<br/> <br/>" . $errorIndex. " ". gettype($errorIndex). " ". is_string($errorIndex);
        // die;
      
            if(!empty(trim($id_laporan)) && !empty(trim($judul_laporan)) && !empty(trim($abstrak)) && !empty(trim($nim))  && ($errorIndex == $file OR $errorIndex == null)){
                
                $query = "UPDATE lap_ta SET judul_laporan = '$judul_laporan', abstrak = '$abstrak',file = '$file',
                            status = 'Proses', create_date = CURRENT_TIMESTAMP() WHERE id_laporan = '$id_laporan'";
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
                if(is_string($errorIndex)) unlink("ta/". $errorIndex);
        }
    }
}