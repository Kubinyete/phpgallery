<?php
/**
 * Representará a nossa camada Model da estruturação MVC
 * obtêm dados necessários para mostrar uma página Home
 */

namespace App\Models;

use App\Models\Model;
use App\Views\HomeView;
use App\Database\DalImagem;

class HomeModel extends Model {
	// $conexao;
	
	// Não vamos receber nada do controlador
	// pois mostrar as imagens recentes não precisará de um parâmetro
	// (por enquanto)
	public function index() {
		$dal = new DalImagem($this->conexao);
		$imagens = $dal->listarRecentes();
		return new HomeView($imagens);
	}
}

?>