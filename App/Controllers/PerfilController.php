<?php
/**
 * Controlador da página de perfil
 */

namespace App\Controllers;

use App\Controllers\Controller;

class PerfilController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $usuarioNome) {
		if (strlen(trim($usuarioNome)) <= 0) {
			if ($usuarioLogado !== null) {
				return $this->model->index($usuarioLogado, $usuarioLogado);
			} else {
				return $this->model->notFound($usuarioLogado);
			}
		} else {
			return $this->model->index($usuarioLogado, $usuarioNome);
		}
	}
}

?>