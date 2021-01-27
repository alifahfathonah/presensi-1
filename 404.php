<?php
session_start();
include "koneksi.php";
$db = new database();
$lokasi_gambar = $db->gambar_artikel;
$namaweb = $db->nama_web;
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
<title><?php echo $namaweb; ?> - Binar Aris</title>
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
              <h1 class="page-title">Error 404</h1>
              <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Error 404</li>
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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="center margin_bottom_30_all"> <img class="margin_bottom_30_all" src="assets/images/it_service/404_error_img.png" alt="#"> </div>
        <div class="heading text_align_center">
          <h2>OOOPS, HALAMAN YANG ANDA CARI TIDAK ADA!</h2>
        </div>
        <div class="center"> <a class="btn sqaure_bt light_theme_bt" href="index.php">Back Home</a> </div>
      </div>
    </div>
  </div>
</div>
<!-- end section -->

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
