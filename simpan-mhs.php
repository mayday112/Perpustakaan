<?php

require("fungsi.php");
require("koneksi.php");

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');


$error = "";

if(isset($_POST['submit'])){

    $nim = antiInjection($_POST['nim']);
    $nama_mhs = antiInjection($_POST['nama_mhs']);
    $jenis_kelamin = antiInjection($_POST['jenis_kelamin']);
    $id_prodi = antiInjection($_POST['prodi']);
    $id_smt = antiInjection($_POST['smt']);
    $status = antiInjection($_POST['status']);
    $email = antiInjection($_POST['email']);
    $password = antiInjection($_POST['password']);
    $repass = antiInjection($_POST['repass']);

    if(!empty(trim($nim)) && !empty(trim($nama_mhs)) && !empty(trim($jenis_kelamin)) && !empty(trim($id_prodi)) && !empty(trim($id_smt))
        && !empty(trim($status)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))){

        if($password == $repass){

            if(cek_mhs($nim,$conn) == 0){
                $pass_hash = password_hash($password, PASSWORD_DEFAULT);//hash password
                $query = "INSERT INTO mhs(nim, nama_mhs, jenis_kelamin, id_prodi, id_smt, status, email, password) VALUES ('$nim', '$nama_mhs','$jenis_kelamin', '$id_prodi', '$id_smt', '$status', '$email', '$pass_hash');";
                $result = mysqli_query($conn, $query);
                if($result){
                    
                    $_SESSION['msg'] = "Sukses Input Data Mahasiswa";
                    header('location: data-mhs.php');
                } else {
                    $error = 'Register gagal!';
                    header("location:form-tambah-edit-mhs.php?msg=$error");
                }
            } else {
                $error = 'Mahasiswa sudah terdaftar';
                header("location:form-tambah-edit-mhs.php?msg=$error");
            }
        } else {
            $error = 'Password tidak sama!';
            header("location:form-tambah-edit-mhs.php?msg=$error");
        }
    } else {
        $error = 'Data tidak boleh kosong!';
        header("location:form-tambah-edit-mhs.php?msg=$error");
    }
}

