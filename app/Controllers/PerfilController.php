<?php
/**
 * Controlador da página de perfil
 */

namespace App\Controllers;

use App\Controllers\Controller;

class PerfilController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $usuarioNome="") {
		if (strlen(trim($usuarioNome)) <= 0) {
			// Se não recebemos nenhum nome de usuário, significa que o usuário logado está solicitando
			// a página de perfil
			if ($usuarioLogado !== null) {
				return $this->getModel()->index($usuarioLogado, $usuarioLogado->getNome());
			} else {
				// 404 Not Found
				return $this->getModel()->notFound($usuarioLogado);
			}
		} else {
			// Tente obter a página de perfil deste usuário
			return $this->getModel()->index($usuarioLogado, $usuarioNome);
		}
	}
}

?>