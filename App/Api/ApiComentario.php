<?php
/**
 * Classe responsável por receber os parâmetros para processar e retornar
 * uma ApiResposta de objetos Comentario
 */

namespace App\Api;

use App\Api\Api;
use App\Database\DalComentario;
use App\Api\ApiResposta;

class ApiComentario extends Api {
	// $conexao
	
	public function obterComentario($id) {
		if (intval($id) <= 0) {
			return parent::erro("É preciso informar corretamente o id do comentário para obter suas informações.");
		}

		$dal = new DalComentario($this->conexao);
		$comentario = $dal->obterComentario($id, true);
		
		$resposta = new ApiResposta($comentario);

		return $resposta;
	}

	public function listarComentarios($imgId) {
		if (intval($imgId) <= 0) {
			return parent::erro("É preciso informar corretamente o id da imagem para obter os comentários.");
		}
		
		$dal = new DalComentario($this->conexao);
		$comentarios = $dal->listarComentarios($imgId, true);
		
		$resposta = new ApiResposta($comentarios);

		return $resposta;
	}
}

?>