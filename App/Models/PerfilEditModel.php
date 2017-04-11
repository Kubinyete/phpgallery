<?php
/**
 * Representará a nossa camada Model da estruturação MVC
 * obtêm dados necessários para mostrar uma página de edição de perfil do usuário
 */

namespace App\Models;

use App\Models\Model;
use App\Views\PerfilEditView;
use App\Views\NotFoundView;

class PerfilEditModel extends Model {
	// $conexao
	
	public function index($usuarioLogado) {
		return new PerfilEditView($usuarioLogado);
	}

	public function notFound($usuarioLogado) {
		return new NotFoundView($usuarioLogado);
	}
}

?>