<?php

require("fungsi.php");

session_start();

$user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$nama = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$nim = isset($_SESSION['id']) ? $_SESSION['id'] : '';

$_SESSION['msg'] = '';

// print_r($status_ta);

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
    <style>
        .btn-login{
            padding: 6px 30px;
        }
    </style>
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
                        <a href="index.php" class="nav-link ">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="ta-mhs.php" class="nav-link text-light">TA mhs</a>
                    </li>
                    <?php if($role == 'admin'){ ?>
                    <li class="nav-item">
                        <a href="data-mhs.php" class="nav-link text-light">Data Mahasiswa</a>
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
                            <a href='logout.php' class='btn btn-danger'><?php echo $nama; ?> |<i class="bi bi-box-arrow-in-left"></i> Logout</a>
                        <?php
                        }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
<!-- akhir nav -->

<!-- jumbotron -->
    <div class="jumbotron jumbotron-fluid bg-light">
        <div class="container">
            <h1 class="display-4 text-center mt-4">Selamat datang di Perpustakaan Politeknik ABC</h1>
        </div>
    </div>
    <!-- akhir jumbotron -->
<!-- <?php echo $role;?> -->
<!-- Tabel untuk menampilkan buku-buku -->
    <div class="container">
        <?php if($role == 'admin'){ ?>
            <a href="form-tambah-edit-buku.php" class="btn btn-primary" style="float:right;margin-right:10px;margin-bottom:10px;"><i class="bi bi-upload"></i><br/>Buku</a>
        <?php } ?>
        <table class="table table-bordered">
            <!-- menampilkan header table -->
            <thead>
                <tr class="table-primary">
                    <th style="width:10px;" class="text-center col-sm-1" scope="col">No</th>
                    <th style="width:10px;" class="text-center col-sm-3" scope="col">Foto</th>
                    <th style="width:10px;" class="text-center col-sm-2" scope="col">Judul</th>
                    <th style="width:10px;" class="text-center col-sm-2" scope="col">Deskripsi</th>
                    <th style="width:10px;" class="text-center col-sm-2" scope="col">Pengarang</th>
                    <th style="width:10px;" class="text-center col-sm-2" scope="col">Jenis</th>
                    
                    <!-- untuk menghilangkan kolom action ketika pengunjung perpus orang eksternal kampus -->
                    <?php if($role == 'admin' || $role == 'mhs' || $role == 'mhs-ta'){ ?>
                        <th style="width:60px;" class="text-center col-sm-2" scope="col">Action</th> 
                    <?php }?>
                </tr>
            </thead>
            <!-- menampilkan isi tabel -->
            <tbody>
            <tr class="table-secondary">
                <?php

                $buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul_buku");
                $no = 1;

                foreach($buku as $row){

                    echo "<tr>
                        <td style='width:30px;' class='text-center'>$no</td>
                        <td style='width:100px;' class='text-center'><iframe src='buku/".$row['file']."' frameborder='0' style='width:100%;height:100%;' scrolling='no'></iframe></td>
                        <td style='width:10px;' class='text-center'><a href='buku/".$row['file']."#toolbar=0' target='_blank'>".$row['judul_buku']."</a></td>
                        <td style='width:100px;' class='text-center'><div style='width:100%;height:200px;overflow: auto;'class='overflow-auto text-center'>".$row['deskripsi']."</div></td>
                        <td style='width:10px;' class='text-center'><div style='width:100%;height:200px;overflow: auto;'class='overflow-auto text-center'>".$row['pengarang']."</div></td>
                        <td style='width:10px;' class='text-center'>".$row['jenis_buku']."</td>
                        ";

                        if($role == 'admin' || $role == 'mhs' || $role == 'mhs-ta'){
                            echo "<td class='text-center col-sm-2'>
                                    <a href='download.php?buku=buku/".$row['file']."' class='btn btn-primary' target='blank'><i class='bi bi-download'></i></a> ";

                            if($role == 'admin'){
                            echo ("<a href='form-tambah-edit-buku.php?id_buku=$row[id_buku]' class='btn btn-warning'><i class='bi bi-pencil-square'></i></a> 
                                    <a href='hapus-buku.php?id_buku=$row[id_buku]' class='btn btn-primary btn-danger' 
                                    onclick='return confirm(\"Yakin ingin menghapus?\")'> <i class='bi bi-trash'></i></a>");
                            } 
                            echo "</td>
                            </tr>";
                        }

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
</body>
</html>