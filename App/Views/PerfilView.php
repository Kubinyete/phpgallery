<?php
/**
 * Representa a visualização da página de perfil de um usuário
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class PerfilView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $usuario, $imagens) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'perfil',
				'visualizacao_imagem' => 'visualizacao_imagem'
			]
		);

		$this->atualizarItens(
			[
				'usr_usuario' => $usuario,
				'imagens' => $imagens,
				'proc_imagens_lista' => 'lista_imagens'.'.'.Config::obter('Views.templates_extensao'),
				'html_titulo' => 'Perfil de '.$usuario->getNome(),
				'og_titulo' => 'Perfil de '.$usuario->getNome(),
				'og_descricao' => $usuario->getDescricao(true),
				'og_imagem' => Config::obter('Views.og_url_padrao').$usuario->getImagemUrl(true),
				'og_url' => Config::obter('Views.og_url_padrao').$usuario->getLink()
			]
		);
	}
}

?>