<?php
namespace PHPGallery\ApiInterface;

require_once "ApiResposta.php";

/**
 * Classe responsável por representar um objeto Api
 * será passado por herança para cada interface de acesso (Comentario, Imagem, Usuario, etc)
 */
class Api {
	protected $_conexao;

	public function __construct($conexao) {
		$this->_conexao = $conexao;
	}

	// Retorna uma resposta de erro pela Api
	public function enviar_erro($err=0) {
		$resposta = new ApiResposta();
		$resposta->enviar_erro($err);
	}
}

?>