<?php 
// koneksi database
include '../koneksi.php';
// menangkap data yang di kirim dari form
$id_admin = $_GET['id_admin'];

	$nama=$_POST['nama'];
	$username=$_POST['username'];
	$password=md5($_POST['password']);
// update data ke database
mysqli_query($koneksi,"update admin set nama='$nama',username='$username',password='$password' where id_admin='$id_admin'");
// mengalihkan halaman kembali ke index.php
header("location:operator-tampil.php");
?>