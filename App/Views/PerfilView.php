<?php
/**
 * Representa a visualização da página de perfil de um usuário
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class PerfilView extends View {
	private $usuario;
	private $imagens;
	private $usuarioLogado;
	private $templates = [
		"cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
		"cabecalho_corpo" => "cabecalho_corpo",
		"logo_showcase" => "logo_showcase",
		"perfil" => "perfil",
		"rodape" => ViewConfig::TEMPLATE_RODAPE
	];

	public function __construct($usuarioLogado, $usuario, $imagens) {
		$this->usuario = $usuario;
		$this->imagens = $imagens;
		$this->usuarioLogado = $usuarioLogado;
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

		$imagens = &$this->imagens;
		$usuario = &$this->usuario;
		$usuarioLogado = &$this->usuarioLogado;
		$processadorListagemImagens = "lista_imagens".ViewConfig::EXTENSAO_TEMPLATES;

		foreach ($this->templates as $templateNome => $templateArquivo) {
			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>