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
	// $conexao

	public function obterUsuario($nome) {
		if (strlen(trim($nome)) <= 0) {
			return parent::erro("É preciso informar o nome do usuário para obter suas informações.");
		}

		$dal = new DalUsuario($this->getConexao());
		$usuario = $dal->obterUsuario(false, $nome, true);
		
		$resposta = new ApiResposta($usuario);

		return $resposta;
	}

	public function listarUsuarios($procuraString) {
		$dal = new DalUsuario($this->getConexao());
		$usuarios = $dal->listarUsuarios($procuraString, true);
		
		$resposta = new ApiResposta($usuarios);

		return $resposta;
	}
}

?>