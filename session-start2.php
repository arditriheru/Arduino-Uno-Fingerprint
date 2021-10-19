<?php
session_start();
if (!isset($_SESSION['Operator'])){
	echo '<script>alert("Login Dulu!");</script>
		<script>window.location.href="../index.php";</script>';
}
?>