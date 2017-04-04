<?php
/**
 * Representa a visualização da página de login
 */

namespace App\Views;

use App\Views\View;
use App\UsuarioConfig;

class LoginView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $acao="i", $erroMensagem=null) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "login";
		$this->itens["login_acao"] = $acao;
		$this->itens["login_erro_mensagem"] = $erroMensagem;
		$this->itens["loginNome_maxlength"] = UsuarioConfig::MAX_CARACTERES_NOME;
		$this->itens["loginSenha_maxlength"] = UsuarioConfig::MAX_CARACTERES_SENHA;
		$this->itens["registraNome_maxlength"] = $this->itens["loginNome_maxlength"]
		$this->itens["registraSenha_maxlength"] = $this->itens["loginSenha_maxlength"]
	}
}

?>