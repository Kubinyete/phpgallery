<?php
/**
 * Controlador da página de erro interno (banco de dados)
 */

namespace App\Controllers;

use App\Controllers\Controller;

class ErroController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $codigo) {
		return $this->model->index($usuarioLogado, $codigo);
	}
}

?>