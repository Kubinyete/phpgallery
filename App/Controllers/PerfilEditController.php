<?php
/**
 * Controlador da página de editar perfil
 */

namespace App\Controllers;

use App\Controllers\Controller;

class PerfilEditController extends Controller {
	// $model
	
	public function rodar($usuarioLogado) {
		if ($usuarioLogado !== null) {
			return $this->model->index($usuarioLogado);
		} else {
			return $this->model->notFound($usuarioLogado);
		}
	}
}

?>