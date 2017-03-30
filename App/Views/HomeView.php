<?php
/**
 * Representa a visualização da página inicial Home
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class HomeView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagens) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "home";
		$this->itens["imagens"] = $imagens;
		$this->itens["proc_imagens_lista"] = "lista_imagens".ViewConfig::EXTENSAO_TEMPLATES;
	}
}

?>