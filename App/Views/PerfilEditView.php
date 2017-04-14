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

		$this->templates["view"] = "perfil_edit";
		$this->itens["imagens"] = $imagens;
		$this->itens["proc_imagens_fundo_lista"] = "lista_imagens_fundo".'.'.Config::obter("Views.templates_extensao");
		$this->itens["erro_dialogo"] = $erro;
		$this->itens["usrde_maxlength"] = Config::obter("Usuarios.max_tamanho_descricao");
	}
}

?>