<?php include "../session-start.php";?>
<?php
include ('../koneksi.php');
$id_user=$_GET['id_user'];
$edit=mysqli_query($koneksi,"select * from user where id_user='$id_user'");
$data=mysqli_fetch_assoc($edit);
?>
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
    <script type="text/javascript" src="chartjs/Chart.js"></script>
  </head>
  <body>
  	<nav>
    <div id="wrapper">
      <?php include "menu.php"; ?>
        </div><!-- /.navbar-collapse -->
      </nav>
  <nav>
    <div id="wrapper">
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
            <?php include "../notifikasi.php"?>
          </div>
        </div><!-- /.row -->
  		<div class="row">
  			<div class="col-lg-6">
          <?php
              if(isset($_POST['submit'])){
                include '../koneksi.php';
                date_default_timezone_set("Asia/Jakarta");
                $tanggal=date('Y-m-d');
                $jam=date("h:i:sa");
                // menangkap data yang di kirim dari form
                $id_user = $_GET['id_user'];
                $nama = $_POST['nama'];
                $id_finger = $_POST['id_finger'];

                $error=array();
                if (empty($id_finger)){
                  $error['id_finger']='ID Harus Diisi!!!';
                }if (empty($nama)){
                  $error['nama']='Nama Harus Diisi!!!';
                }if(empty($error)){
                  $simpan=mysqli_query($koneksi,"UPDATE user SET nama='$nama',id_finger='$id_finger' WHERE id_user='$id_user'");
                if($simpan){
                echo "<script>alert('Berhasil Memperbarui!!');document.location='user-tampil'</script>";
                }else{
                echo "<script>alert('Gagal Mendaftar! Hilangkan Tanda Petik Pada Nama Pasien!');document.location='user-edit'</script>";
                  }
                }
              }
            ?>
          	<form method="post" action="" role="form" 
              enctype="multipart/form-data">
              <div class="form-group">
                <label>ID Finger</label>
                <input class="form-control" type="text" name="id_finger" id="id_finger" value="<?php echo $data['id_finger']; ?>" required="">
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" id="nama" value="<?php echo $data['nama']; ?>" required="">
              </div>
              <button type="submit" name="submit" class="btn btn-success">Perbarui</button>
              <button type="reset" class="btn btn-warning">Reset</button>  
            </form>
            </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
       <?php include "../copyright.php"?><br><br>
		</div>
<br><br>
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->
    <!-- JavaScript -->
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.js"></script>
    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="../js/morris/chart-data-morris.js"></script>
    <script src="../js/tablesorter/jquery.tablesorter.js"></script>
    <script src="../js/tablesorter/tables.js"></script>
  </body>
</html>