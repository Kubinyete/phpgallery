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
	// $conexao
	
	// Não vamos receber nada do controlador
	// pois mostrar as imagens recentes não precisará de um parâmetro
	public function index($usuarioLogado) {
		$dal = new DalImagem($this->getConexao());
		$imagens = $dal->listarRecentes();
		return new HomeView($usuarioLogado, $imagens);
	}
}

?>