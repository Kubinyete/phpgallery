<?php
/**
 * Classe responsável por encapsular uma conexão com o banco de dados
 */

namespace App\Database;

use Config\Config;
use App\Http\Resposta;
use PDO;

class Conexao {
	private $conexao;
	private $stringConexao;
	private $usuario;
	private $senha;

	public function __construct($stringConexao=null, $usuario=null, $senha=null) {
		$this->conexao = null;
		$this->stringConexao = $stringConexao;
		$this->usuario = $usuario;
		$this->senha = $senha;

		$this->conectar();
	}

	public function getConexao() {
		return $this->conexao;
	}

	public function conectar() {
		// Se a conexão está desativada
		if ($this->conexao === null) {
			// Se não temos parâmetros de uma conexão diferente da padrão
			if ($this->stringConexao === null && $this->usuario === null && $this->senha === null) {
				// Use as configurações de ConexaoConfig
				$this->conexao = new PDO(Config::obter('Database.dsn'), Config::obter("Database.usuario"), Config::obter("Database.senha"));
			} else {
				// Use as configurações passadas por parâmetro
				$this->conexao = new PDO($this->stringConexao, $this->usuario, $this->senha);
			}

			// Se não foi possível conectar, envie um erro para o usuário (redrecione o pedido para o nosso processador de pedidos,
			// com a finalidade de mostrar uma tela de erro)
			if ($this->conexao === null) {
				// Apenas faça isso se não estivermos em modo DEBUG
				if (Config::obter("Database.debug") !== true) {
					Resposta::erro(Config::obter("Database.Erro.FALHA_CONEXAO"), true);
				} else {
					exit();
				}
			}
		}
	}

	public function desconectar() {
		if ($this->conexao !== null) {
			$this->conexao = null;
		}
	}
}

?>