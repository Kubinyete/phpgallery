<?php
/**
 * Classe reponsável por representar uma visualização do MVC
 */

namespace App\Views;

use Config\Config;

abstract class View {
	protected $templates;
	protected $itens;

	public function __construct($usuarioLogado) {
		$this->templates = [
			"temp_cabecalho" => "cabecalho",
			"temp_cabecalho_corpo" => "cabecalho_corpo",
			"temp_logo_showcase" => "logo_showcase",
			"view" => "", // Deverá ser modificado pelas visualizações filhas desta
			"erro_dialogo" => "erro_dialogo",
			"visualizacao_imagem" => "", // <-- Opcional, visualização JavaScript de imagens
			"temp_rodape" => "rodape"
		];

		$this->itens = [
			"html_titulo" => Config::obter("Views.html_titulo_padrao"),
			"html_descricao" => Config::obter("Views.html_descricao_padrao"),
			"html_palavras_chave" => Config::obter("Views.html_palavras_chave_padrao"),
			"html_autor" => Config::obter("Views.html_autor_padrao"),
			"og_url" => Config::obter("Views.og_url_padrao"),
			"og_tipo" => Config::obter("Views.og_tipo_padrao"),
			"og_titulo" => Config::obter("Views.og_titulo_padrao"),
			"og_descricao" => Config::obter("Views.og_descricao_padrao"),
			"og_imagem" => Config::obter("Views.og_imagem_padrao"),
			"og_nome_site" => Config::obter("Views.og_nome_site_padrao"),
			"og_idioma" => Config::obter("Views.og_idioma_padrao"),
			"css" => "/static/css/phpgallery.css",
			"js" => "/static/js/phpgallery.js",
			"recursos" => "/static/resources/",
			"versao" => Config::obter("VERSAO"),
			"usr_logado" => $usuarioLogado,
			"erro_dialogo" => "" // <-- Opcional, inclui uma visualização de erro e ativa automaticamente
		];
	}

	// Importa todas as templates da nossa View e passa para cada uma uma coleção de itens
	public function renderizar() {
		$itens = &$this->itens; 
		
		foreach ($this->templates as $templateArquivo) {
			$arquivo = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.Config::obter("Views.diretorio_templates").DIRECTORY_SEPARATOR.$templateArquivo.'.'.Config::obter("Views.templates_extensao");

			if (file_exists($arquivo)) {
				include $arquivo;
			}
		}
	}
}

?>