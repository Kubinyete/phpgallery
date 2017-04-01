<?php
/**
 * Controlador da página de imagem
 */

namespace App\Controllers;

use App\Controllers\Controller;

class ImagemController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $id=0) {
		$id = intval($id);

		if ($id <= 0) {
			return $this->model->notFound($usuarioLogado);
		} else {
			return $this->model->index($usuarioLogado, $id);
		}
	}
}

?>