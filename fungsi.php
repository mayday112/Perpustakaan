<?php

include('koneksi.php');

//fungsi untuk mengamankan dari sql injection : biar datamu aman mazz🥰
function antiInjection($data){
    global $conn;
    $filter = stripslashes($data);

    $filter = mysqli_real_escape_string($conn, $filter);
    return $filter;
}


// fungsi untuk akses mahasiswa sesuai dengan NIM
function cek_mhs($nim, $conn){
    $nama = mysqli_real_escape_string($conn, $nim);
    $query = "SELECT * FROM mhs WHERE nim = '$nim';";

    if($result = mysqli_query($conn, $query)) return mysqli_num_rows($result);
}


// fungsi untuk memberi nilai awal pada input  tipe select
function active_radio_button($value, $input){
    $result = $value==$input ? 'checked' : '';
    return $result;
};
// fungsi untuk memberi nilai awal pada input  tipe select
function active_select_button($value, $input){
    $result = $value==$input ? 'selected' : '';
    return $result;
};


// fungsi untuk upload file
function upload_file($file, $ekstensi, $target_dir){

    $errorIndex = null;
    $fileName = basename($file['file']['name']);
    $target_file = $target_dir . $fileName;
    $gas_upload = 1;
    $fileType = explode(".", $fileName);
    $fileType  = strtolower(end($fileType));
    $fileTmp = $file['file']['tmp_name'];


    if($file['file']['error'] != 0){
        
        // $gas_upload = 0;
        echo "<br/>file tidak ada";
        return 0;
    }
    
    // cek apakah file berekstensi pdf 
    if(!in_array($fileType, $ekstensi)){
        // $gas_upload = 0;
        echo "<br/>file  tidak memenuhi syarat  ekstensi";
        return 1;
    }
    
    // cek apakah file lebih besar dari 100 MB
    if($file['file']['size'] > 100000000){
        // $gas_upload = 0;
        echo "<br/>file terlalu besar > 100 MB ";
        return 2;
    }

    if(move_uploaded_file($fileTmp, $target_file)){
        echo "<br/>sukses upload";
        return $fileName;
    } else {
        // $errorIndex = 3;
        echo "<br/>terjadi masalah ketika proses upload";
        return 3;
    }
}
