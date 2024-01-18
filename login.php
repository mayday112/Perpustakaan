
<?php

require('koneksi.php');
require('fungsi.php');

session_start();

$error = '';
$validate = '';

if(isset($_SESSION['username'])) header('location: index.php');

if(isset($_POST['login'])){
    
    // print_r($_POST);
    $username = antiInjection($_POST['username']);

    $password =antiInjection($_POST['password']);
 
    if(!empty(trim($username)) && !empty(trim($password))){

        // Hanya admin yang aktif yg dapat login
        $query = "SELECT * FROM admin WHERE username = '$username' AND status = 'aktif';";
        $sql = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($sql);
        // echo $rows;

        if($rows != 0){

            $result = mysqli_fetch_assoc($sql);

            if(password_verify($password, $result['password'])){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $result['id_admin'];
                $_SESSION['role'] = "admin";
                $_SESSION['name'] = "admin";
                
    
                echo "silahkan masuk";
                
                header('location:index.php');
            }else{
                $error = 'Password salah!';      
            }
        } else {//jika tidak ditemukan username pada tabel admin 
            // Hanya mahasiswa yang aktif yg dapat login
            $query = "SELECT * FROM mhs WHERE nim = '$username' AND status IN('aktif', 'cuti') ;";
            $sql = mysqli_query($conn, $query);
            $rows = mysqli_num_rows($sql);
            if($rows != 0){
                $result = mysqli_fetch_assoc($sql);

                if(password_verify($password, $result['password'])){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $result['nim'];
                $_SESSION['role'] = $result['id_smt'] < 6 ? "mhs" : "mhs-ta";
                $_SESSION['name'] = $result['nama_mhs'];

                // echo ("silahkan masuk");

                header('location:index.php');

                } else {
                    $error = 'Password salah!';
                }
            } else {
                $error = 'User tidak ada!';
            }
        }
    } else {
        $error = 'Data tidak boleh kososng';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login2</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>

        body{
            background: gray;
        }

        section {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .form-container{
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 5px 5px 8px rgb(50,50,50);
            border: 1px solid lightgray;
        }

    </style>
</head>
<body>
        <section class="row justify-content-center">
            <form action="login.php" class="form-container" method="POST">
                <h4 class="text-center font-weight-bold">Sign-in</h4>
                <?php if($error != ''){?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                <?php } ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label for="InputPassword">Password</label>
                    <input type="password" name="password" id="Inputpassword" class="form-control" placeholder="Masukkan Password" required>
                    <?php if($validate != ''){?>
                        <p class="text-danger"><?php $validate; ?></p>
                    <?php } ?>
                </div>
                <button type="submit" name="login" value="login" class="btn btn-primary btn-block">Login</button>
            </form>
        </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>