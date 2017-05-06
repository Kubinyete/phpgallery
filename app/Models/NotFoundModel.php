<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página 404
 */

namespace App\Models;

use App\Models\Model;
use App\Views\ErroView;

class NotFoundModel extends Model {
	// $conexao
	
	public function index($usuarioLogado) {
		return new ErroView(
			$usuarioLogado,
			'A página que você está procurando não existe.',
			'HTTP - 404 Not Found'
		);
	}
}

?>