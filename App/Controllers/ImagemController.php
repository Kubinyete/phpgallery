<?php
/**
 * Controlador da página de imagem
 */

namespace App\Controllers;

use App\Controllers\Controller;

class ImagemController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $id=0) {
		// Se for passado um valor inválido ou nulo, o $id receberá 0 em caso de falha na conversão
		$id = intval($id);

		// Se o id não for passaado ou é inválido, envie logo uma página 404
		if ($id <= 0) {
			return $this->model->notFound($usuarioLogado);
		} else {
			// Tente obter a página da imagem
			return $this->model->index($usuarioLogado, $id);
		}
	}
}

?>