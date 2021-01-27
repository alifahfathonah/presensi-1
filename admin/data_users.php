<?php
session_start();
include "../koneksi.php";
$db = new database();
$namaweb = $db->nama_web;
$alamat = $db->alamat_presensi;
$iduser = $_SESSION['iduser'];
$nama_user = $_SESSION['nama_user'];
$username = $_SESSION['username'];
$jenis_user = $_SESSION['jenis'];

if($jenis_user=="U"){
	header("location:index.php");
}

if(!isset($_SESSION['is_login_presensi'])){
	header("location:../login.php");
}

if(isset($_POST['input']))
{
    $nama = $_POST['nama_data'];
    $user_ = $_POST['user_data'];
    $pass_ = $_POST['password_data'];
    $jenis_ = $_POST['jenis_data'];
	
    $pesan = $db->input_user($nama,$user_,$pass_,$jenis_);
	if($pesan)
    {
	  header("location:data_users.php?pesan=".$pesan);
    }
}

if(isset($_POST['update']))
{
    $iduser_ = $_POST['id_data_edit'];
    $nama_ = $_POST['nama_data_edit'];
    $user_ = $_POST['user_data_edit'];
    $jenis_ = $_POST['jenis_data_edit'];
    $status_ = $_POST['status_data_edit'];
	
	$pesan = $db->update_user($iduser_,$nama_,$user_,$jenis_,$status_);
    if($pesan)
    {
      header("location:data_users.php?pesan=".$pesan);
    }
}

if(isset($_POST['reset_']))
{
    $iduser_ = $_POST['id_data_reset'];
    $pass_ = $_POST['password_data_reset'];
	
	$pesan = $db->reset_pass($iduser_,$pass_);
    if($pesan)
    {
      header("location:data_users.php?pesan=".$pesan);
    }
}

if(isset($_POST['delete']))
{
	$iduser__ = $_POST['id_data'];
	$pesan = $db->hapus_user($iduser__);
	if($pesan)
	{
	  header("location:data_users.php?pesan=".$pesan);
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

        <title><?php echo $namaweb; ?> | Data Users</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="css/metisMenu.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link href="css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="css/dataTables/dataTables.responsive.css" rel="stylesheet">

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
                            <h1 class="page-header">Data Users</h1>
							<?php
							if(isset($_GET['pesan'])){
								if($_GET['pesan']=="user"){
									echo "<div class='alert alert-danger' role='alert'>Username Sudah Dipakai !</div>";
								}else if($_GET['pesan']=="sukses"){
									echo "<div class='alert alert-success' role='alert'>User Baru Berhasil Ditambahkan</div>";
								}else if($_GET['pesan']=="sukses_edit"){
									echo "<div class='alert alert-success' role='alert'>User Berhasil Diedit</div>";
								}else if($_GET['pesan']=="sukses_hapus"){
									echo "<div class='alert alert-success' role='alert'>User Berhasil Dihapus</div>";
								}else if($_GET['pesan']=="sukses_reset"){
									echo "<div class='alert alert-success' role='alert'>User Berhasil Direset</div>";
								}else if($_GET['pesan']=="gagal"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Menambahkan User Baru</div>";
								}else if($_GET['pesan']=="gagal_edit"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Memperbarui Data User</div>";
								}else if($_GET['pesan']=="gagal_hapus"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Menghapus User</div>";
								}else if($_GET['pesan']=="gagal_reset"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Reset User</div>";
								}else{
									echo "<div class='alert alert-danger' role='alert'>Pesan Tidak Diketahui</div>";
								}
							}
							?>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
									<a class="btn btn-primary btn-flat" data-toggle="modal" data-target="#tambahModal">Tambah User</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
													<th>Nama</th>
													<th>Username</th>
													<th>Last Login</th>
													<th>Jenis User</th>
													<th>Status</th>
													<th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
													$dataUsers = $db->tampil_users();
													$no=1;
													foreach($dataUsers as $data){
														$cekwaktu = $data['lastlogin'];
														if($cekwaktu=="0000-00-00 00:00:00" || is_null($cekwaktu)){
															$waktu="Belum Pernah Login";
														}else{
															$waktu = $db->time2str($data['lastlogin']);
														}
														$cekjenis = $data['jenis'];
														if($cekjenis=="A"){
															$jen = "Admin";
														}else if($cekjenis=="U"){
															$jen = "User";
														}else{
															$jen = "Unknown";
														}
														$cekstatus = $data['status'];
														if($cekstatus=="1"){
															$statusnya="Diizinkan";
														}else{
															$statusnya="Diblokir";
														}
														echo "<tr class='gradeA'>";
														echo "<td>$no</td>";
														echo "<td>$data[nama]</td>";
														echo "<td>$data[username]</td>";
														echo "<td>$waktu</td>";
														echo "<td>$jen</td>";
														echo "<td>$statusnya</td>";?>
														<td>
															<a class="btn btn-warning btn-flat" data-toggle="modal" data-target="#editModal" data-id_edit="<?php echo $data['iduser']; ?>" data-user_edit="<?php echo $data['username']; ?>" data-nama_edit="<?php echo $data['nama']; ?>" data-pass_edit="<?php echo $data['password']; ?>" data-jenis_edit="<?php echo $data['jenis']; ?>" data-status_edit="<?php echo $data['status']; ?>">Edit</a>
															<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#hapusModal" data-id="<?php echo $data['iduser']; ?>" data-nama="<?php echo $data['nama']; ?>" data-user="<?php echo $data['username']; ?>" data-jenis="<?php echo $jen; ?>" data-last="<?php echo $waktu; ?>"data-terdaftar="<?php echo $data['terdaftar']; ?>" data-status="<?php echo $statusnya; ?>">Hapus</button>
															<button type="button" class="btn btn-flat" data-toggle="modal" data-target="#resetModal" data-id="<?php echo $data['iduser']; ?>" data-nama="<?php echo $data['nama']; ?>" data-user="<?php echo $data['username']; ?>">Reset Password</button>
														</td>
														<?php
														$no++;
														echo "</tr>";
													}
												?>                                             
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
		<!-- awal modal tambah -->
		<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_tambah" aria-hidden="true">
		  <div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel_tambah"><b>Tambah User</b></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			<form action="" method="post">
			  <div class="modal-body">
				<div class="form-group row">
				<label for="nama_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Nama User</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="text" class="form-control" id="nama_data" name="nama_data" autocomplete="off" required>
				  </div>
				</div>
				<div class="form-group row">
				<label for="user_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Username</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="text" class="form-control" id="user_data" name="user_data" autocomplete="off" required>
				  </div>
				</div>
				<div class="form-group row">
				<label for="password_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Password</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="text" class="form-control" id="password_data" name="password_data" autocomplete="off" required>
				  </div>
				</div>
				<div class="form-group row">
				<label for="jenis_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Jenis User</label>
				  <div class="col-lg-4 col-md-4 col-sm-4">
					<select name="jenis_data" id="jenis_data" class="form-control">
						<option value="A">Admin</option>
						<option value="U">User</option>
					</select>
				  </div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-primary" name="input" type="submit">Simpan</button>
			  </div>
			</form>
		  </div>
		 </div>
		</div>
		<!-- akhir modal tambah -->
		<!-- awal modal edit -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_edit" aria-hidden="true">
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
				<div class="form-group row">
				<label for="tingkat_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Username</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="text" class="form-control" id="user_data_edit" name="user_data_edit" autocomplete="off" required>
				  </div>
				</div>
				<div class="form-group row">
				<label for="jenis_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Jenis User</label>
				  <div class="col-lg-4 col-md-4 col-sm-4">
					<select name="jenis_data_edit" id="jenis_data_edit" class="form-control">
						<option value="A">Admin</option>
						<option value="U">User</option>
					</select>
				  </div>
				</div>
				<div class="form-group row">
				<label for="status_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Status User</label>
				  <div class="col-lg-4 col-md-4 col-sm-4">
					<select name="status_data_edit" id="status_data_edit" class="form-control">
						<option value="1">Diizinkan</option>
						<option value="0">Diblokir</option>
					</select>
				  </div>
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-warning" name="update" type="submit">Update</button>
				</form>
			  </div>
			</div>
		  </div>
		 </div>
		</div>
		<!-- akhir modal edit -->
		<!-- awal modal hapus -->
		  <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_hapus" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel_hapus">Hapus User</h5>
			  </div>
			  <div class="modal-body">
			  <form action="" method="post">
				<div class="form-group row">
				<label for="nama_data" class="col-sm-2 col-form-label">Nama</label>
				  <input type="hidden" class="form-control" id="id_data" name="id_data">
				  <div class="col-sm-8">
				  <p align="justify" id="hapus_nama"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="user_data" class="col-sm-2 col-form-label">Username</label>
				  <div class="col-sm-2">
				  <p align="justify" id="hapus_user"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="terdaftar_data" class="col-sm-2 col-form-label">Terdaftar</label>
				  <div class="col-sm-6">
				  <p align="justify" id="hapus_terdaftar"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="last_data" class="col-sm-2 col-form-label">Last Login</label>
				  <div class="col-sm-4">
				  <p align="justify" id="hapus_last"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="jenis_data" class="col-sm-2 col-form-label">Jenis User</label>
				  <div class="col-sm-4">
				  <p align="justify" id="hapus_jenis"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="status_data" class="col-sm-2 col-form-label">Status</label>
				  <div class="col-sm-4">
				  <p align="justify" id="hapus_status"></p>
				  </div>
				</div>
				
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-danger btn-flat" name="delete" type="submit">Hapus</button>
				<button class="btn btn-secondary btn-flat pull-left" data-dismiss="hapusModal">Batal</button>
			  </form>
			  </div>
			</div>
			</div>
		  </div>
	    <!-- akhir modal hapus -->
		<!-- awal modal reset -->
		  <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_reset" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel_reset">Reset User</h5>
			  </div>
			  <div class="modal-body">
			  <form action="" method="post">
				<div class="form-group row">
				<label for="nama_data" class="col-sm-2 col-form-label">Nama</label>
				  <input type="hidden" class="form-control" id="id_data_reset" name="id_data_reset">
				  <div class="col-sm-8">
				  <p align="justify" id="reset_nama"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="user_data" class="col-sm-2 col-form-label">Username</label>
				  <div class="col-sm-2">
				  <p align="justify" id="reset_user"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="password_data" class="col-lg-12 col-md-12 col-sm-4 col-form-label">Password Baru</label>
				  <div class="col-lg-12 col-md-12 col-sm-8">
				  <input type="text" class="form-control" id="password_data_reset" name="password_data_reset" autocomplete="off" required>
				  </div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-danger btn-flat" name="reset_" type="submit">Simpan</button>
				<button class="btn btn-secondary btn-flat pull-left" data-dismiss="modal">Batal</button>
			  </form>
			  </div>
			</div>
			</div>
		  </div>
	    <!-- akhir modal reset -->
		
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="js/dataTables/jquery.dataTables.min.js"></script>
        <script src="js/dataTables/dataTables.bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>
		
		<!-- Time Picker -->
        
        <script src="js/bootstrap-timepicker.js"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
			
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				  $(this).remove(); 
				});
			  }, 5000);
        </script>
		
		<script type="text/javascript">
		
			$('#editModal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) 
			  var idnya = button.data('id_edit') 
			  var user = button.data('user_edit') 
			  var nama = button.data('nama_edit') 
			  
			  var jenis = button.data('jenis_edit')
			  var status = button.data('status_edit')
			  
			  var modal = $(this)
			  modal.find('.modal-title').text('Edit Data ' + nama)
			  modal.find('.modal-body #id_data_edit').val(idnya)
			  modal.find('.modal-body #user_data_edit').val(user)
			  modal.find('.modal-body #nama_data_edit').val(nama)
			  
			  modal.find('.modal-body #jenis_data_edit').val(jenis)
			  modal.find('.modal-body #status_data_edit').val(status)
			  
			})
		
		  $('#hapusModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) 
			var idnya = button.data('id') 
			var nama = button.data('nama') 
			var user = button.data('user') 
			var terdaftar = button.data('terdaftar') 
			var last = button.data('last')
			var jenis = button.data('jenis')
			var status = button.data('status')
			var modal = $(this)
			modal.find('.modal-title').text('Hapus User ' + nama + " ?")
			modal.find('.modal-body #id_data').val(idnya)
			$("p#hapus_nama").text(nama)
			$("p#hapus_user").text(user)
			$("p#hapus_terdaftar").text(terdaftar)
			$("p#hapus_last").text(last)
			$("p#hapus_jenis").text(jenis)
			$("p#hapus_status").text(status)
			
		  })
		  
		  $('#resetModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) 
			var idnya = button.data('id') 
			var nama = button.data('nama') 
			var user = button.data('user') 
			var modal = $(this)
			modal.find('.modal-title').text('Reset Password ' + nama + " ?")
			modal.find('.modal-body #id_data_reset').val(idnya)
			$("p#reset_nama").text(nama)
			$("p#reset_user").text(user)
			
			
		  })
		</script>
    </body>
</html>