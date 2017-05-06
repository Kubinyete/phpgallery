<?php
/**
 * Controlador da página de editar perfil
 */

namespace App\Controllers;

use App\Controllers\Controller;

class PerfilEditController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $imagem=null, $descricao=null, $imagemFundo=null) {
		if ($usuarioLogado !== null) {
			return ($imagem !== null || $descricao !== null || $imagemFundo !== null) ? $this->getModel()->modificar($usuarioLogado, $imagem, $descricao, $imagemFundo) : $this->model->index($usuarioLogado);
		} else {
			return $this->getModel()->notFound($usuarioLogado);
		}
	}
}

?>