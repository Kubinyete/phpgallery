<?php
/**
 * Representa a visualização da página de erro interno (erro no banco de dados)
 */

namespace App\Views;

use App\Views\View;

class ErroView extends View {
	// $templates
	// $itens

	public function __construct($usuarioLogado, $mensagem, $descricao) {
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
				'erro_descricao' => $mensagem,
				'erro_codigo' => $descricao
			]
		);
	}
}

?>