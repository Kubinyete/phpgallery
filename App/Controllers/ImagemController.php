<?php
/**
 * Controlador da página de imagem
 */

namespace App\Controllers;

use App\Controllers\Controller;
use Config\ComentarioConfig;
use App\MvcErrors\ImagemErro;
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
						throw new Exception(ImagemErro::COMENTARIO_TAMANHO_INVALIDO);
					} else if (strlen($comentarioConteudo) > ComentarioConfig::MAX_TAMANHO_COMENTARIO) {
						throw new Exception(ImagemErro::MAX_TAMANHO_COMENTARIO);
					} else if ($usuarioLogado === null) {
						throw new Exception(ImagemErro::NECESSITA_LOGAR);
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