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
	// $conexao
	
	public function index($usuarioLogado, $id=0) {
		$dal = new DalImagem($this->conexao);
		$imagem = $dal->obterImagem($id);
		
		// Se a imagem foi encontrada
		if ($imagem !== null) {
			$dal = new DalUsuario($this->conexao);
			$usuario = $dal->obterUsuario(true, $imagem->getUsuarioId());
			$dal = new DalComentario($this->conexao);
			$comentarios = $dal->listarComentarios($imagem->getId());
			return new ImagemView($usuarioLogado, $imagem, $usuario, $comentarios);
		} else {
			// 404 Not Found
			return $this->notFound($usuarioLogado);
		}
	}

	// Utiliza nossa NotFoundView que já está pronta
	public function notFound($usuarioLogado) {
		return new NotFoundView($usuarioLogado);
	}
}

?>