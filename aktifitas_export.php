<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Aktifitas ".date('dmY').".xls");
?>
<?php 
include "../koneksi.php";
$awal = $_POST['awal'];
$akhir = $_POST['akhir'];
?>
<!DOCTYPE html>
<html>
<body>
	<table align="center" border="1">
		<h2 align="center">Rekap Data Aktifitas</h2>
		<h2 align="center">Akses Ruang Staf</h2>
		<h3 align="center">Tanggal : <?php echo $awal ?> - <?php echo $akhir ?></h3>
		<tr>
			<td>No</td>
			<td>Nama</td>
			<td>Tanggal</td>
			<td>Jam</td>
		</tr>
		<?php
		$no=1;
		include('koneksi.php');
		$awal = $_POST['awal'];
    	$akhir = $_POST['akhir'];
		$aktifitas=mysqli_query($koneksi,
		   "SELECT nama,tanggal,jam
	        FROM aktifitas,user
	        WHERE tanggal BETWEEN '$awal' AND '$akhir' AND user.id_finger=aktifitas.id_finger
	        ORDER BY id_aktifitas DESC");
		while ($data=mysqli_fetch_assoc($aktifitas)){
		$tanggal = $data["tanggal"];
		?>
		<tr>
			<td><center><?php echo $no++; ?></td>
			<td><?php echo $data['nama']; ?></td>
			<td><center><?php echo date('d-m-Y', strtotime($tanggal)); ?></td>
			<td><center><?php echo $data['jam']; ?></td>
		</tr>
		<?php
		}
		?>
	</table>
</body>
</html>