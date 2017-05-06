<?php
/**
 * Representa a visualização da página de imagem
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class ImagemView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagem, $autor, $comentarios, $comentarioConteudo=null, $comentarioErro="") {
		parent::__construct($usuarioLogado);

		$this->atualizarTemplates(
			[
				'view' => 'imagem'
			]
		);

		$this->atualizarItens(
			[
				'img_imagem' => $imagem,
				'img_autor' => $autor,
				'img_comentarios' => $comentarios,
				'html_titulo' => $imagem->getTitulo(true),
				'og_url' => Config::obter('Views.og_url_padrao').$imagem->getLink(),
				'og_titulo' => $imagem->getTitulo(true),
				'og_descricao' => $imagem->getDescricao(true),
				'og_imagem' => Config::obter('Views.og_url_padrao').$imagem->getImagemUrl(true),
				'cmt_conteudo' => $comentarioConteudo,
				'erro_dialogo' => $comentarioErro,
				'cmtcon_maxlength' => Config::obter('Comentarios.max_tamanho')
			]
		);
	}
}

?>