<?php
/**
 * Classe responsável por representar a base de um objeto Api
 */

namespace App\Api;

use App\Api\ApiResposta;

abstract class Api {
	protected $conexao;

	protected function __construct($conexao) {
		$this->conexao = $conexao;
	}

	public function getConexao() {
		return $this->conexao;
	}

	public static function erro($mensagem) {
		$resposta = new ApiResposta(
			[
				"erro" => true,
				"erro_mensagem" => $mensagem
			]
		);

		return $resposta;
	}
}

?>