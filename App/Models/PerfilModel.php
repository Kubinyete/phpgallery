<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de perfil de um usuário
 */

namespace App\Models;

use App\Models\Model;
use App\Database\DalImagem;
use App\Database\DalUsuario;
use App\Views\PerfilView;
use App\Views\NotFoundView;

class PerfilModel extends Model {
	public function index($usuarioLogado, $usuarioNome="") {
		$dal = new DalUsuario($this->conexao);
		$usuario = $dal->obterUsuario(false, $usuarioNome);
		
		if ($usuario !== null) {
			$dal = new DalImagem($this->conexao);
			$imagens = $dal->listarImagensUsuario($usuario->getId());
			return new PerfilView($usuarioLogado, $usuario, $imagens);
		} else {
			return $this->notFound($usuarioLogado);
		}
	}

	public function notFound($usuarioLogado) {
		return new NotFoundView($usuarioLogado);
	}
}

?>