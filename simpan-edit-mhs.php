<?php

require("fungsi.php");

session_start();

if($_SESSION['username'] != "admin") header("location:index.php");

// print_r($_POST);


$error = "";

if(isset($_POST['submit'])){

    $nim_awal = $_GET['nim'];
    $nim = antiInjection($_POST['nim']);
    $nama_mhs = antiInjection($_POST['nama_mhs']);
    $jenis_kelamin = antiInjection($_POST['jenis_kelamin']);
    $id_prodi = antiInjection($_POST['prodi']);
    $id_smt = antiInjection($_POST['smt']);
    $status = antiInjection($_POST['status']);
    $email = antiInjection($_POST['email']);

    if(!empty(trim($nim)) && !empty(trim($nama_mhs)) && !empty(trim($jenis_kelamin)) && !empty(trim($id_prodi)) && !empty(trim($id_smt))
        && !empty(trim($status)) && !empty(trim($email))){

                $query = "UPDATE mhs SET nim ='$nim', nama_mhs='$nama_mhs', jenis_kelamin='$jenis_kelamin', 
                            id_prodi='$id_prodi', id_smt='$id_smt', status='$status', email='$email' WHERE nim = '$nim_awal';";

                $result = mysqli_query($conn, $query);

                if($result){
                    
                    $_SESSION['msg'] = "Sukses ubah Data Mahasiswa";
                    header('location: data-mhs.php');
                } else {
                    $error = 'Edit Data Mahasiswa gagal!';
                    header("location:form-tambah-edit-mhs.php?nim=$nim_awal&msg=$error");
                }
    } else {
        $error = 'Data tidak boleh kosong!';
        header("location:form-tambah-edit-mhs.php?nim=$nim_awal&msg=$error");
    }
}


