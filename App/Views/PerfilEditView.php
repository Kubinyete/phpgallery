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
	
	public function __construct($usuarioLogado) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "perfil_edit";
		$this->itens["usrde_maxlength"] = Config::obter("Usuarios.max_tamanho_descricao");
	}
}

?>