<?php
/**
 * Classe responsável por receber os parâmetros para processar e retornar
 * uma ApiResposta de objetos Usuario
 */

namespace App\Api;

use App\Api\Api;
use App\Database\DalUsuario;
use App\Api\ApiResposta;

class ApiUsuario extends Api {
	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	public function obterUsuario($nome) {
		if ($nome === null || strlen(trim($nome)) <= 0) {
			return parent::erro("É preciso informar o nome do usuário para obter suas informações.");
		}

		$dal = new DalUsuario($this->conexao);
		$usuario = $dal->obterUsuario($nome, true);
		
		$resposta = new ApiResposta($usuario);

		return $resposta;
	}

	public function listarUsuarios($procuraString) {
		$dal = new DalUsuario($this->conexao);
		$usuarios = $dal->listarUsuarios($procuraString, true);
		
		$resposta = new ApiResposta($usuarios);

		return $resposta;
	}
}

?>