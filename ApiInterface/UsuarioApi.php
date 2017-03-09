<?php
namespace PHPGallery\ApiInterface;

require_once "Api.php";

set_include_path("..");

require_once "DatabaseInterface/DatabaseUsuario.php";

use PHPGallery\DatabaseInterface\DatabaseALUsuario;

/**
 * Classe responsável por representar uma interface de Api com foco em objetos Usuario
 */
class UsuarioApi extends Api {
	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Retorna uma lista de Usuario conforme a string de busca passada
	public function procurar_usuarios($string) {
		$dal = new DatabaseALUsuario($this->_conexao);
		$usuarios = $dal->procurar_usuarios_api($string);

		$resposta = new ApiResposta($usuarios);
		$resposta->enviar();
	}

	// Retorna um objeto Usuario
	public function obter_usuario($valor) {
		$dal = new DatabaseALUsuario($this->_conexao);
		$usuario = $dal->obter_usuario_api($valor);

		if ($usuario !== null) {
			$resposta = new ApiResposta($usuario);
			$resposta->enviar();
		} else {
			$resposta = new ApiResposta();
			$resposta->enviar_erro(AE_USUARIO_NAO_EXISTE);
		}
	}
}

?>
