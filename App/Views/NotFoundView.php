<?php
/**
 * Representa a visualização da página 404
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class NotFoundView extends View {
	private $templates = [
		"cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
		"cabecalho_corpo" => "cabecalho_corpo",
		"logo_showcase" => "logo_showcase",
		"erro" => "erro",
		"rodape" => ViewConfig::TEMPLATE_RODAPE
	];

	public function renderizar() {
		$htmlTitulo = ViewConfig::HTML_TITULO_PADRAO;
		$htmlDescricao = ViewConfig::HTML_DESCRICAO_PADRAO;
		$htmlPalavrasChave = ViewConfig::HTML_PALAVRAS_CHAVE_PADRAO;
		$htmlAutor = ViewConfig::HTML_AUTOR_PADRAO;

		$htmlStylesheet = ViewConfig::CAMINHO_CSS_PADRAO;
		$htmlJavascript = ViewConfig::CAMINHO_JS_PADRAO;

		$caminhoRecursos = ViewConfig::CAMINHO_RECURSOS_PADRAO;
		$phpgalleryVersao = ViewConfig::PHPGALLERY_VERSAO;

		$erroTitulo = "Aparentemente algo deu muito errado por aqui :(";
		$erroDescricao = "A página que você está procurando não existe.";
		$erroAbrev = "HTTP 404 Not Found";

		foreach ($this->templates as $templateNome => $templateArquivo) {
			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>