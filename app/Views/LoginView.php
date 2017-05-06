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

		$this->atualizarTemplates(
			[
				'view' => 'login'
			]
		);

		$this->atualizarItens(
			[
				'html_titulo' => 'Área de autenticação',
				'login_acao' => $acao,
				'login_erro_mensagem' => $erroMensagem,
				'loginNome_maxlength' => Config::obter('Usuarios.max_caracteres_nome'),
				'loginSenha_maxlength' => Config::obter('Usuarios.max_caracteres_senha'),
				'registraNome_maxlength' => Config::obter('Usuarios.max_caracteres_nome'),
				'registraSenha_maxlength' => Config::obter('Usuarios.max_caracteres_senha')
			]		
		);
	}
}

?>