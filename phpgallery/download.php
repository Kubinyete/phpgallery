<?php
	require_once "database/database.php";

	if (!isset($_GET["id"])) {
		header("Status: 400", true, 400);
		exit("Pedido inválido.");
	} else {
		$id = $_GET["id"];
		$id = intval($id);

		$db = new Database();
		$imagem = $db->obter_imagem($id);

		if ($imagem !== null) {
			$imagemData = file_get_contents(DOWNLOAD_HTDOCS . $imagem->imagem_url());

			if (!$imagemData) {
				header("Status: 400", true, 400);
				exit("Não foi possível encontrar a imagem requisistada.");
			}

			$headerExt = $imagem->ext;
			
			if ($headerExt === ".jpg") { $headerExt = "jpeg"; }
			if ($headerExt === ".png") { $headerExt = "png"; }
			if ($headerExt === ".gif") { $headerExt = "gif"; }

			header("Content-Type: image/" . $headerExt);
			header("Content-Disposition: attachment; filename=\"" . $imagem->id_md5_hash() . $imagem->ext . "\"");
			echo $imagemData;

		} else {
			header("Status: 400", true, 400);
			exit("Não foi possível encontrar a imagem requisistada no banco de dados.");
		}
	}
?>