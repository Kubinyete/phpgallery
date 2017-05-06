<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de perfil de um usuário
 */

namespace App\Models;

use App\Models\Model;
use App\Database\DalImagem;
use App\Database\DalUsuario;
use App\Views\PerfilView;
use App\Views\ErroView;

class PerfilModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $usuarioNome="") {
		$dal = new DalUsuario($this->getConexao());
		$usuario = $dal->obterUsuario(false, $usuarioNome);
		
		// Se o usuário existe	
		if ($usuario !== null) {
			$dal = new DalImagem($this->getConexao());
			$imagens = $dal->listarImagensUsuario($usuario->getId());
			return new PerfilView($usuarioLogado, $usuario, $imagens);
		} else {
			// 404 Not Found
			return $this->notFound($usuarioLogado);
		}
	}

	// Utiliza a ErroView já pronta
	public function notFound($usuarioLogado) {
		return new ErroView(
			$usuarioLogado,
			'O usuário que você está procurando não existe.',
			'HTTP - 404 Not Found'
		);
	}
}

?>