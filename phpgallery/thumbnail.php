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
		$db->finalizar();

		if ($imagem !== null) {
			$imagemDataStr = file_get_contents(UPLOAD_IMAGENS_DESTINO . $imagem->id_md5_hash() . $imagem->ext);

			if (!$imagemDataStr) {
				header("Status: 404", true, 404);
				exit("Não foi possível encontrar a imagem requisistada no disco.");
			} else {
				$informacoes = getimagesizefromstring($imagemDataStr);
				$imagemData = imagecreatefromstring($imagemDataStr);

				$largura = $informacoes[0];
				$altura = $informacoes[1];
				$novaLargura = $largura;
				$novaAltura = $altura;

				//Obtendo nova altura e largura sem destruir a aspect ratio da imagem (A imagem não ficará esticada)
				while ($novaLargura > 250 || $novaAltura > 250) {
					$novaAltura = $novaAltura - 1;
					$novaLargura = $largura / $altura * $novaAltura;
				}

				$miniatura = imagecreatetruecolor($novaLargura, $novaAltura);
				imagecopyresampled($miniatura, $imagemData, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);

				header("Content-Type: image/jpeg", true);
				imagejpeg($miniatura, null, 50);
			}
		} else {
			header("Status: 404", true, 404);
			exit("Não foi possível encontrar a imagem requisistada no banco de dados.");
		}
	}
?>