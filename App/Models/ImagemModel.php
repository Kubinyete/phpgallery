<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de imagem
 */

namespace App\Models;

use App\Models\Model;
use App\Database\DalImagem;
use App\Database\DalUsuario;
use App\Database\DalComentario;
use App\Objects\Comentario;
use App\Views\ImagemView;
use App\Views\NotFoundView;
use App\MvcErrors\ImagemErro;

class ImagemModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $id=0, $comentarioConteudo=null, $comentarioErros=[]) {
		$dal = new DalImagem($this->conexao);
		$imagem = $dal->obterImagem($id);
		
		// Se a imagem foi encontrada
		if ($imagem !== null) {
			$dal = new DalUsuario($this->conexao);
			$usuario = $dal->obterUsuario(true, $imagem->getUsuarioId());
			$dal = new DalComentario($this->conexao);

			// Se não recebemos nenhum erro do Controller

			$comentarioErro = "";
			if (count($comentarioErros) <= 0) {
				$cmt = new Comentario(
					0,
					date("Y-m-d H:i:s"),
					$id,
					$usuarioLogado->getId(),
					$comentarioConteudo,
				);

				$dal->criarComentario($cmt);

				$comentarioConteudo = null;

			} else {
				foreach ($comentariosErros as $erro) {
					if (isset(ImagemErro::DEFINICOES[$erro])) {
						$comentarioErro = ImagemErro::DEFINICOES[$erro];
					}
				}
			}

			$comentarios = $dal->listarComentarios($imagem->getId());
			return new ImagemView($usuarioLogado, $imagem, $usuario, $comentarios, $comentarioConteudo, $comentarioErro);
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