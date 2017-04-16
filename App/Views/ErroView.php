<?php
/**
 * Representa a visualização da página de erro interno (erro no banco de dados)
 */

namespace App\Views;

use App\Views\View;

class ErroView extends View {
	// $templates
	// $itens

	public function __construct($usuarioLogado, $mensagem) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "erro";
		$this->itens['html_titulo'] = 'Erro';
		$this->itens["erro_titulo"] = "Aparentemente algo deu muito errado por aqui :(";
		$this->itens["erro_descricao"] = $mensagem;
		$this->itens["erro_codigo"] = "DBERRO_ERRO";
	}
}

?>