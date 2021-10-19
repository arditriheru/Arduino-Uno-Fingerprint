<?php include "../session-start2.php";?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard - Sistem Keamanan Pintu</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <!-- Add custom CSS here -->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
  </head>
  <body>
  <nav>
    <div id="wrapper">
      <?php include "menu.php"; ?>
        </div><!-- /.navbar-collapse -->
      </nav>
      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Dashboard <small><?php echo $_SESSION['nama']; ?></small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
              <li class="active"><i class="fa fa-pencil"></i> User</li>
            </ol>  
            <?php include "../notifikasi.php";?>
          </div>
        </div><!-- /.row -->
<div class="row">
          <div class="col-lg-12">
          <div class="table-responsive">
            <a href="user-tambah"
            <button type="button" class="btn btn-success">TAMBAH</a><br><br>
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                    <th><center>No</th>
                    <th><center>Nama</th>
                    <th><center>ID Finger</th>
                    <th><center>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <!---------- Batas ----------->
        <?php
			$no=1;
			include('../koneksi.php');
			$user=mysqli_query($koneksi,"SELECT * FROM user ORDER BY id_finger ASC");
			while ($data=mysqli_fetch_assoc($user)){
		?>
		<tr>
			<td align="center"><?php echo $no++; ?></td>
			<td><?php echo $data['nama']; ?></td>
      <td align="center"><?php echo $data['id_finger']; ?></td>
			<td>
        <div>
          <a href="user-edit?id_user=<?php echo $data['id_user']; ?>"
            <button type="button" class="btn btn-warning">EDIT</a>
          <a href="user-hapus?id_user=<?php echo $data['id_user']; ?>"
            onclick="javascript: return confirm('Anda yakin hapus?')"
            <button type="button" class="btn btn-danger">HAPUS</a>
        </div>
      </td>
		</tr>
		<?php
		}
		?>       
                </tbody>
               </table>
             </div>
          </div>
        </div>
<br><br>
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <?php include('../copyright.php');?><br><br>
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="../js/morris/chart-data-morris.js"></script>
    <script src="../js/tablesorter/jquery.tablesorter.js"></script>
    <script src="../js/tablesorter/tables.js"></script>
  </body>
</html>
