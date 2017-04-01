<?php
/**
 * Uma View que representa nossa página de enviar imagens
 */

namespace App\Views;

use App\Views\View;

class EnviarView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $erroMensagem="", $imagem=null, $imagemTitulo="", $imagemDescricao="", $imagemPrivada=false) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "enviar";
		$this->itens["img_titulo"] = $imagemTitulo;
		$this->itens["img_descricao"] = $imagemDescricao;
		$this->itens["img_privada"] = $imagemPrivada;
		$this->itens["img_erro_mensagem"] = $erroMensagem;
	}
}

?>