<?php
session_start();
include "koneksi.php";
$db = new database();
$namaweb = $db->nama_web;
if(isset($_SESSION['is_login_presensi'])){
  header('location:admin/index.php');
}

if(isset($_REQUEST['login'])){
  extract($_REQUEST);
  $pesan = $db->masuk($username,$password);
  if($pesan=="sukses"){
    header("location:admin/index.php");
  }else{
    header("location:login.php?pesan=".$pesan);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Login ke Sistem</title>

        <!-- Bootstrap Core CSS -->
        <link href="admin/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="admin/css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="admin/css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="admin/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Silakan masuk menggunakan akun Anda</h3>
                        </div>
						<?php 
							if(isset($_GET['pesan'])){
								if($_GET['pesan']=="gagal"){
									echo "<div class='alert alert-danger'>Username dan Password tidak sesuai !</div>";
								}else if($_GET['pesan']=="blokir"){
									echo "<div class='alert alert-danger'>Akun Anda saat  ini diblokir, silakan hubungi Admin !</div>";
								}
							}
						?>
                        <div class="panel-body">
                            <form role="form" action="" method="post" name="login">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                    </div>
									<button name="login" type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="admin/js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="admin/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="admin/js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="admin/js/startmin.js"></script>

    </body>
</html>
