<?php
session_start();
include "../koneksi.php";
$db = new database();
$namaweb = $db->nama_web;
$iduser = $_SESSION['iduser'];
$nama_user = $_SESSION['nama_user'];
$username = $_SESSION['username'];
$jenis_user = $_SESSION['jenis'];
$jumlah = $db->cek_jumlah_data($iduser);
$warna = array("primary","success","danger","info","dark");
if(!isset($_SESSION['is_login_presensi'])){
	header("location:../login.php");
}

if(isset($_POST['update_nama']))
{
    $iduser_ = $_POST['id_data_edit'];
    $jenis_edit_ = "N";
    $baru_ = $_POST['nama_data_edit'];
	
	$pesan = $db->update_profile($iduser_,$jenis_edit_,$baru_);
    if($pesan)
    {
      header("location:profile.php?pesan=".$pesan);
    }
}

if(isset($_POST['update_user']))
{
    $iduser_ = $_POST['id_data_edit'];
    $jenis_edit_ = "U";
    $baru_ = $_POST['user_data_edit'];
	
	$pesan = $db->update_profile($iduser_,$jenis_edit_,$baru_);
    if($pesan)
    {
      header("location:profile.php?pesan=".$pesan);
    }
}

if(isset($_POST['update_pass']))
{
    $iduser_ = $_POST['id_data_edit'];
    $jenis_edit_ = "P";
    $baru_ = $_POST['pass_data_edit'];
	
	$pesan = $db->update_profile($iduser_,$jenis_edit_,$baru_);
    if($pesan)
    {
      header("location:profile.php?pesan=".$pesan);
    }
}

if(isset($_GET['q'])){
	$db->keluar($iduser);
	header("location:../login.php");
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

        <title><?php echo $namaweb; ?> | Profile</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/startmin.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="css/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include "navigation.php"; ?>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Profile</h1>
							<?php
							if(isset($_GET['pesan'])){
								if($_GET['pesan']=="sukses_nama"){
									echo "<div class='alert alert-success' role='alert'>Nama Berhasil Diganti</div>";
								}else if($_GET['pesan']=="sukses_user"){
									echo "<div class='alert alert-success' role='alert'>Username Berhasil Diganti</div>";
								}else if($_GET['pesan']=="sukses_pass"){
									echo "<div class='alert alert-success' role='alert'>Password Berhasil Diganti</div>";
								}else if($_GET['pesan']=="gagal_nama"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Mengganti Nama</div>";
								}else if($_GET['pesan']=="user"){
									echo "<div class='alert alert-danger' role='alert'>Username Sudah Dipakai !</div>";
								}else if($_GET['pesan']=="gagal_user"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Mengganti Username</div>";
								}else if($_GET['pesan']=="gagal_pass"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Mengganti Password</div>";
								}else{
									echo "<div class='alert alert-danger' role='alert'>Pesan Tidak Diketahui</div>";
								}
							}
							?>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    
                    <div class="row">
                        <div class="col-lg-8">
                            
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-user fa-fw"></i> Profile User
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                   
								   <!-- isi -->
										<div class="form-group row">
										<label for="nama_data" class="col-sm-2 col-form-label">Nama</label>
										  <div class="col-sm-8">
										  <p align="justify"><b><?php echo $nama_user; ?></b></p>
										  </div>
										</div>
										<div class="form-group row">
										<label for="user_data" class="col-sm-2 col-form-label">Username</label>
										  <div class="col-sm-2">
										  <p align="justify"><b><?php echo $username; ?></b></p>
										  </div>
										</div>
											<button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#namaModal" data-id="<?php echo $iduser; ?>" data-nama="<?php echo $nama_user; ?>" data-user="<?php echo $username; ?>">Edit Nama</button>
											<button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#userModal" data-id="<?php echo $iduser; ?>" data-nama="<?php echo $nama_user; ?>" data-user="<?php echo $username; ?>">Edit Username</button>
											<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#passModal" data-id="<?php echo $iduser; ?>" data-nama="<?php echo $nama_user; ?>" data-user="<?php echo $username; ?>">Ganti Password</button>
								   <!-- akhir -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-8 -->
                        
                        <!-- /.col-lg-4 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
		<!-- awal modal edit nama -->
		<div class="modal fade" id="namaModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_edit" aria-hidden="true">
		  <div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel_edit">Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="post">
				  <div class="form-group row">
				<label for="judul_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Nama User</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="hidden" class="form-control" id="id_data_edit" name="id_data_edit" autocomplete="off">
				  <input type="text" class="form-control" id="nama_data_edit" name="nama_data_edit" autocomplete="off" required>
				  </div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-warning" name="update_nama" type="submit">Update</button>
				</form>
			  </div>
			</div>
		  </div>
		 </div>
		</div>
		<!-- akhir modal edit nama -->
		<!-- awal modal edit user -->
		<div class="modal fade" id="userModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_edit" aria-hidden="true">
		  <div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel_edit">Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="post">
				  <div class="form-group row">
				<label for="judul_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Username</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="hidden" class="form-control" id="id_data_edit" name="id_data_edit" autocomplete="off">
				  <input type="text" class="form-control" id="user_data_edit" name="user_data_edit" autocomplete="off" required>
				  </div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-warning" name="update_user" type="submit">Update</button>
				</form>
			  </div>
			</div>
		  </div>
		 </div>
		</div>
		<!-- akhir modal edit user -->
		<!-- awal modal edit pass -->
		<div class="modal fade" id="passModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_edit" aria-hidden="true">
		  <div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel_edit">Edit</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="post">
				  <div class="form-group row">
				<label for="judul_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Password Baru</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="hidden" class="form-control" id="id_data_edit" name="id_data_edit" autocomplete="off">
				  <input type="text" class="form-control" id="pass_data_edit" name="pass_data_edit" autocomplete="off" required>
				  </div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-warning" name="update_pass" type="submit">Update</button>
				</form>
			  </div>
			</div>
		  </div>
		 </div>
		</div>
		<!-- akhir modal edit pass -->
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>

	<script type="text/javascript">
	
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				  $(this).remove(); 
				});
			  }, 5000);
		
			$('#namaModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) 
			  var idnya = button.data('id') 
			  var nama = button.data('nama') 
			  
			  var modal = $(this)
			  modal.find('.modal-title').text('Edit Nama')
			  modal.find('.modal-body #id_data_edit').val(idnya)
			  modal.find('.modal-body #nama_data_edit').val(nama)
			  
			})
			
			$('#userModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) 
			  var idnya = button.data('id') 
			  var user = button.data('user') 
			  
			  var modal = $(this)
			  modal.find('.modal-title').text('Edit Username')
			  modal.find('.modal-body #id_data_edit').val(idnya)
			  modal.find('.modal-body #user_data_edit').val(user)
			  
			})
			
			$('#passModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) 
			  var idnya = button.data('id') 
			  var pass = button.data('pass') 
			  
			  var modal = $(this)
			  modal.find('.modal-title').text('Edit Password')
			  modal.find('.modal-body #id_data_edit').val(idnya)
			  
			  
			})
		  
		</script>
    </body>
</html>