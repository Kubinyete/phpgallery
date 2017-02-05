<?php
	session_start();

	$usuario = null;

	if (isset($_SESSION["usuario"])) {
		$_SESSION["usuario"] = null;
		header("Refresh: 0; url=login.php", true);
	}
?>
Por favor, espere...
