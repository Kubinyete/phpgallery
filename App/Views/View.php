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
			"view" => "", // Deverá ser modificado pelas visualizações filhas desta
			"erro_dialogo" => "erro_dialogo",
			"visualizacao_imagem" => "", // <-- Opcional, visualização JavaScript de imagens
			"temp_rodape" => ViewConfig::TEMPLATE_RODAPE
		];

		$this->itens = [
			"html_titulo" => ViewConfig::HTML_TITULO_PADRAO,
			"html_descricao" => ViewConfig::HTML_DESCRICAO_PADRAO,
			"html_palavras_chave" => ViewConfig::HTML_PALAVRAS_CHAVE_PADRAO,
			"html_autor" => ViewConfig::HTML_AUTOR_PADRAO,
			"og_url" => ViewConfig::OG_URL_PADRAO,
			"og_tipo" => ViewConfig::OG_TIPO_PADRAO,
			"og_titulo" => ViewConfig::OG_TITULO_PADRAO,
			"og_descricao" => ViewConfig::OG_DESCRICAO_PADRAO,
			"og_imagem" => ViewConfig::OG_IMAGEM_PADRAO,
			"og_nome_site" => ViewConfig::OG_NOME_SITE_PADRAO,
			"og_idioma" => ViewConfig::OG_IDIOMA_PADRAO,
			"css" => ViewConfig::CAMINHO_CSS_PADRAO,
			"js" => ViewConfig::CAMINHO_JS_PADRAO,
			"recursos" => ViewConfig::CAMINHO_RECURSOS_PADRAO,
			"versao" => ViewConfig::PHPGALLERY_VERSAO,
			"usr_logado" => $usuarioLogado,
			"erro_dialogo" => ""
		];
	}

	// Importa todas as templates da nossa View e passa para cada uma uma coleção de itens
	public function renderizar() {
		$itens = &$this->itens; 
		
		foreach ($this->templates as $templateArquivo) {
			$arquivo = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;

			if (file_exists($arquivo)) {
				include $arquivo;
			}
		}
	}
}

?>