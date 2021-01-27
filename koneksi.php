<?php
date_default_timezone_set("Asia/Jakarta");
class database{
	var $host = "localhost";
	var $uname = "root";
	var $passw = "";
	var $db = "db_presensi_binar";
	var $gambar_artikel = "images/artikel/";
	var $gambar_layanan = "images/layanan/";
	var $nama_web = "ArirA";
	var $alamat_kantor = "Karanganyar, Jawa Tengah, Indonesia";
	var $alamat_email = "binar@outlook.com";
	var $no_hp = "+628562824606";
	var $footer = "ArirA &copy; Copyright 2021 Binar Aris Purwaka";
	var $alamat_presensi = "http://presensi.arira.id/index.php?rule=";
	var $alamat_real = "C:/xampp/htdocs/20-21/xii/gasal/template/it-next-edit/";
	
	function __construct(){
		$this->koneksi = mysqli_connect(
			$this->host,
			$this->uname,
			$this->passw);
		
		if(!$this->koneksi){
			echo "koneksi database gagal";
		}else{
			$cekdb = mysqli_select_db($this->koneksi,$this->db);
			if(!$cekdb){
				$url = $_SERVER['REQUEST_URI'];
				if(substr($url,-11)!="install.php"){
					header("location: warning.html");
				}
			}
		}
	}
	
	//--
	
	function cek_idrule($idrule){
		$query = mysqli_query($this->koneksi,"select count(idrule) as jml from rules where idrule='$idrule'");
		$data = $query->fetch_array();
		$jml = $data['jml'];
		return $jml;
	}
	
	//digunakan
	function cek_data($idrule){
		$query = mysqli_query($this->koneksi,"select r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir, u.nama from rules r, users u where r.iduser=u.iduser and r.idrule='$idrule'");
		$data = $query->fetch_array();
		return $data;
	}
	
	//digunakan
	function input_presensi($idrule,$nama,$absen,$kelas,$waktu,$isi,$address){
		$hariini = date("Y-m-d H:i:s");
		mysqli_query($this->koneksi,"insert into presensi (idrule,nama,no_absen,kelas,waktu,isi,address) values ('$idrule','$nama','$absen','$kelas','$hariini','$isi','$address')");
	}
	
	//digunakan
	function masuk($username,$password){
		$psw = md5($password);
		$query = mysqli_query($this->koneksi,"select iduser,nama,jenis,status from users where username='$username' and password='$psw'");
		$data_user = $query->fetch_array();
		$jml = $query->num_rows;
		if($jml == 1){
			if($data_user['status'] == "0"){
				$pesan = "blokir";
				return $pesan;
			}else{
				setcookie('username_'.$nama_web, $username, time() + (60 * 60 * 24 * 5), '/');
				setcookie('iduser_'.$nama_web, $data_user['iduser'], time() + (60 * 60 * 24 * 5), '/');
				setcookie('nama_user_'.$nama_web, $data_user['nama'], time() + (60 * 60 * 24 * 5), '/');
				$_SESSION['username'] = $username;
				$_SESSION['iduser'] = $data_user['iduser'];
				$_SESSION['jenis'] = $data_user['jenis'];
				$_SESSION['nama_user'] = $data_user['nama'];
				$_SESSION['is_login_presensi'] = TRUE;
				$this->update_lastlogin($data_user['iduser']);
				$pesan = "sukses";
				return $pesan;
			}
		}else{
			$pesan = "gagal";
			return $pesan;
		}
	}
	
	//digunakan
	function cek_jumlah_data($iduser){
		$hari_ini = date("Y-m-d");
		$query = mysqli_query($this->koneksi,"SELECT (SELECT COUNT(*) FROM users) AS users , (SELECT COUNT(*) FROM rules where iduser='$iduser') AS rules , (SELECT COUNT(*) FROM rules r, presensi p where r.idrule=p.idrule and r.iduser='$iduser') AS presensi, (SELECT COUNT(*) FROM rules r, presensi p where r.idrule=p.idrule and r.iduser='$iduser' and left(p.waktu,10)='$hari_ini') AS presensi_hari_ini FROM DUAL");
		$jumlah = $query->fetch_array();
		return $jumlah;
	}
	
	//digunakan
	function cek_tampil_presensi_timeline($iduser){
		$kolom_presensi = "p.idpresensi, p.idrule, p.nama as nama_lengkap, p.no_absen, p.kelas, p.waktu, p.isi, p.address";
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom_users = "u.iduser, u.nama";
		$kolom = $kolom_presensi.",".$kolom_rules.",".$kolom_users;
		$tabel = "presensi p,rules r, users u";
		$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa");
		$data_data = $data->fetch_array();
		$jml = $data->num_rows;
		return $jml;
	}
	
	//digunakan
	function tampil_presensi_timeline($batas,$iduser){
		$kolom_presensi = "p.idpresensi, p.idrule, p.nama as nama_lengkap, p.no_absen, p.kelas, p.waktu, p.isi, p.address";
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom_users = "u.iduser, u.nama";
		$kolom = $kolom_presensi.",".$kolom_rules.",".$kolom_users;
		$tabel = "presensi p,rules r, users u";
		$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by p.waktu desc limit $batas");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		$jml = $data->num_rows;
		if ($jml != 0){
			return $hasil;
		}
	}
	
	//digunakan
	function time2str($ts){
		if(!ctype_digit($ts))
			$ts = strtotime($ts);

		$diff = time() - $ts;
		if($diff == 0)
			return 'sekarang';
		elseif($diff > 0)
		{
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 60) return 'baru saja';
				if($diff < 120) return '1 menit lalu';
				if($diff < 3600) return floor($diff / 60) . ' menit lalu';
				if($diff < 7200) return '1 jam lalu';
				if($diff < 86400) return floor($diff / 3600) . ' jam lalu';
			}
			if($day_diff == 1) return 'kemarin';
			if($day_diff < 7) return $day_diff . ' hari yang lalu';
			if($day_diff < 31) return ceil($day_diff / 7) . ' minggu lalu';
			if($day_diff < 60) return 'bulan lalu';
			return date('F Y', $ts);
		}
		else
		{
			$diff = abs($diff);
			$day_diff = floor($diff / 86400);
			if($day_diff == 0)
			{
				if($diff < 120) return 'satu menit lagi';
				if($diff < 3600) return 'dalam ' . floor($diff / 60) . ' menit lagi';
				if($diff < 7200) return 'satu jam lagi';
				if($diff < 86400) return 'dalam ' . floor($diff / 3600) . ' jam lagi';
			}
			if($day_diff == 1) return 'besok';
			if($day_diff < 4) return date('l', $ts);
			if($day_diff < 7 + (7 - date('w'))) return 'pekan depan';
			if(ceil($day_diff / 7) < 4) return 'dalam ' . ceil($day_diff / 7) . ' pekan';
			if(date('n', $ts) == date('n') + 1) return 'bulan depan';
			return date('F Y', $ts);
		}
	}
	
	// Function to get the client IP address
	function get_ip() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	//digunakan
	function cek_tampil_presensi($iduser){
		$kolom_presensi = "p.idpresensi, p.idrule, p.nama as nama_lengkap, p.no_absen, p.kelas, p.waktu, p.isi, p.address";
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom_users = "u.iduser, u.nama";
		$kolom = $kolom_presensi.",".$kolom_rules.",".$kolom_users;
		$tabel = "presensi p,rules r, users u";
		$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa");
		$data_data = $data->fetch_array();
		$jml = $data->num_rows;
		return $jml;
	}
	
	//digunakan
	function tampil_presensi($iduser){
		$kolom_presensi = "p.idpresensi, p.idrule, p.nama as nama_lengkap, p.no_absen, p.kelas, p.waktu, p.isi, p.address";
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom_users = "u.iduser, u.nama";
		$kolom = $kolom_presensi.",".$kolom_rules.",".$kolom_users;
		$tabel = "presensi p,rules r, users u";
		$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by p.waktu desc");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
	}
	
	//digunakan
	function hapus_presensi($idpresensi){
		$cek = mysqli_query($this->koneksi,"delete from presensi where idpresensi='$idpresensi'");
		if($cek){
			$pesan = "sukses";
		}else{
			$pesan = "gagal";
		}
		return $pesan;
	}
	
	//digunakan
	function hapus_semua_presensi($iduser){
		$cek_idrule = mysqli_query($this->koneksi,"select idrule from rules where iduser='$iduser'");
		$jml = $cek_idrule->num_rows;
		if($jml!=0){
			while($row = mysqli_fetch_array($cek_idrule)){
			$cek = mysqli_query($this->koneksi,"delete from presensi where idrule='$row[idrule]'");
			}
			if($cek){
				$pesan = "sukses";
			}else{
				$pesan = "gagal";
			}
		}else{
			$pesan="tidak ada yang";
		}
		return $pesan;
	}
	
	//digunakan
	function cek_tampil_rules($iduser){
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom = $kolom_rules;
		$tabel = "rules r";
		$klausa = "r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by r.hari");
		$data_data = $data->fetch_array();
		$jml = $data->num_rows;
		return $jml;
	}
	
	//digunakan
	function tampil_rules($iduser){
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom = $kolom_rules;
		$tabel = "rules r";
		$klausa = "r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by r.hari");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
	}
	
	//digunakan
	function hapus_rule($idrule){
		$cek = mysqli_query($this->koneksi,"delete from rules where idrule='$idrule'");
		if($cek){
			$pesan = "sukses_hapus";
		}else{
			$pesan = "gagal_hapus";
		}
		return $pesan;
	}
	
	//digunakan
	function input_rule($iduser,$tingkat,$nama_mapel,$hari,$awal,$akhir){
		$idnya = $this->dapat_idrule($iduser,$hari,$tingkat);
		$insert = mysqli_query($this->koneksi,"insert into rules (idrule,iduser,tingkat,nama_mapel,hari,awal,akhir) values ('$idnya','$iduser','$tingkat','$nama_mapel','$hari','$awal','$akhir')");
		if($insert){
			$pesan="sukses";
		}else{
			$pesan="gagal";
		}
		return $pesan;
	}
	
	//digunakan
	function dapat_idrule($iduser,$hari,$tingkat){
		//00121101
		//001  -> 3 digit iduser
		//2  -> 1 digit hari
		//11  -> 2 digit tingkat
		//01  -> 2 digit urut
		if($iduser<10){
			$nol="00";
		}else if($iduser<100){
			$nol="0";
		}else{
			$nol="";
		}
		$idawal = $nol.$iduser; //001
		$idfiks = $idawal.$hari.$tingkat; //001211XX
		$data = mysqli_query($this->koneksi, "select right(idrule,2) as urut from rules where left(idrule,6)='$idfiks' order by idrule desc limit 1");
		$hasil = $data->fetch_array();
		$jml = $data->num_rows;
		$no = $hasil['urut']+1;
		if(is_null($jml)){
			$urut="01";
		}else if($no<10){
			$urut="0".$no;
		}else{
			$urut=$no;
		}
		return $idfiks.$urut;
	}
	
	//digunakan
	function update_rule($idrule,$tingkat,$nama_mapel,$hari,$awal,$akhir){
		$query = mysqli_query($this->koneksi,"update rules set nama_mapel='$nama_mapel',tingkat='$tingkat',hari='$hari',awal='$awal',akhir='$akhir' where idrule='$idrule'");
		if($query){
			$pesan="sukses_edit";
		}else{
			$pesan="gagal_edit";
		}
		return $pesan;
	}
	
	//digunakan
	function tampil_users(){
		$data = mysqli_query($this->koneksi,"select * from users order by iduser desc");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		$jml = $data->num_rows;
		if ($jml != 0){
			return $hasil;
		}
	}
	
	//digunakan
	function input_user($nama,$user_,$pass_,$jenis_){
		$hariini = date("Y-m-d H:i:s");
		$cek = $this->cek_user($user_);
		if($cek==0){
			$insert = mysqli_query($this->koneksi,"insert into users (username,password,terdaftar,nama,jenis,status) values ('$user_',md5('$pass_'),'$hariini','$nama','$jenis_','1')");
			if($insert){
				$pesan="sukses";
			}else{
				$pesan="gagal";
			}
		}else{
			$pesan = "user";
		}
		return $pesan;
	}
	
	//digunakan
	function cek_user($username){
		$query = mysqli_query($this->koneksi,"select count(username) as jml from users where username='$username'");
		$data = $query->fetch_array();
		$jml = $data['jml'];
		return $jml;
	}
	
	//digunakan
	function update_user($iduser_,$nama_,$user_,$jenis_,$status_){
		$query = mysqli_query($this->koneksi,"update users set username='$user_',nama='$nama_',jenis='$jenis_',status='$status_' where iduser='$iduser_'");
		if($query){
			$pesan="sukses_edit";
		}else{
			$pesan="gagal_edit";
		}
		return $pesan;
	}
	
	//digunakan
	function reset_pass($iduser_,$pass_){
		$query = mysqli_query($this->koneksi,"update users set password=md5('$pass_') where iduser='$iduser_'");
		if($query){
			$pesan="sukses_reset";
		}else{
			$pesan="gagal_reset";
		}
		return $pesan;
	}
	
	//digunakan
	function hapus_user($iduser__){
		$cek = mysqli_query($this->koneksi,"delete from users where iduser='$iduser__'");
		if($cek){
			$pesan = "sukses_hapus";
		}else{
			$pesan = "gagal_hapus";
		}
		return $pesan;
	}
	
	//digunakan
	function update_lastlogin($iduser){
		$hariini = date("Y-m-d H:i:s");
		$query = mysqli_query($this->koneksi,"update users set lastlogin='$hariini' where iduser='$iduser'");
		return $query;
	}
	
	//digunakan
	function keluar($iduser){
		$this->update_lastlogin($iduser);
		$_SESSION['is_login'] = FALSE;
		session_start();
		session_unset();
		session_destroy();
		setcookie('username', '', 0, '/');
		setcookie('iduser', '', 0, '/');
		session_destroy();
	}
	
	//digunakan
	function update_profile($iduser_,$jenis_edit_,$baru_){
		if($jenis_edit_=="N"){
			$query = mysqli_query($this->koneksi,"update users set nama='$baru_' where iduser='$iduser_'");
			if($query){
				$pesan="sukses_nama";
				$_SESSION['nama_user'] = $baru_;
			}else{
				$pesan="gagal_nama";
			}
		}else if($jenis_edit_ == "U"){
			$cek = $this->cek_user($baru_);
			if($cek==0){
				$query = mysqli_query($this->koneksi,"update users set username='$baru_' where iduser='$iduser_'");
				if($query){
					$pesan="sukses_user";
					$_SESSION['username'] = $baru_;
				}else{
					$pesan="gagal_user";
				}
			}else{
				$pesan = "user";
			}
		}else if($jenis_edit_=="P"){
			$query = mysqli_query($this->koneksi,"update users set password=md5('$baru_') where iduser='$iduser_'");
			if($query){
				$pesan="sukses_pass";
			}else{
				$pesan="gagal_pass";
			}
		}
		return $pesan;
	}
	
	//--
	
	function cek_filter_presensi($filter,$iduser){
		if($filter=="today"){
			$query = mysqli_query($this->koneksi,"select p.idrule, count(p.idpresensi) as jml, p.waktu, r.idrule, r.iduser from presensi p, rules r, users u where p.idrule=r.idrule and u.iduser=r.iduser and r.iduser='$iduser' and left(p.waktu,10)=CURRENT_DATE");
			$data = $query->fetch_array();
			$jml = $data['jml'];
			return $jml;
		}else{
			$query = mysqli_query($this->koneksi,"select p.idrule, count(p.idpresensi) as jml, p.waktu, r.idrule, r.iduser from presensi p, rules r, users u where p.idrule=r.idrule and u.iduser=r.iduser and r.iduser='$iduser' and left(p.waktu,10)='$filter'");
			$data = $query->fetch_array();
			$jml = $data['jml'];
			return $jml;
		}
	}
	
	//digunakan
	function tampil_filter_presensi($iduser,$cek,$idrule){
		$kolom_presensi = "p.idpresensi, p.idrule, p.nama as nama_lengkap, p.no_absen, p.kelas, p.waktu, p.isi, p.address";
		$kolom_rules = "r.idrule, r.iduser, r.tingkat, r.nama_mapel, r.hari, r.awal, r.akhir";
		$kolom_users = "u.iduser, u.nama";
		$kolom = $kolom_presensi.",".$kolom_rules.",".$kolom_users;
		$tabel = "presensi p,rules r, users u";
		if($cek=="today"){
			$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser' and left(p.waktu,10)=CURRENT_DATE";
		}else{
			$klausa = "p.idrule=r.idrule and r.iduser = u.iduser and r.iduser='$iduser' and r.idrule='$idrule' and left(p.waktu,10)='$cek'";
		}
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by p.waktu desc");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
	}
	
	//digunakan
	function cek_navigasi_lap($iduser){
		$kolom_rules = "r.idrule, r.iduser, r.nama_mapel, r.tingkat";
		$kolom_users = "u.iduser";
		$kolom = $kolom_rules.",".$kolom_users;
		$tabel = "rules r, users u";
		$klausa = "r.iduser = u.iduser and r.iduser='$iduser'";
		$data = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by r.nama_mapel");
		$data_data = $data->fetch_array();
		$jml = $data->num_rows;
		return $jml;
	}
	
	//digunakan
	function navigasi_lap($iduser){
		$kolom_rules = "r.idrule, r.iduser, r.nama_mapel, r.tingkat";
		$kolom_users = "u.iduser";
		$kolom = $kolom_rules.",".$kolom_users;
		$tabel = "rules r, users u";
		$klausa = "r.iduser = u.iduser and r.iduser='$iduser'";
		$query = mysqli_query($this->koneksi,"select $kolom from $tabel where $klausa order by r.nama_mapel");
		while($row = mysqli_fetch_array($query)){
			$hasil[] = $row;
		}
		return $hasil;
	}
	
	//digunakan
	function cek_get_tgl_presensi($idrule){
		$data = mysqli_query($this->koneksi,"SELECT DISTINCT(left(waktu,10)) as tgl FROM `presensi` where idrule='$idrule' order by tgl desc");
		$data_data = $data->fetch_array();
		$jml = $data->num_rows;
		return $jml;
	}
	
	//digunakan
	function get_tgl_presensi($idrule){
		$query = mysqli_query($this->koneksi,"SELECT DISTINCT(left(waktu,10)) as tgl FROM `presensi` where idrule='$idrule' order by tgl desc");
		while($row = mysqli_fetch_array($query)){
			$hasil[] = $row;
		}
		return $hasil;
	}
}
?>