<?php
/**
 * Representa a visualização da página de imagem
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;

class ImagemView extends View {
	private $imagem;
	private $autor;
	private $usuarioLogado;
	private $comentarios;
	private $templates = [
		"cabecalho" => ViewConfig::TEMPLATE_CABECALHO,
		"cabecalho_corpo" => "cabecalho_corpo",
		"logo_showcase" => "logo_showcase",
		"imagem" => "imagem",
		"rodape" => ViewConfig::TEMPLATE_RODAPE
	];

	public function __construct($usuarioLogado, $imagem, $autor, $comentarios) {
		$this->imagem = $imagem;
		$this->autor = $autor;
		$this->usuarioLogado = $usuarioLogado;
		$this->comentarios = $comentarios;
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

		$imagem = &$this->imagem;
		$autor = &$this->autor;
		$usuarioLogado = &$this->usuarioLogado;
		$comentarios = &$this->comentarios;

		foreach ($this->templates as $templateNome => $templateArquivo) {
			include dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.ViewConfig::DIRETORIO_TEMPLATES.DIRECTORY_SEPARATOR.$templateArquivo.ViewConfig::EXTENSAO_TEMPLATES;
		}
	}
}

?>