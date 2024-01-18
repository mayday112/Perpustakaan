<?php 
// persiapan
require ('koneksi.php');
require ('fungsi.php');

session_start();

if($_SESSION['role'] != 'admin') header('location:index.php');

$error = isset($_GET['msg']) ? $_GET['msg'] : "";
$halaman = 'Tambah';
$data = array(
    "nim" => "",
    "nama_mhs" => "",
    "jenis_kelamin" => "",
    "id_prodi" => "",
    "id_smt" => "",
    "email" => "",
    "status" => "",
);

if(isset($_GET['nim'])) {
    global $data; 
    $nim = antiInjection($_GET['nim']);
    $query = "SELECT nim, nama_mhs, jenis_kelamin, id_prodi, id_smt, email, status FROM mhs WHERE nim = '$nim';";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
    static $halaman = 'Edit';
}
// print_r($data);
$nim_awal = $data['nim'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form <?= $halaman; ?>User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .container{
            margin-top:50px;
            padding : 20px;
            border-radius: 16px;
            box-shadow: 3px 5px 10px gray;
            box-sizing:border-box;
        }

        .container-radio > *{
            padding : 10px 20px;
            margin : 10px;
        }

        select{
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container ">
        <form action="<?php echo ($halaman == "Edit") ? "simpan-edit-mhs.php?nim=$nim_awal" : "simpan-mhs.php";?>" method="post">
            <fieldset>
                <legend>Form Tambah Data Mahasiswa</legend>
            <div class="form-group">
                <label for="nim" class="form-label">NIM : </label>
                <input type="text" name="nim" id="nim" class="form-control" value="<?= $data['nim']?>" required>
            </div>
            <div class="form-group">
                <label for="nama" class="form-label">Nama :</label>
                <input type="text" name="nama_mhs" id="nama" class ="form-control" value="<?= $data['nama_mhs']?>" required>
            </div>
            <div class="form-group form-inline">
                <div class="form-check container-radio">
                    <label for="jenis_kelamin" class="form-label ">Jenis Kelamin</label>
                    <input type="radio" name="jenis_kelamin" id="" value="" style="display:none;" checked>
                    <label for="admin" class="form-check-label radio-inline">
                        <input type="radio" class="" name="jenis_kelamin" id="" value="laki-laki" <?php echo active_radio_button("laki-laki", $data['jenis_kelamin']); ?> >
                        Laki-laki
                    </label>
                    <label for="mahasiwa-ta" class="form-check-label radio-inline">
                        <input type="radio" class="" name="jenis_kelamin" id="" value ="perempuan" <?php echo active_radio_button("perempuan", $data['jenis_kelamin']); ?>>
                        Perempuan
                    </label>
                </div>
            </div>      
            <div class="form-group">
                <label for="prodi" class="form-label">Prodi :   </label>
                <select class="form-select" name="prodi" aria-label="Default select example" style="border: 1px solid gray;border-radius:5px;" required>
                  <option selected>Pilih Prodi</option>
                  <?php     
                    $query = "SELECT id_prodi, nama_prodi FROM prodi WHERE status = 'aktif' ORDER BY create_date DESC;";
                    $sql = mysqli_query($conn, $query);
                    $result = mysqli_fetch_assoc($sql);

                    foreach($sql as $row){
                  ?>
                  <option value=<?php echo "\"".$row['id_prodi']."\" ". active_select_button($row['id_prodi'], $data['id_prodi']); ?> ><?= $row['nama_prodi']?></option>
                  <?php } ?>  
                </select>
            </div>
            <div class="form-group">
                <label for="smt" class="form-label">Semester :   </label>
                <select class="form-select" name="smt" aria-label="Default select example" style="border: 1px solid gray;border-radius:5px;" required>
                  <option selected>Pilih Semester</option>
                  <?php     
                    $query = "SELECT id_smt, nama_smt FROM smt ORDER BY create_date DESC;";
                    $sql = mysqli_query($conn, $query);
                    $result = mysqli_fetch_assoc($sql);
 
                    foreach($sql as $row){
                  ?>
                  <option value=<?php echo "\"".$row['id_smt']."\" ". active_select_button($row['id_smt'], $data['id_smt']); ?> ><?= $row['nama_smt']?></option>
                  <?php } ?>  
                </select>
            </div>
            <div class="form-group">
                <label for="status" class="form-label">Status :   </label>
                <select class="form-select" name="status" aria-label="Default select example" style="border: 1px solid gray;border-radius:5px;" required>
                    <option selected>Pilih Status</option>
                    <option value="aktif" <?= active_select_button("aktif", $data['status'])?> >Aktif</option>    
                    <option value="cuti" <?= active_select_button("cuti", $data['status'])?> >Cuti</option>    
                    <option value="DO" <?= active_select_button("DO", $data['status'])?> >Drop Out</option>    
                    <option value="undri" <?= active_select_button("undri", $data['status'])?> >Undur Diri</option>    
                </select>
            </div>
            <div class="form-group">
                <label for="nim" class="form-label">Email : </label>
                <input type="email" name="email" id="nim" class="form-control" value="<?= $data['email']?>" required>
            </div>
            <?php if($halaman != "Edit"){ ?>
            <div class="form-group">
                <label for="password" class="form-label">Pasword :</label>
                <input type="password" name="password" id="username" class ="form-control" required>
            </div>
            <div class="form-group">
                <label for="repass" class="form-label">Konfirmasi Pasword :</label>
                <input type="password" name="repass" id="repass" class ="form-control" required>
            </div>
            <?php } ?>
            <br/>
            <?php
                if(!empty($error)) echo "<p class='alert alert-danger' id='liveAlertPlaceholder'>$error</p>";
            ?>

            <div class="form-gruop">
                <button type="submit" class="btn btn-warning" name="submit" value="simpan">Simpan</button>
                <a href="data-mhs.php" class="btn btn-primary">Kembali</a>
            </div>   
            </fieldset>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>