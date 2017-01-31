<?php
	require_once "../database/database.php";

	header("Content-Type: application/json", true);

	if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]) && strlen($_GET["id"]) > 0) {
		$id = intval($_GET["id"]);

		$db = new Database();
		$comentarios = $db->obter_comentarios($id);

		//Bem vamos acabar enviando o id do banco de dados
		//Vamos apenas modificá-lo para md5 pois o nome do arquivo de imagem é a hash md5 de seu id
		foreach ($comentarios as $comentario) {
			$comentario->gerar_conteudo_formatado();
			$comentario->autor = $db->obter_usuario_min($comentario->autor);
			$comentario->autor->gerar_imagem_url();
			unset($comentario->autor->senha);
			unset($comentario->autor->descricao);
			unset($comentario->autor->dataRegistro);
		}

		$db->finalizar();

		$comentarios = [
			"sucesso" => true,
			"comentarios" => $comentarios
		];

		echo json_encode($comentarios);
	} else {
		$comentarios = [
			"sucesso" => false,
			"comentarios" => []
		];

		echo json_encode($comentarios);
	}
?>