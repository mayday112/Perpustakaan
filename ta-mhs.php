<?php

require("fungsi.php");

session_start();

if(!isset($_SESSION['username'])) header('location:index.php');

$user = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$nama = isset($_SESSION['name']) ? $_SESSION['name'] : '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['status'])){
        // print_r($_POST);
        $id_laporan = $_POST['id_laporan'];
        $status = $_POST['status'];

        $query = "UPDATE lap_ta SET status ='$status' WHERE id_laporan='$id_laporan'";

        if($conn -> query($query)){
            echo "<script>alert('Sukses!')</script>";
        } else {
            echo "<script>alert('Sukses!')</script>";
        }    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman TA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                        <a href="ta-mhs.php" class="nav-link">TA mhs</a>
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
<br>
<h2 class="text-center">Daftar Tugas Akhir</h2>
<br>
<div class="container">
</div>
<div class="container">
    <table class="table table-bordered">
        <!-- menampilkan header table -->
        <thead>
            <tr class="table-primary">
                <th class="text-center col-sm-1" scope="col">No</th>
                <th class="text-center col-sm-3" scope="col">Judul Tugas Akhir</th>
                <th class="text-center col-sm-2 " scope="col">Abstrak</th>
                <th class="text-center col-sm-2" scope="col">Nim</th>
                <th class="text-center col-sm-2" scope="col">Mahasiswa</th>
                <th class="text-center col-sm-2" scope="col">Semester</th>
                <th class="text-center col-sm-2" scope="col">Prodi</th>
                <th class="text-center col-sm-2" scope="col">Jenjang</th>
                <th class="text-center col-sm-2" scope="col">Status</th>
                
                <!-- untuk menghilangkan kolom action ketika pengunjung perpus orang eksternal kampus -->
                <?php if($role == 'admin'){ ?>
                    <th class="text-center " style="width:500px;" scope="col">Action</th> 
                <?php }?>
            </tr>
        </thead>
        <!-- menampilkan isi tabel -->
        <tbody>
            <?php

            $query = "SELECT ta.id_laporan, ta.judul_laporan, ta.abstrak, m.nim, m.nama_mhs, s.nama_smt, p.nama_prodi, p.jenjang, ta.file, ta.status FROM lap_ta ta 
                        INNER JOIN mhs m ON ta.nim = m.nim 
                        INNER JOIN smt s ON m.id_smt = s.id_smt 
                        INNER JOIN prodi p ON m.id_prodi = p.id_prodi 
                        WHERE ta.status = 'Selesai' ORDER BY p.nama_prodi;";       
            if($role == 'admin') $query = "SELECT ta.id_laporan, ta.judul_laporan, ta.abstrak, m.nim, m.nama_mhs, s.nama_smt, p.nama_prodi, p.jenjang, ta.file, ta.status FROM lap_ta ta 
                                            INNER JOIN mhs m ON ta.nim = m.nim 
                                            INNER JOIN smt s ON m.id_smt = s.id_smt 
                                            INNER JOIN prodi p ON m.id_prodi = p.id_prodi ORDER BY p.nama_prodi;";
            $sql = mysqli_query($conn, $query);
            $no = 1;
            

            foreach($sql as $row){
                echo "<tr>
                    <td style='width:10px;' class='text-center'>$no</td>
                    <td style='width:10px;' class='text-center'><a href='ta/".$row['file']."#toolbar=0' target='_blank' ><div style='width=100%; height:100px; overflow:auto;'>".$row['judul_laporan']."</div></a></td>
                    <td style='width:10px;' class='text-center '><div style='width=100%; height:100px; overflow:auto;'>".$row['abstrak']."</div></td>
                    <td style='width:10px;' class='text-center'>".$row['nim']."</td>
                    <td style='width:10px;' class='text-center'>".$row['nama_mhs']."</td>
                    <td style='width:10px;' class='text-center'>".$row['nama_smt']."</td>
                    <td style='width:10px;' class='text-center'>".$row['nama_prodi']."</td>
                    <td style='width:10px;' class='text-center'>".$row['jenjang']."</td>
                    <td style='width:10px;' class='text-center'>".$row['status']."</td> ";
                    
                    if($role == 'admin'){
                        $disable = $row['status'] != "Proses" ? "disabled" : "";
                        echo ("<td style='width:500px;' class='text-center col-sm-2'>");
                        ?>
                        <form action="ta-mhs.php" method="post">
                            <input type="hidden" name="id_laporan" value="<?= $row['id_laporan']?>">
                            <button type="submit" class="btn btn-success" name="status" value="Selesai" onclick="return confirm('Apakah anda yakin?') "<?= $disable?>>Setujui</button>
                            <button type="submit" class="btn btn-danger" name="status" value="Ditolak"  onclick="return confirm('Apakah anda yakin?') "<?= $disable?>>Tolak</button>
                        </form>
                        <?php
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


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   
</body>
</html>
