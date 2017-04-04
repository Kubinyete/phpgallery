<?php
/**
 * Representa a visualização da página de imagem
 */

namespace App\Views;

use App\Views\View;
use Config\ViewConfig;
use Config\ComentarioConfig;

class ImagemView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $imagem, $autor, $comentarios, $comentarioConteudo=null, $comentarioErro="") {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "imagem";
		$this->itens["img_imagem"] = $imagem;
		$this->itens["img_autor"] = $autor;
		$this->itens["img_comentarios"] = $comentarios;
		$this->itens["html_titulo"] = $imagem->getTitulo(true);
		$this->itens["og_url"] .= $imagem->getLink();
		$this->itens["og_titulo"] = $this->itens["html_titulo"];
		$this->itens["og_descricao"] = $imagem->getDescricao(true);
		$this->itens["og_imagem"] = ViewConfig::OG_URL_PADRAO.$imagem->getImagemUrl(true);
		$this->itens["cmt_conteudo"] = $comentarioConteudo;
		$this->itens["erro_dialogo"] = $comentarioErro;
		$this->itens["cmtcon_maxlength"] = ComentarioConfig::MAX_TAMANHO_COMENTARIO;
	}
}

?>