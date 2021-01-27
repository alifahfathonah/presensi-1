<?php
session_start();
include "koneksi.php";
$db = new database();
$lokasi_gambar = $db->gambar_artikel;
$namaweb = $db->nama_web;
$alamat = $db->get_ip();
$idrule = $_GET['rule'];
	if(is_null($idrule)){
		header("location:index.php?rule=salah");
	}else{
		if($idrule!='salah'){
			$jml = $db->cek_idrule($idrule);
			if ($jml != 0){
				$cekid="ok";
				$data_cek = $db->cek_data($idrule);
				$mapel = $data_cek['nama_mapel'];
				$hari = $data_cek['hari'];
				$hariini= date("N");
				$awal = $data_cek['awal'];
				$saatini = date("H:i"); 
				$akhir = $data_cek['akhir'];
			}else{
				$mapel = "Kosong";
				$cekid = "kosong";
			}
		}else{
			$cekid="salah";
		}
	}
	
	if(isset($_POST['input_presensi']))
	{
		$nama 	= strtoupper($_POST['nama']);
		$absen 	= $_POST['noabsen'];
		$kelas 	= $_POST['kelas'];
		$waktu 	= $_POST['waktu'];
		$isi 	= $_POST['isi'];
		$address = $alamat; 
		$simpan_presensi = $db->input_presensi($idrule,$nama,$absen,$kelas,$waktu,$isi,$address);
			echo '<script language="javascript">';
			echo 'alert("Presensi Anda Berhasil Dikirim")';
			echo '</script>';
	}
	
	if(isset($_POST['input_idrule']))
	{
		$idrulenya 	= $_POST['idrule'];
		if(!is_null($idrulenya)){
			header("location:index.php?rule=".$idrulenya);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Presensi - <?php if($cekid=="ok"){ echo $mapel;}else{echo "Salah";} ?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- site icons -->
<link rel="icon" href="assets/images/fevicon/fevicon.png" type="image/gif" />
<!-- bootstrap css -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<!-- Site css -->
<link rel="stylesheet" href="assets/css/style.css" />
<!-- responsive css -->
<link rel="stylesheet" href="assets/css/responsive.css" />
<!-- colors css -->
<link rel="stylesheet" href="assets/css/colors1.css" />
<!-- custom css -->
<link rel="stylesheet" href="assets/css/custom.css" />
<!-- wow Animation css -->
<link rel="stylesheet" href="assets/css/animate.css" />
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body id="default_theme" class="it_service blog">
<!-- loader -->
<div class="bg_load"> <img class="loader_animation" src="assets/images/loaders/loader_1.png" alt="#" /> </div>
<!-- end loader -->

<!-- inner page banner -->
<div id="inner_banner" class="section inner_banner_section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="full">
          <div class="title-holder">
            <div class="title-holder-cell text-left">
              <h1 class="page-title">Presensi</h1>
              <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Presensi <?php if($cekid=="ok"){ echo $mapel;}else{echo "-";} ?></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end inner page banner -->
<div class="section padding_layout_1">
  <div class="container">
    <div class="row">
      <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12"></div>
      <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
          <div class="full">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="main_heading text_align_center">
			  <h3><?php if($cekid=="ok"){ echo "Presensi Mata Pelajaran ".$mapel;} ?></h3>
              </div>
            </div>
            <?php if($cekid=="ok"){ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contant_form">
              <?php 
				if($hari==$hariini){
					if($awal<=$saatini && $akhir>=$saatini) {
			  ?>
			  <div>
				<h3>Guru : <?php echo $data_cek['nama']; ?></h3>
				<h3>Waktu Presensi : <?php echo $awal." - ".$akhir; ?> WIB</h3>
			  </div>
              <div class="form_section">
                <form class="form_contant" action="" method="POST">
                  <fieldset>
                  <div class="row">
                    <div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <input class="field_custom" placeholder="Nama Lengkap" maxlength="40" type="text" name="nama" autocomplete="off" required>
                    </div>
					<div class="field col-lg-2 col-md-2 col-sm-1 col-xs-1">
                      <input class="field_custom" placeholder="No Absen" type="number" min="1" max="36" name="noabsen" autocomplete="off" required>
                    </div>
					<div class="field col-lg-6 col-md-6 col-sm-4 col-xs-4">
                      <input class="field_custom" placeholder="Kelas" maxlength="15" type="text" name="kelas" autocomplete="off" required>
                    </div>
					<div class="field col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <input class="field_custom" placeholder="Waktu Presensi" type="hidden" value="<?php echo date("Y-m-d H:i:s") ?>" readonly name="waktu">
                    </div>
                    <div class="field col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <textarea class="field_custom" maxlength="200" name="isi" placeholder="Ringkasan Materi atau Kegiatan Kalian Hari Ini (maks 200 karakter)" required></textarea>
                    </div>
                    <div class="center"><button type="submit" name="input_presensi" id="input_presensi" class="btn btn-primary btn-flat">Kirim</button></div>
                  </div>
                  </fieldset>
                </form>
              </div>
			  <?php
					}else{
						echo "<div class='main_heading text_align_center'>";
						echo "<h3>Waktu Presensi Tidak Berlaku, Silakan Kembali Lagi Nanti Pada :</h3>";
						echo "<h3>Pukul $awal - $akhir WIB</h3>";
						echo "</div>";
					}
				}else{
					$cekhari = $hari;
					switch($cekhari){
						case 1: $harinya = "Senin";
							break;
						case 2: $harinya = "Selasa";
							break;
						case 3: $harinya = "Rabu";
							break;
						case 4: $harinya = "Kamis";
							break;
						case 5: $harinya = "Jumat";
							break;
						case 6: $harinya = "Sabtu";
							break;
						case 7: $harinya = "Minggu";
							break;
						default : $harinya = "Tidak Ada";
							break;
					}
					echo "<div class='main_heading text_align_center'>";
					echo "<h3>Presensi Tidak Dilakukan Hari Ini, Silakan Kembali Lagi Pada : </h3>";
					echo "<h3>Hari $harinya</h3>";
					echo "<h3>Pukul $awal - $akhir WIB</h3>";
					echo "</div>";
				}
			  ?>
            </div>
			<?php 
				}else{
					?>
					<div class="form_section">
						<div class='main_heading text_align_center'>
							<h2>ID Rule salah, Silakan input ID Rule yang benar!</h2>
						</div>
						<form class="form_contant" action="" method="POST">
						  <fieldset>
						  <div class="row justify-content-center">
							<div class="field col-lg-6 col-md-4 col-sm-3 col-xs-2">
							  <input class="field_custom" placeholder="Silakan Masukkan ID Rule" maxlength="8" type="text" name="idrule" autocomplete="off" required>  
							</div>
							<div class="center"><button type="submit" name="input_idrule" id="input_idrule" class="btn btn-primary btn-flat">Kirim</button></div>
						  </div>
						  </fieldset>
						</form>
					  </div>
					<?php
				} 
			?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- footer -->
      <div class="footer">
        <p align="center"><b><?php echo $footer = $db->footer; ?></b></p>
      </div>
<!-- end footer -->
<!-- js section -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<!-- menu js -->
<script src="assets/js/menumaker.js"></script>
<!-- wow animation -->
<script src="assets/js/wow.js"></script>
<!-- custom js -->
<script src="assets/js/custom.js"></script>


</body>
</html>