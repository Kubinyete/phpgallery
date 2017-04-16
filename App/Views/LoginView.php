<?php
/**
 * Representa a visualização da página de login
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class LoginView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $acao="i", $erroMensagem=null) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "login";
		$this->itens['html_titulo'] = 'Área de autenticação';
		$this->itens["login_acao"] = $acao;
		$this->itens["login_erro_mensagem"] = $erroMensagem;
		$this->itens["loginNome_maxlength"] = Config::obter("Usuarios.max_caracteres_nome");
		$this->itens["loginSenha_maxlength"] = Config::obter("Usuarios.max_caracteres_senha");
		$this->itens["registraNome_maxlength"] = $this->itens["loginNome_maxlength"];
		$this->itens["registraSenha_maxlength"] = $this->itens["loginSenha_maxlength"];
	}
}

?>