<head>
  <!--<meta http-equiv="refresh" content="1">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var auto_refresh = setInterval(
    function () {
       $('#load_content').load('aktifitas.php').fadeIn("slow");
    }, 1000); // refresh setiap 10000 milliseconds
    
</script>
<div id="load_content"></div>
</head>
<div class="row">
          <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                    <th><center>No</th>
					<th><center>ID Sidik Jari</th>
                    <th><center>Nama</th>
                    <th><center>Tanggal</th>
                    <th><center>Jam</th>
                    </tr>
                </thead>
                <tbody>
                  <!---------- Batas ----------->
                  <?php
		$no=1;
		include('../koneksi.php');
    date_default_timezone_set("Asia/Jakarta");
    $tanggalHariIni=date('Y-m-d');
		$aktifitas=mysqli_query($koneksi,
       "SELECT *
        FROM aktifitas,user
        WHERE tanggal='$tanggalHariIni' AND user.id_finger=aktifitas.id_finger
        ORDER BY id_aktifitas DESC");
		while ($data=mysqli_fetch_assoc($aktifitas)){
    $tanggal = $data["tanggal"];
		?>
		<tr>
			<td><center><?php echo $no++; ?></td>
			<td><center>ID : <?php echo $data['id_finger']; ?></td>
			<td><?php echo $data['nama']; ?></td>
			<td><center><?php echo date('d-m-Y', strtotime($tanggal)); ?></td>
			<td><center><?php echo $data['jam']; ?></td>
		</tr>
		<?php
		}
		?>              
                    </tbody>
                  </table>
                </div>
          </div>
          </div>