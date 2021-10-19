<?php
$host="localhost";
$user="root";
$password="";
$db="db_finger";
$koneksi=mysqli_connect($host,$user,$password,$db) or die (mysqli_error());
if ($koneksi){
	//echo "berhasil";
}
?>