<?php
/**
 * Classe responsável por atualizar o status de determinado usuário
 */

namespace App\Status;

use App\Database\DalUsuario;
use Config\Config;

class Status {
	private $conexao;
	private $usuario;

	public function __construct($conexao, $usuario) {
		$this->conexao = $conexao;
		$this->usuario = $usuario;
	}

	public function getConexao() {
		return $this->conexao;
	}

	public function getUsuario() {
		return $this->usuario;
	}

	public function setUsuario($valor) {
		$this->usuario = $valor;
	}

	// Realiza um 'batimento' no status do usuário (sua timestamp)
	public function heartbeat() {
		$dal = new DalUsuario($this->getConexao());
		$this->getUsuario()->setOnlineTimestamp(time());
		$dal->atualizarUsuario($this->getUsuario());
	}

	// Altera o status do usuário para offline
	public function offline() {
		$dal = new DalUsuario($this->getConexao());
		$this->getUsuario()->setOnlineTimestamp($this->getUsuario()->getOnlineTimestamp() - Config::obter("Usuarios.periodo_online_segundos"));
		$dal->atualizarUsuario($this->getUsuario());
	}

	// Retorna se o usuário encapsulado está online
	public function estaOnline() {
		return $this->getUsuario()->estaOnline();
	}
}

?>