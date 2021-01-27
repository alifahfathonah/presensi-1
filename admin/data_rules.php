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

if(!isset($_SESSION['is_login_presensi'])){
	header("location:../login.php");
}

if(isset($_POST['input']))
{
    $nama_mapel = $_POST['nama_data'];
    $tingkat = $_POST['tingkat_data'];
    $hari = $_POST['hari_data'];
    $awal = $_POST['awal_data'];
    $akhir = $_POST['akhir_data'];
	$pesan = $db->input_rule($iduser,$tingkat,$nama_mapel,$hari,$awal,$akhir);
    if($pesan)
    {
		header("location:data_rules.php?pesan=".$pesan);
    }
}

if(isset($_POST['update']))
{
    $idrule = $_POST['id_data_edit'];
    $tingkat = $_POST['tingkat_data_edit'];
    $nama_mapel = $_POST['nama_data_edit'];
    $hari = $_POST['hari_data_edit'];
    $awal = $_POST['awal_data_edit'];
    $akhir = $_POST['akhir_data_edit'];
	$pesan = $db->update_rule($idrule,$tingkat,$nama_mapel,$hari,$awal,$akhir);
    if($pesan)
    {
      header("location:data_rules.php?pesan=".$pesan);
    }
}

if(isset($_POST['delete']))
{
    $idrule = $_POST['id_data'];
	$pesan = $db->hapus_rule($idrule);
	if($pesan)
    {
      header("location:data_rules.php?pesan=".$pesan);
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

        <title><?php echo $namaweb; ?> | Data Rules</title>

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
                            <h1 class="page-header">Data Rules</h1>
							<?php
							if(isset($_GET['pesan'])){
								if($_GET['pesan']=="sukses"){
									echo "<div class='alert alert-success' role='alert'>Rule Baru Berhasil Ditambahkan</div>";
								}else if($_GET['pesan']=="sukses_edit"){
									echo "<div class='alert alert-success' role='alert'>Rule Berhasil Diedit</div>";
								}else if($_GET['pesan']=="sukses_hapus"){
									echo "<div class='alert alert-success' role='alert'>Rule Berhasil Dihapus</div>";
								}else if($_GET['pesan']=="gagal"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Menambahkan Rule Baru</div>";
								}else if($_GET['pesan']=="gagal_edit"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Memperbarui Data Rule</div>";
								}else if($_GET['pesan']=="gagal_hapus"){
									echo "<div class='alert alert-danger' role='alert'>Gagal Menghapus Rule</div>";
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
									<a class="btn btn-primary btn-flat" data-toggle="modal" data-target="#tambahModal">Tambah Data Rule</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tingkat</th>
                                                    <th>Mapel</th>
                                                    <th>Hari</th>
                                                    <th>Mulai</th>
                                                    <th>Selesai</th>
                                                    <th>Link</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
													$jmlPresensi = $db->cek_tampil_rules($iduser);
													if($jmlPresensi!=0){
														$dataPresensi = $db->tampil_rules($iduser);
														foreach($dataPresensi as $data){
															$cekhari = $data['hari'];
															switch($cekhari){
																case 1: $hari = "Senin";
																	break;
																case 2: $hari = "Selasa";
																	break;
																case 3: $hari = "Rabu";
																	break;
																case 4: $hari = "Kamis";
																	break;
																case 5: $hari = "Jumat";
																	break;
																case 6: $hari = "Sabtu";
																	break;
																case 7: $hari = "Minggu";
																	break;
																default : $hari = "None";
																	break;
															}
															echo "<tr class='gradeA'>";
															echo "<td>$data[idrule]</td>";
															echo "<td>$data[tingkat]</td>";
															echo "<td>$data[nama_mapel]</td>";
															echo "<td>$hari</td>";
															echo "<td>$data[awal]</td>";
															echo "<td>$data[akhir]</td>";?>
															<td>
																<a href="<?php echo $alamat.$data['idrule']; ?>" target="_blank"><?php echo $alamat.$data['idrule'];?></a>
																<a class="btn btn-success btn-flat" href="whatsapp://send?text=<?php echo $alamat.$data['idrule']; ?>">Bagikan ke WhatsApp</a>
															</td>
															<td>
																<a class="btn btn-warning btn-flat" data-toggle="modal" data-target="#editModal" data-id_edit="<?php echo $data['idrule']; ?>" data-tingkat_edit="<?php echo $data['tingkat']; ?>" data-mapel_edit="<?php echo $data['nama_mapel']; ?>" data-hari_edit="<?php echo $data['hari']; ?>" data-awal_edit="<?php echo $data['awal']; ?>" data-akhir_edit="<?php echo $data['akhir']; ?>">Edit</a>
																<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#hapusModal" data-id="<?php echo $data['idrule']; ?>" data-tingkat="<?php echo $data['tingkat']; ?>" data-mapel="<?php echo $data['nama_mapel']; ?>" data-hari="<?php echo $hari; ?>" data-waktu="<?php echo $data['awal']." - ".$data['akhir']; ?>">Hapus</button>
															</td>
															<?php
															echo "</tr>";
														}
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
				<h5 class="modal-title" id="exampleModalLabel_tambah">Tambah Rule</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<form action="" method="post">
				  <div class="form-group col-lg-12 col-md-6 col-sm-4">
					<label for="mapel_data" class="col-form-label">Nama Mata Pelajaran</label>
					
					<input type="text" class="form-control" id="nama_data" name="nama_data" autocomplete="off">
				  </div>
				  <div class="form-row">
					  <div class="form-group col-lg-2 col-md-2 col-sm-2">
						<label for="tingkat_data">Tingkat</label>
						<select name="tingkat_data" id="tingkat_data" class="form-control">
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					  </div>
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="hari_data">Hari</label>
						<select name="hari_data" id="hari_data" class="form-control">
							<option value="1">Senin</option>
							<option value="2">Selasa</option>
							<option value="3">Rabu</option>
							<option value="4">Kamis</option>
							<option value="5">Jumat</option>
							<option value="6">Sabtu</option>
							<option value="7">Minggu</option>
						</select>
					  </div>
				  </div>
				  <div class="form-row">
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="mulai_data">Mulai</label>
							<input type="time" name="awal_data" id="awal_data" class="form-control"/>
					  </div>
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="akhir_data">Selesai</label>
							<input type="time" name="akhir_data" id="akhir_data" class="form-control"/>
					  </div>
				  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button class="btn btn-primary" name="input" type="submit">Simpan</button>
				</form>
			  </div>
			</div>
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
				  <div class="form-group col-lg-12 col-md-6 col-sm-4">
					<label for="mapel_data" class="col-form-label">Nama Mata Pelajaran</label>
					<input type="hidden" class="form-control" id="id_data_edit" name="id_data_edit">
					<input type="text" class="form-control" id="nama_data_edit" name="nama_data_edit">
				  </div>
				  <div class="form-row">
					  <div class="form-group col-lg-2 col-md-2 col-sm-2">
						<label for="tingkat_data">Tingkat</label>
						<select name="tingkat_data_edit" id="tingkat_data_edit" class="form-control">
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>
					  </div>
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="hari_data">Hari</label>
						<select name="hari_data_edit" id="hari_data_edit" class="form-control">
							<option value="1">Senin</option>
							<option value="2">Selasa</option>
							<option value="3">Rabu</option>
							<option value="4">Kamis</option>
							<option value="5">Jumat</option>
							<option value="6">Sabtu</option>
							<option value="7">Minggu</option>
						</select>
					  </div>
				  </div>
				  <div class="form-row">
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="mulai_data">Mulai</label>
							<input type="time" name="awal_data_edit" id="awal_data_edit" class="form-control"/>
					  </div>
					  <div class="form-group col-lg-3 col-md-3 col-sm-2">
						<label for="akhir_data">Selesai</label>
							<input type="time" name="akhir_data_edit" id="akhir_data_edit" class="form-control"/>
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
			  <h5 class="modal-title" id="exampleModalLabel_hapus">Hapus Rules</h5>
			  </div>
			  <div class="modal-body">
			  <form action="" method="post">
				<div class="form-group row">
				<label for="judul_data" class="col-sm-2 col-form-label">Mapel</label>
				  <input type="hidden" class="form-control" id="id_data" name="id_data">
				  <div class="col-sm-8">
				  <p align="justify" id="hapus_mapel"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="tingkat_data" class="col-sm-2 col-form-label">Tingkat</label>
				  <div class="col-sm-2">
				  <p align="justify" id="hapus_tingkat"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="waktu_data" class="col-sm-2 col-form-label">Waktu</label>
				  <div class="col-sm-6">
				  <p align="justify" id="hapus_waktu"></p>
				  </div>
				</div>
				<div class="form-group row">
				<label for="isi_data" class="col-sm-2 col-form-label">Hari</label>
				  <div class="col-sm-4">
				  <p align="justify" id="hapus_hari"></p>
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
			  var nama = button.data('mapel_edit') 
			  var hari = button.data('hari_edit') 
			  var tingkat = button.data('tingkat_edit')
			  var awal = button.data('awal_edit')
			  var akhir = button.data('akhir_edit')
			  
			  var modal = $(this)
			  modal.find('.modal-title').text('Edit Data ' + idnya)
			  modal.find('.modal-body #id_data_edit').val(idnya)
			  modal.find('.modal-body #nama_data_edit').val(nama)
			  modal.find('.modal-body #tingkat_data_edit').val(tingkat)
			  modal.find('.modal-body #hari_data_edit').val(hari)
			  modal.find('.modal-body #awal_data_edit').val(awal)
			  modal.find('.modal-body #akhir_data_edit').val(akhir)
			  
			})
		
		  $('#hapusModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) 
			var idnya = button.data('id') 
			var tingkat = button.data('tingkat') 
			var mapel = button.data('mapel') 
			var waktu = button.data('waktu') 
			var hari = button.data('hari')
			var modal = $(this)
			modal.find('.modal-title').text('Hapus Rule ' + mapel + " ?")
			modal.find('.modal-body #id_data').val(idnya)
			$("p#hapus_mapel").text(mapel)
			$("p#hapus_tingkat").text(tingkat)
			$("p#hapus_waktu").text(waktu)
			$("p#hapus_hari").text(hari)
			
		  })
		</script>
    </body>
</html>