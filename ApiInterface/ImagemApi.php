<?php
namespace PHPGallery\ApiInterface;

require_once "Api.php";

set_include_path("..");

require_once "DatabaseInterface/DatabaseImagem.php";

use PHPGallery\DatabaseInterface\DatabaseALImagem;

/**
 * Classe responsável por representar uma interface de Api com foco em objetos Imagem
 */
class ImagemApi extends Api {
	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Retorna as imagens adicionadas recentemente
	public function obter_recentes() {
		$dal = new DatabaseALImagem($this->_conexao);
		$imagens_recentes = $dal->obter_recentes();

		$resposta = new ApiResposta($imagens_recentes);
		$resposta->enviar();
	}

	// Retorna as imagens que batem com a string de busca informada
	public function procurar_imagens($string) {
		$dal = new DatabaseALImagem($this->_conexao);
		$imagens = $dal->procurar_imagens($string);

		$resposta = new ApiResposta($imagens);
		$resposta->enviar();
	}

	// Retorna a imagem de acordo com o id passado
	public function obter_imagem($id) {
		$dal = new DatabaseALImagem($this->_conexao);
		$imagem = $dal->obter_imagem($id);

		if ($imagem !== null) {
			$resposta = new ApiResposta($imagem);
			$resposta->enviar();
		} else {
			$resposta = new ApiResposta();
			$resposta->enviar_erro(AE_IMAGEM_NAO_EXISTE);
		}
	}
}

?>
