<?php
session_start();
session_destroy();
echo '<script>alert("Berhasil Logout!");</script>
			<script>window.location.href="index";</script>';
?>