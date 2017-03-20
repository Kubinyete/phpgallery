<?php
/**
 * Representará a nossa camada Model da estruturação MVC
 * obtêm dados necessários para mostrar uma página Home
 */

namespace App\Models;

use App\Models\Model;
use App\Views\HomeView;

class HomeModel extends Model {
	// $dal;
	
	// Não vamos receber nada do controlador
	// pois mostrar as imagens recentes não precisará de um parâmetro
	// (por enquanto)
	public function index() {
		$imagens = $this->dal->listarRecentes();
		return new HomeView(
			[
				"imagens" => $imagens
			]
		);
	}
}

?>