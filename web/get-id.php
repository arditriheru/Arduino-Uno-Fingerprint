<?php
include 'koneksi.php';

if (!empty($_GET['id'])){  
	$finger_id = $_GET['id']; 
	date_default_timezone_set("Asia/Jakarta");
	$tanggal=date("Y-m-d");
	$jam=date("H:i:s");
	$query= mysqli_query($koneksi, "insert into aktifitas values(id_aktifitas,'$finger_id','$tanggal','$jam')");
	if($query){
	echo 'Berhasil disimpan';
	}else{
	echo 'Penyimpanan Gagal';
	}
}else{
	echo "ID Kosong";
}
?>