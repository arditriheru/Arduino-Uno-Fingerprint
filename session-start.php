<?php
session_start();
if (!isset($_SESSION['Admin'])){
	echo '<script>alert("Login Dulu!");</script>
		<script>window.location.href="../index.php";</script>';
}
?>