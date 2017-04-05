<?php
/**
 * Classe responsável por receber os parâmetros para processar e retornar
 * uma ApiResposta de objetos Imagem
 */

namespace App\Api;

use App\Api\Api;
use App\Database\DalImagem;
use App\Api\ApiResposta;

class ApiImagem extends Api {
	// $conexao

	public function obterImagem($id) {
		if (intval($id) <= 0) {
			return parent::erro("É preciso informar corretamente a id da imagem para obter suas informações.");
		}

		$dal = new DalImagem($this->conexao);
		$imagem = $dal->obterImagem($id, true);
		
		$resposta = new ApiResposta($imagem);

		return $resposta;
	}

	public function listarImagens($procuraString) {
		$dal = new DalImagem($this->conexao);
		$imagens = $dal->listarImagens($procuraString, true);
		
		$resposta = new ApiResposta($imagens);

		return $resposta;
	}

	public function listarRecentes() {
		$dal = new DalImagem($this->conexao);
		$imagens = $dal->listarRecentes(true);

		$resposta = new ApiResposta($imagens);

		return $resposta;
	}
}

?>