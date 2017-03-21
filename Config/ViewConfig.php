<?php
/**
 * Atributos utilizados pela classe View para conter configurações e caminhos
 */

namespace Config;

class ViewConfig {
	// Nome do diretório aonde as templates são armazenadas
	// na pasta raiz
	const DIRETORIO_TEMPLATES = "templates";
	// Extensão dos arquivos de template
	const EXTENSAO_TEMPLATES = ".php";
	
	// Arquivo de cabeçalho
	const TEMPLATE_CABECALHO = "cabecalho";
	// Arquivo de rodapé
	const TEMPLATE_RODAPE = "rodape";
	
	// Arquivo CSS padrão
	const CAMINHO_CSS_PADRAO = "/static/css/phpgallery.css";
	// Arquivo JS padrão
	const CAMINHO_JS_PADRAO = "/static/js/phpgallery.js";
	// Caminho para os recursos (imagens, etc)
	// Nota: não esqueca do '/' no final
	const CAMINHO_RECURSOS_PADRAO = "/static/resources/";
	
	// HTML: Tag title padrão
	const HTML_TITULO_PADRAO = "PHPGallery";
	// HTML: Tag meta description padrão
	const HTML_DESCRICAO_PADRAO = "Uma aplicação web que permite o envio e a hospedagem de imagens aos usuários registrados.";
	// HTML: Tag meta keywords padrão
	const HTML_PALAVRAS_CHAVE_PADRAO = "galeria, imagens, envio, upload, wallpaper, php, captura de tela, widescreen, papel de parede";
	// HTML: Tag meta author padrão
	const HTML_AUTOR_PADRAO = "Vitor Kubinyete";

	// Número da versão da aplicação, para se mostrada em uma visualização
	const PHPGALLERY_VERSAO = "2.0";
}

?>