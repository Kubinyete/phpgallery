<?php
/**
 * Modelo responsável por obter informações para a visualização de uma página de editar imagem
 */

namespace App\Models;

use App\Models\Model;
use App\Views\ErroView;
use App\Views\ImagemEditView;
use App\Database\DalImagem;

class ImagemEditModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $imagemId=0) {
		$dal = new DalImagem($this->getConexao());
		$imagem = $dal->obterImagem($imagemId);

		if ($imagem === null) {
			return $this->notFound($usuarioLogado);
		} else {
			if ($usuarioLogado->getAdmin() || $imagem->getUsuarioId() === $usuarioLogado->getId()) {
				return new ImagemEditView($usuarioLogado, $imagem);
			} else {
				return $this->forbidden($usuarioLogado);
			}
		}
	}

	public function notFound($usuarioLogado) {
		return new ErroView(
			$usuarioLogado,
			'A imagem que você está procurando não existe.',
			'HTTP - 404 Not Found'
		);
	}

	public function forbidden($usuarioLogado) {
		return new ErroView(
			$usuarioLogado,
			'Você não é o autor desta imagem ou não possui privilégios o suficiente para editá-la.',
			'HTTP - 403 Forbidden'
		);
	}
}

?>