<?php 

require 'fungsi.php';

session_start();

if($_SESSION['role'] != 'admin') header("location:index.php");

$msg = isset($_GET['msg']) ? $_GET['msg'] : null;
$halaman = "Upload Buku";
$data = [
    "id_buku" => null,
    "judul_buku" => null,
    "dekripsi" => null,
    "pengarang" => null,
    "jenis_buku" => null,
    "id_admin" => null,
    "file" => null,
];

if(isset($_GET['id_buku'])){
    $id_buku = antiInjection($_GET['id_buku']);
    $halaman = "Edit Buku";
    $query = "SELECT * FROM buku WHERE id_buku = '$id_buku';";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);
}

// var_dump($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
    <title><?= $halaman ?></title>
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
    <!-- <br/> -->
<!-- ini halaman tambah buku. hanya admin yang dapat mengakses halaman ini -->
    <div class="container">
        <form action="<?= ($halaman == "Upload Buku") ? "simpan-buku-proses.php" : "simpan-edit-buku.php" ?>" method="post" enctype="multipart/form-data">
            <?php if($halaman == "Edit Buku") { ?> 
                <input type="hidden" name="id_buku" value="<?= $id_buku ?>">
                <input type="hidden" name="file_lama" value="<?= $data['file']?>">
                <?php } ?>
            <div class="mb-3">
                <label for="judul_buku" class="form-label">Judul : </label>
                <input type="text" name="judul_buku" id="" class="form-control" value="<?= $data['judul_buku'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="deksripsi" class="form-label">Deksripsi : </label>
                <textarea name="deskripsi" id="" cols="140" rows="10" required><?= isset($data['deskripsi']) ? $data['deskripsi'] : "" ?></textarea>
            </div>
            <div class="mb-3">
                <label for="pengarang" class="form-label">Pengarang : </label>
                <input type="text" name="pengarang" id="" class="form-control" value="<?= $data['pengarang'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_buku" class="form-label">Jenis Buku : </label>
                <select name="jenis_buku" id="" class="form-select" required>
                    <option value="" selected>Pilih File Buku</option>
                    <option value="Buku Bacaan" <?= active_select_button("Buku Bacaan", $data['jenis_buku'])?>>Buku Bacaan</option>
                    <option value="Buku Ajar(Diktat)" <?= active_select_button("Buku Ajar(Diktat)", $data['jenis_buku'])?>>Buku Ajar(Diktat)</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File buku : </label>
                <input type="file" name="file" id="file-buku" >
                <span id="file-name-display"><?= isset($data['file']) ? "File : ". $data['file'] : ""?></span>
            </div>
            <?php
                if(isset($msg)) echo "<div class='alert alert-danger'>$msg</div>";
            ?>
            <button type="submit" class="btn btn-warning" name="upload" value="upload">Upload</button>
            <a href="index.php" class="btn btn-primary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
</body>
</html>
