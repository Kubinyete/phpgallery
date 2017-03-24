<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de imagem
 */

namespace App\Models;

use App\Models\Model;
use App\Database\DalImagem;
use App\Database\DalUsuario;
use App\Database\DalComentario;
use App\Views\ImagemView;
use App\Views\NotFoundView;

class ImagemModel extends Model {
	public function index($usuarioLogado, $id) {
		$dal = new DalImagem($this->conexao);
		$imagem = $dal->obterImagem($id);
		
		if ($imagem !== null) {
			$dal = new DalUsuario($this->conexao);
			$usuario = $dal->obterUsuario(true, $imagem->getUsuarioId());
			$dal = new DalComentario($this->conexao);
			$comentarios = $dal->listarComentarios($imagem->getId());
			return new ImagemView($usuarioLogado, $imagem, $usuario, $comentarios);
		} else {
			return $this->notFound($usuarioLogado);
		}
	}

	public function notFound($usuarioLogado) {
		return new NotFoundView($usuarioLogado);
	}
}

?>