<?php

require('fungsi.php');

session_start();

if($_SESSION['role'] != 'mhs-ta') header('location:index.php');
$nim = $_SESSION['id'];

// echo "ini form uplod TA<br/>";

$halaman = "Form Upload TA";
$action = "proses-upload-ta.php";
$disable = "";
$data = [
    "id_laporan" => null,
    "judul_laporan" => null,
    "abstrak" => null,
    "file" => null,
    "status" => null
];

$query = "SELECT nama_mhs FROM mhs WHERE nim = '$nim'";

$query1 = "SELECT * FROM lap_ta WHERE nim = '$nim'";

$sql = $conn -> query($query);
$sql1 = $conn -> query($query1);

echo "<br/>";


if($sql1 -> num_rows != 0){
    $halaman = "Form TA";
    $action = "proses-edit-ta.php";
    $data = mysqli_fetch_assoc($sql1);
    $disable = ($data['status'] == "Proses" OR $data['status'] == "Selesai") ? "disabled" : "";
    //jika status pengumpulan masib proses atau selesai maka semua input akan disable
}
// echo $disable;
// print_r($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $halaman?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
         .container{
            margin-top:50px;
            padding : 20px;
            border-radius: 16px;
            box-shadow: 3px 5px 10px gray;
            box-sizing:border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <?=  mysqli_fetch_assoc($sql)['nama_mhs'] ?>
        <?php if(isset($data['status'])){
                if($data['status'] == "Proses"){
                    echo("<div class='alert alert-secondary'>Laporan Anda Sedang diproses</div>");
                } else if( $data['status'] == "Selesai"){
                    echo("<div class='alert alert-success'>Laporan Anda Selesai<br/>Selamat</div>");
                } else if($data['status'] == "Ditolak"){
                    echo ("<div class='alert alert-danger'>Laporan Anda Ditolak<br/>Silakan Upload Laporan yang sudah direvisi</div>");
                }
            }?>
        <form action="<?= $action?>" method="post" enctype="multipart/form-data">
            <?php if(isset($data['id_laporan'])){ ?>
                <input type="hidden" name="id_laporan" value="<?= $data['id_laporan']?>">
                <input type="hidden" name="file_lama" value="<?= $data['file']?>">
            <?php } ?>
            <div class="form-group">
                <label for="judul_laporan" class="form-label">Judul Tugas Akhir :</label>
                <input type="text" name="judul_laporan" id="" class="form-control" value="<?= $data['judul_laporan'] ?>" <?= $disable?> required>
            </div>
            <div class="form-group">
                <label for="abstrak" class="form-label">Abstrak Tugas Akhir :</label>
                <textarea name="abstrak" class="form-control" id="" cols="30" rows="10" <?= $disable?> required><?= $data['abstrak'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="file" class="form-label">File :</label><br/>
                <label for="file" class="form-label alert alert-warning">Pastikan anda memasukkan link source code pada file laporan tugas akhir anda</label>
                <input type="file" name="file" id="" class="form-control" <?= $disable?>>
                <span><?= $data['file'] ?></span>
            </div>
            <button type="submit" class='btn btn-warning' name='submit'onclick="return confirm('Apakah Data yang dimasukkan sudah benar?')" value="upload" <?= $disable?>>Upload</button>
            <a href="index.php" class="btn btn-primary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>