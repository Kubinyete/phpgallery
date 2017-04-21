<?php
/**
 * Uma View que representa nossa página de enviar imagens
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class EnviarView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $erroMensagem="", $imagem=null, $imagemTitulo="", $imagemDescricao="", $imagemPrivada=false) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'enviar'
			]
		);

		$this->atualizarItens(
			[
				'html_titulo' => 'Enviar imagem',
				'img_titulo' => $imagemTitulo,
				'img_descricao' => $imagemDescricao,
				'img_privada' => $imagemPrivada,
				'erro_dialogo' => $erroMensagem,
				'imgti_maxlength' => Config::obter("Imagens.max_tamanho_titulo"),
				'imgde_maxlength' => Config::obter("Imagens.max_tamanho_descricao")
			]
		);
	}
}

?>