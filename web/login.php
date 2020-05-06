<div class="kotak_login">
		<p class="tulisan_login">Silahkan login</p>
	<form method="post">
		<label>Username</label>
			<input type="text" name="username" class="form_login" placeholder="Masukkan ..">
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Masukkan ..">
			<input type="submit" class="tombol_login" name="login" value="LOGIN">
			<br><br>			
	</form>
</div>
<?php include ('koneksi.php');
if (isset($_POST['login'])){
	$username=$_POST['username'];
	$password=md5($_POST['password']);

	$admin=mysqli_query($koneksi,"select * from admin where username='$username' and password='$password'");
	$data=mysqli_fetch_assoc($admin);
	$level=$data['level'];
	$cek=mysqli_num_rows($admin);

	if ($cek>0){
		session_start();
		$_SESSION['nama']=$data['nama'];
		if($level == "Admin"){
			$_SESSION['Admin']=$data['level'];
			header("location:admin/dashboard.php");
		}
		elseif($level == "Operator"){
			$_SESSION['Operator']=$data['level'];
			header("location:operator/dashboard.php");
		}
	}else{
		echo '<script>alert("Username atau Password Salah!");</script>
			<script>window.location.href="index.php";</script>';
	}
}
?>