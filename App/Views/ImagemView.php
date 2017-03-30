<?php
/**
 * Representa a visualização da página de imagem
 */

namespace App\Views;

use App\Views\View;

class ImagemView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagem, $autor, $comentarios) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "imagem";
		$this->itens["img_imagem"] = $imagem;
		$this->itens["img_autor"] = $autor;
		$this->itens["img_comentarios"] = $comentarios;
	}
}

?>