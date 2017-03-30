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

		$this->templates["view"] = "erro";
		$this->itens["erro_titulo"] = "Aparentemente algo deu muito errado por aqui :(";
		$this->itens["erro_descricao"] = "A página que você está procurando não existe.";
		$this->itens["erro_codigo"] = "HTTP 404 Not Found";
	}
}

?>