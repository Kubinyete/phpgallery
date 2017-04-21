<?php
/**
 * Representa a visualização da página 404
 */

namespace App\Views;

use App\Views\View;

class NotFoundView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'erro'
			]
		);

		$this->atualizarItens(
			[
				'html_titulo' => 'Erro',
				'erro_titulo' => 'Aparentemente algo deu muito errado por aqui :(',
				'erro_descricao' => 'A página que você está procurando não existe.',
				'erro_codigo' => 'HTTP 404 Not Found'
			]
		);
	}
}

?>