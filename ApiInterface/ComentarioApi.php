<?php
namespace PHPGallery\ApiInterface;

require_once "Api.php";

set_include_path("..");

require_once "DatabaseInterface/DatabaseImagem.php";
require_once "DatabaseInterface/DatabaseComentario.php";

use PHPGallery\DatabaseInterface\DatabaseALImagem;
use PHPGallery\DatabaseInterface\DatabaseALComentario;

/**
 * Classe responsável por representar uma interface de Api com foco em objetos Comentario
 */
class ComentarioApi extends Api {
	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Retorna todas os comentários de determinada imagem
	public function obter_comentarios($id) {
		$dal = new DatabaseALImagem($this->_conexao);
		$imagem = $dal->obter_imagem($id);

		if ($imagem !== null) {
			$dal = new DatabaseALComentario($this->_conexao);
			$comentarios = $dal->obter_comentarios($imagem);

			$resposta = new ApiResposta($comentarios);
			$resposta->enviar();
		} else {
			$resposta = new ApiResposta();
			$resposta->enviar_erro(AE_IMAGEM_NAO_EXISTE);
		}
	}

	// Retorna um comentário de acordo com determinado id
	public function obter_comentario($id) {
		$dal = new DatabaseALComentario($this->_conexao);
		$comentario = $dal->obter_comentario($id);

		if ($comentario !== null) {
			$resposta = new ApiResposta($comentario);
			$resposta->enviar();
		} else {
			$resposta = new ApiResposta();
			$resposta->enviar_erro(AE_COMENTARIO_NAO_EXISTE);
		}
	}
}

?>
