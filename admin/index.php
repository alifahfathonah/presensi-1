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

        <title><?php echo $namaweb; ?> | Dashboard</title>

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
                            <h1 class="page-header">Dashboard</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-pencil fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $jumlah['presensi']; ?></div>
                                            <div><?php echo $jumlah['presensi_hari_ini']; ?> Presensi Hari Ini</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="data_presensi.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-tasks fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $jumlah['rules']; ?></div>
                                            <div>Rules</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="data_rules.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
						<?php if($jenis_user=="A"){ ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $jumlah['users']; ?></div>
                                            <div>User</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="data_users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
						<?php } ?>
                        
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-8">
                            
                            <!-- /.panel -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-clock-o fa-fw"></i> Presensi Timeline
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <ul class="timeline">
									<?php 
										$cekjmldata = $db->cek_tampil_presensi_timeline($iduser);
										if($cekjmldata!=0){
											$timeline_presensi = $db->tampil_presensi_timeline(36,$iduser);
											$no=1;
											foreach($timeline_presensi as $data){
												$waktu = $db->time2str($data['waktu']);
												$acak = $no%5;
												$warnanya = $warna[$acak];
												if($no%2==1){
													echo "<li class='timeline'>";
												}else{
													echo "<li class='timeline-inverted'>";
												}
												echo "<div class='timeline-badge $warnanya'><i class='fa'></i>";
												echo "</div>";
												echo "<div class='timeline-panel'>";
												echo "<div class='timeline-heading'>";
												echo "<h4 class='timeline-title'>$data[nama_lengkap]</h4>";
												echo "<p>";
												echo "<small class='text-muted'><i class='fa fa-clock-o'></i> $waktu via $data[address]";
												echo "</small>";
												echo "</p>";
												echo "</div>";
												echo "<div class='timeline-body'>";
												echo "<p>$data[isi]";
												echo "</p>";
												echo "<p align='right'>$data[kelas] - $data[no_absen]";
												echo "</p>";
												echo "</div>";
												echo "</div>";
												echo "</li>";
												$no++;
											}
										}else{echo "Data Kosong";}
									?>
                                    </ul>
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
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="js/startmin.js"></script>

    </body>
</html>
