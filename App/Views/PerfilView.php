<?php
/**
 * Representa a visualização da página de perfil de um usuário
 */

namespace App\Views;

use App\Views\View;
use Config\Config;

class PerfilView extends View {
	// $templates
	// $itens
	
	public function __construct($usuarioLogado, $usuario, $imagens) {
		parent::__construct($usuarioLogado);

		$this->templates["view"] = "perfil";
		$this->templates["visualizacao_imagem"] = "visualizacao_imagem";
		$this->itens["usr_usuario"] = $usuario;
		$this->itens["imagens"] = $imagens;
		$this->itens["proc_imagens_lista"] = "lista_imagens".'.'.Config::obter("Views.templates_extensao");
		$this->itens["html_titulo"] = "Perfil de ".$usuario->getNome();
		$this->itens["og_titulo"] = $this->itens["html_titulo"];
		$this->itens["og_descricao"] = $usuario->getDescricao(true);
		$this->itens["og_imagem"] = Config::obter("Views.og_url_padrao").$usuario->getImagemUrl(true);
		$this->itens["og_url"] .= $usuario->getLink();
	}
}

?>