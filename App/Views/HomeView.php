<?php
/**
 * Representa a visualização da página inicial Home
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class HomeView extends View {
	// $objetos
	
	private $templates = [
		"cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
		"cabecalho_corpo" => "cabecalho_corpo",
		"logo_showcase" => "logo_showcase",
		"home" => "home",
		"rodape" => ViewConfig::TEMPLATE_RODAPE
	];

	public function renderizar() {
		foreach ($this->templates as $templateNome => $templateArquivo) {
			$caminhoRecursos = ViewConfig::CAMINHO_RECURSOS_PADRAO;

			switch ($templateNome) {
				case "cabecalho":
					$htmlTitulo = ViewConfig::HTML_TITULO_PADRAO;
					$htmlDescricao = ViewConfig::HTML_DESCRICAO_PADRAO;
					$htmlPalavrasChave = ViewConfig::HTML_PALAVRAS_CHAVE_PADRAO;
					$htmlAutor = ViewConfig::HTML_AUTOR_PADRAO;

					$htmlStylesheet = ViewConfig::CAMINHO_CSS_PADRAO;
					$htmlJavascript = ViewConfig::CAMINHO_JS_PADRAO;
					break;
				case "logo_showcase":
					$phpgalleryVersao = ViewConfig::PHPGALLERY_VERSAO;
					break;
				case "home":
					$imagens = &$this->objetos["imagens"];
					break;
			}

			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>