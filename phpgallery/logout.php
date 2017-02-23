<?php
	session_start();

	if (isset($_SESSION["usuario"])) {
		$_SESSION["usuario"] = null;
		header("Refresh: 0; url=login.php", true);
		exit();
	} else {
		header("Refresh: 0; url=home.php", true);
		exit();
	}
?>
Por favor, espere...
