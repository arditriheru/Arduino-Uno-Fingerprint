<?php 
// koneksi database
include '../koneksi.php';
// menangkap data yang di kirim dari form
$id_user = $_GET['id_user'];
$nama = $_POST['nama'];
$id_finger = $_POST['id_finger'];
// update data ke database
mysqli_query($koneksi,"update user set nama='$nama',id_finger='$id_finger' where id_user='$id_user'");
// mengalihkan halaman kembali ke index.php
header("location:user-tampil.php");
?>