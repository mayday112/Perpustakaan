<?php

include "fungsi.php";

session_start();

if($_SESSION['username'] != 'admin') header("location:index.php");

$nim = antiInjection($_GET['nim']);

$encrypt = password_hash($nim, PASSWORD_DEFAULT);

$sql = "UPDATE mhs SET password= '$encrypt' WHERE nim = '$nim';";
$execute = mysqli_query($conn, $sql);

if($execute){
    $_SESSION['msg'] = "Password telah direset!";
    header("location:data-mhs.php");
} else {
    die(mysqli_error());
}
