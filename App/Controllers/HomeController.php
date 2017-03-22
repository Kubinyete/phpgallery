<?php
/**
 * Controlador da página inicial, aonde estará disponível as imagens recentes
 */

namespace App\Controllers;

use App\Controllers\Controller;

class HomeController extends Controller {
	// $model
	
	public function rodar($usuarioLogado) {
		// Não precisaremos processar nenhum parâmetro
		// para listar as imagens recentes
		// retornará uma HomeView para que o script acima possa renderizá-la
		return $this->model->index($usuarioLogado);
	}
}

?>