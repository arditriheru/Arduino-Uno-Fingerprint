<?php 
// koneksi database
include '../koneksi.php';
// menangkap data yang di kirim dari form
	$id_finger	=	$_POST['id_finger'];
	$nama		=	$_POST['nama'];
// menginput data ke database
mysqli_query($koneksi,"insert into user values(id_user,'$id_finger','$nama')");
// mengalihkan halaman kembali ke index.php
header("location:user-tampil.php");
?>