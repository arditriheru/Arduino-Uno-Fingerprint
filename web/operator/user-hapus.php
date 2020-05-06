<?php
include ('../koneksi.php');
$id_user=$_GET['id_user'];
$delete=mysqli_query($koneksi,"delete from user where id_user='$id_user'");
if ($delete){
	header("location:user-tampil.php");
}else{
	echo '<script language="javascript">alert("Gagal Hapus User!"); window.history.back();</script>';
}
?>