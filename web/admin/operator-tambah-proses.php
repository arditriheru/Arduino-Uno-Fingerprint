<?php 
// koneksi database
include '../koneksi.php';
// menangkap data yang di kirim dari form
	$nama		=	$_POST['nama'];
	$username	=	$_POST['username'];
	$password	=	md5($_POST['password']);
// menginput data ke database
mysqli_query($koneksi,"insert into admin values(id_admin,'$nama','$username','$password','Operator')");
// mengalihkan halaman kembali ke index.php
header("location:operator-tampil.php");
?>