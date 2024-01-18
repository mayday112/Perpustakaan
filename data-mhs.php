<?php
// perisapan
include 'koneksi.php';

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$_SESSION['msg'] = '';

// echo "data user";

$user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan PolTek ABC</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dar bg-dark text-light">
            <div class="container-fluid">
            <a href="index.php" class="navbar-brand">Perpus PolTek <span>ABC</span></a>
            <button class="navbar-toggler" type="button" data-togle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-auto pt-2 pb-2">
                <!-- hanya admin  yang memiliki akses ke halaman TA dan data user -->
                <?php if($role == 'admin' || $role == 'mhs' || $role == 'mhs-ta'){ ?>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link text-light">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="ta-mhs.php" class="nav-link text-light">TA mhs</a>
                    </li>
                    <?php if($role == 'admin'){ ?>
                    <li class="nav-item">
                        <a href="data-mhs.php" class="nav-link">Data Mahasiswa</a>
                    </li>
                <?php } elseif($role == 'mhs-ta') { ?>
                    <!-- hanya mhs TA yang memiliki akses ke halaman upload TA -->
                    <li class="nav-item">
                        <a href="form-upload-edit-ta.php" class="nav-link text-light">Upload TA</a>
                    </li>
                <?php }
                } ?>
                <li>
                    <!-- tombol untuk keperluan login dan menambah akses -->
                    <?php if($role == '') { ?>
                        <a href="login.php" class="btn btn-primary btn-login"><i class="bi bi-box-arrow-in-right"></i> | Login</a>
                    <?php } 
                        if(isset($_SESSION['role'])){ ?>
                            <a href='logout.php' class='btn btn-danger'><?php echo $user; ?> |<i class="bi bi-box-arrow-in-left"></i> Logout</a>
                        <?php
                        }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
<!-- akhir nav -->


<!-- pesan msg setelah query hapus-->
<br/>
<h1 class="h1 text-center">Daftar Mahasiswa</h1>
<!-- Tabel untuk menampilkan info user -->
<div class="container">
        <a href="form-tambah-edit-mhs.php" class="btn btn-primary" style="float:right;margin-right:10px;margin-bottom:10px;margin-top:20px;"><i class="bi bi-person-plus"></i></a>
        <table class="table table-bordered">
            <!-- menampilkan header table -->
            <thead>
                <tr class="table-primary">
                    <th class="text-center " scope="col">No</th>
                    <th class="text-center " scope="col">NIM</th>
                    <th class="text-center " scope="col">Nama</th>
                    <th class="text-center " scope="col">Jenis Kelamin</th> 
                    <th class="text-center " scope="col">Semester</th> 
                    <th class="text-center " scope="col">Prodi</th> 
                    <th class="text-center " scope="col">Email</th> 
                    <th class="text-center " scope="col">Status</th> 
                    <th class="text-center " scope="col">Action</th> 
                </tr>
            </thead>
            <!-- menampilkan isi tabel -->
            <tbody>
            <tr class="">
                <?php

                include 'koneksi.php';

                $sql = mysqli_query($conn, "SELECT mhs.nim, mhs.nama_mhs, mhs.jenis_kelamin, smt.nama_smt, prodi.nama_prodi, mhs.email, mhs.status 
                                    FROM mhs
                                    INNER JOIN smt ON mhs.id_smt = smt.id_smt
                                    INNER JOIN prodi ON mhs.id_prodi = prodi.id_prodi
                                    ORDER BY status;");
                $no = 1;

                foreach($sql as $row){
            
                    echo "<tr>
                            <td class='text-center'>$no</td>
                            <td class='text-center'>".$row['nim']."</td>
                            <td class='text-center'>".$row['nama_mhs']."</td>
                            <td class='text-center'>".$row['jenis_kelamin']."</td>
                            <td class='text-center'>".$row['nama_smt']."</td>
                            <td class='text-center'>".$row['nama_prodi']."</td>
                            <td class='text-center'>".$row['email']."</td>
                            <td class='text-center'>".$row['status']."</td>
                            <td class='text-center col-sm-2'>
                            <a href='form-tambah-edit-mhs.php?nim=$row[nim]' class='btn btn-warning'><i class='bi bi-pencil-square'></i> </a>
                            <a href='hapus-mhs.php?nim=".$row['nim']."' class='btn btn-danger' onclick='return confirm(\"Apakah anda akan menghapus data ini?\");' ><i class='bi bi-trash'></i> </a>
                            <a href='reset-pw.php?nim=".$row['nim']."' class='btn btn-secondary'onclick='return confirm(\"Apakah anda akan mereset password mahasiswa?\");'><i class='bi bi-arrow-counterclockwise'></i></a>
                            </td>
                        </tr>";
                    $no++;
                }        
              ?>
            </tbody>
        </table>
        <!-- akhir table -->
    </div>

    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <?php 
        // echo $msg;
        if($msg != ""){ ?>
            <script> alert("<?= $msg; ?>")</script>
    <?php } ?>  
</body>
</html>