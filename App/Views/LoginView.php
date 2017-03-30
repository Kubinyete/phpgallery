<?php
/**
 * Representa a visualização da página de login
 */

namespace App\Views;

use App\Views\View;

class LoginView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $acao="i", $erroMensagem=null) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "login";
		$this->itens["login_acao"] = $acao;
		$this->itens["login_erro_mensagem"] = $erroMensagem;
	}
}

?>