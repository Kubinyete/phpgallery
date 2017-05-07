<?php
/**
 * Controlador do pedido de download
 */

namespace App\Controllers;

use App\Controllers\Controller;

class DownloadController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $id=0) {
		$id = intval($id);

		if ($id > 0) {
			return $this->getModel()->index($usuarioLogado, $id);
		} else {
			return $this->getModel()->notFound($usuarioLogado);
		}
	}
}

?>