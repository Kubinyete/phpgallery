<?php
/**
 * Representa a visualização da página de login
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class LoginView extends View {
	private $erroMensagem;
	private $usuarioLogado;
	private $acao;

	private $templates = [
		"cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
		"cabecalho_corpo" => "cabecalho_corpo",
		"logo_showcase" => "logo_showcase",
		"login" => "login",
		"rodape" => ViewConfig::TEMPLATE_RODAPE
	];

	public function __construct($usuarioLogado, $acao="i", $erroMensagem=null) {
		$this->erroMensagem = $erroMensagem;
		$this->usuarioLogado = $usuarioLogado;
		$this->acao = $acao;
	}

	public function renderizar() {
		$htmlTitulo = ViewConfig::HTML_TITULO_PADRAO;
		$htmlDescricao = ViewConfig::HTML_DESCRICAO_PADRAO;
		$htmlPalavrasChave = ViewConfig::HTML_PALAVRAS_CHAVE_PADRAO;
		$htmlAutor = ViewConfig::HTML_AUTOR_PADRAO;

		$htmlStylesheet = ViewConfig::CAMINHO_CSS_PADRAO;
		$htmlJavascript = ViewConfig::CAMINHO_JS_PADRAO;

		$caminhoRecursos = ViewConfig::CAMINHO_RECURSOS_PADRAO;
		$phpgalleryVersao = ViewConfig::PHPGALLERY_VERSAO;

		$erroMensagem = &$this->erroMensagem;
		$usuarioLogado = &$this->usuarioLogado;
		$acao = &$this->acao;

		foreach ($this->templates as $templateNome => $templateArquivo) {
			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>