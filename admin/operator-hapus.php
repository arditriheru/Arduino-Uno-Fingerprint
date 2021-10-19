<?php
include ('../koneksi.php');
$id_admin=$_GET['id_admin'];
$delete=mysqli_query($koneksi,"delete from admin where id_admin='$id_admin'");
if ($delete){
	header("location:operator-tampil");
}else{
	echo '<script language="javascript">alert("Gagal Hapus Operator!"); window.history.back();</script>';
}
?>