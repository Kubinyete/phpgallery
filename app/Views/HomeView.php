<?php
/**
 * Representa a visualização da página inicial Home
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class HomeView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagens) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'home',
				'visualizacao_imagem' => 'visualizacao_imagem'
			]
		);

		$this->atualizarItens(
			[
				'imagens' => $imagens,
				'proc_imagens_lista' => 'lista_imagens'.'.'.Config::obter("Views.templates_extensao")
			]
		);
	}
}

?>