<?php
/**
 * Controlador da página de editar perfil
 */

namespace App\Controllers;

use App\Controllers\Controller;

class PerfilEditController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $imagem=null, $descricao=null) {
		if ($usuarioLogado !== null) {
			return ($imagem !== null || $descricao !== null) ? $this->model->modificar($usuarioLogado, $imagem, $descricao) : $this->model->index($usuarioLogado);
		} else {
			return $this->model->notFound($usuarioLogado);
		}
	}
}

?>