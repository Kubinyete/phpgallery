<?php
/**
 * Uma View que representa nossa página de enviar imagens
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class EnviarView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $erroMensagem="", $imagem=null, $imagemTitulo="", $imagemDescricao="", $imagemPrivada=false) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "enviar";
		$this->itens['html_titulo'] = 'Enviar imagem';
		$this->itens["img_titulo"] = $imagemTitulo;
		$this->itens["img_descricao"] = $imagemDescricao;
		$this->itens["img_privada"] = $imagemPrivada;
		$this->itens["erro_dialogo"] = $erroMensagem;
		$this->itens["imgti_maxlength"] = Config::obter("Imagens.max_tamanho_titulo");
		$this->itens["imgde_maxlength"] = Config::obter("Imagens.max_tamanho_descricao");
	}
}

?>