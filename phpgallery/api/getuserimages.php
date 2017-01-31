<?php
	require_once "../database/database.php";

	header("Content-Type: application/json", true);

	if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["u"]) && strlen($_GET["u"]) > 0) {
		$usuarioNome = ($_GET["u"]);

		$db = new Database();
		$imagens = $db->obter_imagens_usuario($usuarioNome);
		$db->finalizar();

		//Bem vamos acabar enviando o id do banco de dados
		//Vamos apenas modificá-lo para md5 pois o nome do arquivo de imagem é a hash md5 de seu id
		foreach ($imagens as $imagem) {
			$imagem->gerar_imagem_url();
			$imagem->gerar_titulo_formatado();
			$imagem->gerar_descricao_formatada();
		}

		$imagens = [
			"sucesso" => true,
			"imagens" => $imagens
		];

		echo json_encode($imagens);
	} else {
		$imagens = [
			"sucesso" => false,
			"imagens" => []
		];

		echo json_encode($imagens);
	}
?>