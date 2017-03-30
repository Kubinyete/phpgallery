<?php
/**
 * Representa a visualização da página de perfil de um usuário
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class PerfilView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $usuario, $imagens) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "perfil";
		$this->itens["usr_usuario"] = $usuario;
		$this->itens["imagens"] = $imagens;
		$this->itens["proc_imagens_lista"] = "lista_imagens".ViewConfig::EXTENSAO_TEMPLATES;
	}
}

?>