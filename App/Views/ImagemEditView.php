<?php
/**
 * Representa a visualização da página de edição de imagem
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class ImagemEditView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagem) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'imagem_edit',
			]
		);

		$this->atualizarItens(
			[
				'imagem' => $imagem,
				'imgti_maxlength' => Config::obter('Imagens.max_tamanho_titulo'),
				'imgde_maxlength' => Config::obter('Imagens.max_tamanho_descricao')
			]
		);
	}
}

?>