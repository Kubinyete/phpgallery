<?php
/**
 * Controlador da página de edição de imagem
 */

namespace App\Controllers;

use App\Controllers\Controller;

class ImagemEditController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $imagemId=null) {
		$imagemId = intval($imagemId);

		if ($imagemId <= 0) {
			return $this->getModel()->notFound($usuarioLogado);
		} else {
			if ($usuarioLogado === null) {
				return $this->getModel()->forbidden($usuarioLogado);
			} else {
				return $this->getModel()->index($usuarioLogado, $imagemId);
			}
		}
	}
}

?>