<?php
/**
 * Controlador da página de erro 404
 */

namespace App\Controllers;

use App\Controllers\Controller;

class NotFoundController extends Controller {
	// $model
	
	public function rodar($usuarioLogado) {
		// Não precisaremos processar nenhum parâmetro
		// para listar as imagens recentes
		// retornará uma HomeView para que o script acima possa renderizá-la
		return $this->getModel()->index($usuarioLogado);
	}
}

?>