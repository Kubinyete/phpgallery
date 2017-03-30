<?php
/**
 * Classe reponsável por representar uma visualização do MVC
 */

namespace App\Views;

use Config\ViewConfig;

abstract class View {
	protected $templates;
	protected $itens;

	public function __construct($usuarioLogado) {
		$this->templates = [
			"temp_cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
			"temp_cabecalho_corpo" => "cabecalho_corpo",
			"temp_logo_showcase" => "logo_showcase",
			"view" => "",
			"temp_rodape" => ViewConfig::TEMPLATE_RODAPE
		];

		$this->itens = [
			"html_titulo" => ViewConfig::HTML_TITULO_PADRAO,
			"html_descricao" => ViewConfig::HTML_DESCRICAO_PADRAO,
			"html_palavras_chave" => ViewConfig::HTML_PALAVRAS_CHAVE_PADRAO,
			"html_autor" => ViewConfig::HTML_AUTOR_PADRAO,
			"css" => ViewConfig::CAMINHO_CSS_PADRAO,
			"js" => ViewConfig::CAMINHO_JS_PADRAO,
			"recursos" => ViewConfig::CAMINHO_RECURSOS_PADRAO,
			"versao" => ViewConfig::PHPGALLERY_VERSAO,
			"usr_logado" => $usuarioLogado
		];
	}

	public function renderizar() {
		$itens = &$this->itens; 
		
		foreach ($this->templates as $templateArquivo) {
			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>