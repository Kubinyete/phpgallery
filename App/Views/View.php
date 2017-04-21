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
			"anim_processando" => "anim_processando",
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
			"css" => Config::obter("Views.css"),
			"js" => Config::obter("Views.js"),
			"favicon" => Config::obter("Views.favicon"),
			"href_home" => Config::obter("Views.href_home"),
			"href_perfil" => Config::obter("Views.href_perfil"),
			"href_enviar" => Config::obter("Views.href_enviar"),
			"href_login" => Config::obter("Views.href_login"),
			"href_login_sair" => Config::obter("Views.href_login_sair"),
			"href_editar_perfil" => Config::obter("Views.href_editar_perfil"),
			"recursos" => Config::obter("Views.recursos"),
			"versao" => Config::obter("VERSAO"),
			"usr_logado" => $usuarioLogado,
			"erro_dialogo" => "" // <-- Opcional, inclui uma visualização de erro e ativa automaticamente
		];
	}

	protected function atualizarTemplates($arr) {
		if (is_array($arr)) {
			foreach ($arr as $chave => $valor) {
				$this->templates[$chave] = $valor;
			}
		}
	}

	protected function atualizarItens($arr) {
		if (is_array($arr)) {
			foreach ($arr as $chave => $valor) {
				$this->itens[$chave] = $valor;
			}
		}
	}

	// Importa todas as templates da nossa View e passa para cada uma uma coleção de itens
	public function renderizar() {
		$itens = &$this->itens;
		$dirTemplates = Config::obter("Views.diretorio_templates");
		$dirExtensao = Config::obter("Views.templates_extensao");
		
		foreach ($this->templates as $templateArquivo) {
			$arquivo = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.$dirTemplates.DIRECTORY_SEPARATOR.$templateArquivo.'.'.$dirExtensao;

			if (file_exists($arquivo)) {
				include $arquivo;
			}
		}
	}
}

?>