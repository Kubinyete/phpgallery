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
use Config\Config;

class ImagemModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $id=0, $comentarioConteudo=null, $comentarioErros=[]) {
		$dal = new DalImagem($this->getConexao());
		$imagem = $dal->obterImagem($id);
		
		// Se a imagem foi encontrada
		if ($imagem !== null) {
			$dal = new DalUsuario($this->getConexao());
			$usuario = $dal->obterUsuario(true, $imagem->getUsuarioId());
			$dal = new DalComentario($this->getConexao());

			// Se não recebemos nenhum erro do Controller

			$comentarioErro = "";
			if ($comentarioConteudo !== null && count($comentarioErros) <= 0) {
				$cmt = new Comentario(
					0,
					date("Y-m-d H:i:s"),
					$id,
					$usuarioLogado->getId(),
					$comentarioConteudo
				);

				$dal->criarComentario($cmt);

				$comentarioConteudo = null;

			} else {
				foreach ($comentarioErros as $erro) {
					if (isset(Config::obter("MvcErrors.Imagem.Definicoes")[$erro])) {
						$comentarioErro = Config::obter("MvcErrors.Imagem.Definicoes")[$erro];
					}
				}
			}

			$comentarios = $dal->listarComentarios($imagem->getId());
			$comentariosArray = [];

			$dal = new DalUsuario($this->getConexao());

			foreach ($comentarios as $cmt) {
				array_push($comentariosArray, [
						"comentario" => $cmt,
						"autor" => $dal->obterUsuario(true, $cmt->getUsuarioId())
					]
				);
			}

			return new ImagemView($usuarioLogado, $imagem, $usuario, $comentariosArray, $comentarioConteudo, $comentarioErro);
		} else {
			// 404 Not Found
			return $this->notFound($usuarioLogado);
		}
	}

	// Utiliza nossa ErroView que já está pronta
	public function notFound($usuarioLogado) {
		return new ErroView(
			$usuarioLogado,
			'A imagem que você está procurando não existe.',
			'HTTP - 404 Not Found'
		);
	}
}

?>