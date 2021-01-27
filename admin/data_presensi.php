<?php
session_start();
include "../koneksi.php";
$db = new database();
$namaweb = $db->nama_web;
$iduser = $_SESSION['iduser'];
$nama_user = $_SESSION['nama_user'];
$username = $_SESSION['username'];
$jenis_user = $_SESSION['jenis'];

if(!isset($_SESSION['is_login_presensi'])){
	header("location:../login.php");
}

if(isset($_POST['delete']))
{
  $idpresensi = $_POST['id_data'];
  $pesan = $db->hapus_presensi($idpresensi);
  echo "<script>alert('Presensi ".$pesan." dihapus');</script>";
}

if(isset($_POST['deleteall']))
{
  $pesan = $db->hapus_semua_presensi($iduser);
  echo "<script>alert('Semua data presensi ".$pesan." dihapus');</script>";
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

        <title><?php echo $namaweb; ?> | Data Presensi</title>

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
                            <h1 class="page-header">Data Presensi</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Tabel Data Presensi
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Mapel</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Kelas</th>
                                                    <th>Absen</th>
                                                    <th>Waktu</th>
                                                    <th>Ringkasan Materi</th>
                                                    <th>Address</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php 
													$jmldata = $db->cek_tampil_presensi($iduser);
													if($jmldata!=0){
														$dataPresensi = $db->tampil_presensi($iduser);
														foreach($dataPresensi as $data){
															echo "<tr class='gradeA'>";
															echo "<td>$data[idpresensi]</td>";
															echo "<td>$data[nama_mapel]</td>";
															echo "<td>".ucwords(strtolower($data['nama_lengkap']))."</td>";
															echo "<td>$data[kelas]</td>";
															echo "<td>$data[no_absen]</td>";
															echo "<td>$data[waktu]</td>";
															echo "<td>$data[isi]</td>";
															echo "<td>$data[address]</td>"; ?>
															<td>
																<a class="btn btn-danger btn-flat" data-toggle="modal" data-target="#hapusModal" data-id="<?php echo $data['idpresensi']; ?>" data-nama="<?php echo $data['nama_lengkap']; ?>" data-mapel="<?php echo $data['nama_mapel']; ?>" data-waktu="<?php echo $data['waktu']; ?>" data-isi="<?php echo $data['isi']; ?>">Hapus</a>
															</td>
															<?php
															echo "</tr>";
														}
													}
												?>                                             
                                            </tbody>
                                        </table>
										<button type="button" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#hapusSemuaModal">Hapus Semua Data Presensi</button>
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
		<!-- awal modal hapus -->
      <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Presensi</h5>
          </div>
          <div class="modal-body">
          <form action="" method="post">
            <div class="form-group row">
            <label for="judul_data" class="col-sm-2 col-form-label">Mapel</label>
              
              <div class="col-sm-8">
              <p align="justify" id="hapus_mapel"></p>
              </div>
            </div>
            <div class="form-group row">
            <label for="waktu_data" class="col-sm-2 col-form-label">Waktu</label>
              <div class="col-sm-5">
              <p align="justify" id="hapus_waktu"></p>
              </div>
            </div>
			<div class="form-group row">
            <label for="isi_data" class="col-sm-2 col-form-label">Isi</label>
              <div class="col-sm-8">
              <p align="justify" id="hapus_isi"></p>
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
	  <!-- awal modal hapus semua -->
		  <div class="modal fade" id="hapusSemuaModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel_hapus" aria-hidden="true">
			<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
			  <div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel_hapus">Hapus Semua Presensi?</h5>
			  </div>
			  <div class="modal-body">
			  <form action="" method="post">
				<div class="form-group row">
				<label for="judul_data" class="col-sm-12 col-form-label">Apakah Anda yakin ingin menghapus semua data presensi?<br>Note : Data yang dihapus tidak bisa dikembalikan</label>
				  <input type="hidden" class="form-control" id="id_data" name="id_data">
				  <div class="col-sm-8">
				  <p align="justify" id="hapus_mapel"></p>
				  </div>
				</div>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-danger btn-flat" name="deleteall" type="submit">Yakin, Hapus</button>
				<button class="btn btn-secondary btn-flat pull-left" data-dismiss="hapusModal">Batal</button>
			  </form>
			  </div>
			</div>
			</div>
		  </div>
	    <!-- akhir modal hapus semua -->
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

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>
		<script type="text/javascript">
		  $('#hapusModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) 
			var idnya = button.data('id') 
			var nama = button.data('nama') 
			var mapel = button.data('mapel') 
			var waktu = button.data('waktu') 
			var isi = button.data('isi')
			var modal = $(this)
			modal.find('.modal-title').text('Hapus Presensi dari ' + nama + " ?")
			modal.find('.modal-body #id_data').val(idnya)
			$("p#hapus_mapel").text(mapel)
			$("p#hapus_waktu").text(waktu)
			$("p#hapus_isi").text(isi)
			
		  })
		</script>
    </body>
</html>