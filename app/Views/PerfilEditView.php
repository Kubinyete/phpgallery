<?php
/**
 * Representa a visualização da página de edição de perfil do usuário
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class PerfilEditView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $erro='', $imagens=[]) {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'perfil_edit'
			]
		);

		$this->atualizarItens(
			[
				'html_titulo' => 'Editar perfil',
				'imagens' => $imagens,
				'proc_imagens_fundo_lista' => 'lista_imagens_fundo'.'.'.Config::obter('Views.templates_extensao'),
				'erro_dialogo' => $erro,
				'usrde_maxlength' => Config::obter('Usuarios.max_tamanho_descricao')
			]
		);
	}
}

?>