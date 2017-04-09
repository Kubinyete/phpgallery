<?php
/**
 * Controlador da página de imagem
 */

namespace App\Controllers;

use App\Controllers\Controller;
use Config\Config;
use Exception;

class ImagemController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $id=0, $comentarioConteudo=null) {
		// Se for passado um valor inválido ou nulo, o $id receberá 0 em caso de falha na conversão
		$id = intval($id);

		// Se o id não for passaado ou é inválido, envie logo uma página 404
		if ($id <= 0) {
			return $this->model->notFound($usuarioLogado);
		} else {
			// Tente obter a página da imagem ou enviar um comentário
			
			$comentarioErros = [];
			if ($comentarioConteudo !== null) {
				$comentarioConteudo = trim($comentarioConteudo);

				try {
					// Validação do estado do comentário
					if (strlen($comentarioConteudo) <= 0) {
						throw new Exception(Config::obter("MvcErrors.Imagem.COMENTARIO_TAMANHO_INVALIDO"));
					} else if (strlen($comentarioConteudo) > Config::obter("Comentarios.max_tamanho")) {
						throw new Exception(Config::obter("MvcErrors.Imagem.COMENTARIO_TAMANHO_LIMITE"));
					} else if ($usuarioLogado === null) {
						throw new Exception(Config::obter("MvcErrors.Imagem.COMENTARIO_NECESSITA_LOGAR"));
					}

				} catch (Exception $e) {
					array_push($comentarioErros, $e->getMessage());
				}
			}

			return $this->model->index($usuarioLogado, $id, $comentarioConteudo, $comentarioErros);
		}
	}
}

?>