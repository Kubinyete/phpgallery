<?php
/**
 * Classe responsável por atualizar o status de determinado usuário
 */

namespace App\Status;

use App\Database\DalUsuario;
use Config\UsuarioConfig;

class Status {
	private $conexao;
	private $usuario;

	public function __construct($conexao, $usuario) {
		$this->conexao = $conexao;
		$this->usuario = $usuario;
	}

	// Realiza um 'batimento' no status do usuário (sua timestamp)
	public function heartbeat() {
		$dal = new DalUsuario($this->conexao);
		$this->usuario->setOnlineTimestamp(time());
		$dal->atualizarUsuario($this->usuario);
	}

	// Altera o status do usuário para offline
	public function offline() {
		$dal = new DalUsuario($this->conexao);
		$this->usuario->setOnlineTimestamp($this->usuario->getOnlineTimestamp() - UsuarioConfig::PERIODO_ONLINE);
		$dal->atualizarUsuario($this->usuario);
	}

	// Retorna se o usuário encapsulado está online
	public function estaOnline() {
		return $this->usuario->estaOnline();
	}
}

?>