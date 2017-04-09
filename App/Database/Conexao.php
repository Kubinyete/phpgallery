<?php
/**
 * Classe responsável por encapsular uma conexão com o banco de dados
 */

namespace App\Database;

use Config\Config;
use App\Http\Resposta;

class Conexao {
	private $conexao;
	private $stringConexao;
	private $usuario;
	private $senha;

	public function __construct($stringConexao=null, $usuario=null, $senha=null) {
		$this->conexao = false;
		$this->stringConexao = $stringConexao;
		$this->usuario = $usuario;
		$this->senha = $senha;

		$this->conectar();
	}

	public function getConexao() {
		return $this->conexao;
	}

	public static function getStringConexao($server, $database, $autenticacao_windows, $usuario="", $senha="") {
		return 'Driver=SQL Server;'.'Server='.$server.';Database='.$database.(($autenticacao_windows) ? ';Trusted_Connection=yes;' : ';User Id='.$usuario.';Password='.$senha.';');
	}

	public function conectar() {
		// Se a conexão está desativada
		if (!$this->conexao) {
			// Se não temos parâmetros de uma conexão diferente da padrão
			if ($this->stringConexao === null) {
				// Use as configurações de ConexaoConfig
				
				if (Config::obter("Database.debug") !== true) {
					$this->conexao = @odbc_connect(
						self::getStringConexao(
							Config::obter("Database.server"),
							Config::obter("Database.database"),
							Config::obter("Database.usar_autenticacao_windows"),
							Config::obter("Database.usuario"),
							Config::obter("Database.senha")
						), 
						Config::obter("Database.usuario"), 
						Config::obter("Database.senha")
					);
				} else {
					$this->conexao = odbc_connect(
						self::getStringConexao(
							Config::obter("Database.server"),
							Config::obter("Database.database"),
							Config::obter("Database.usar_autenticacao_windows"),
							Config::obter("Database.usuario"),
							Config::obter("Database.senha")
						), 
						Config::obter("Database.usuario"), 
						Config::obter("Database.senha")
					);
				}

			} else {
				// Use as configurações passadas por parâmetro
				if (Config::obter("Database.debug") !== true) {
					$this->conexao = @odbc_connect(
						$this->stringConexao, 
						$this->usuario, 
						$this->senha
					);
				} else {
					$this->conexao = odbc_connect(
						$this->stringConexao, 
						$this->usuario, 
						$this->senha
					);
				}
			}

			// Se não foi possível conectar, envie um erro para o usuário (redrecione o pedido para o nosso processador de pedidos,
			// com a finalidade de mostrar uma tela de erro)
			if (!is_resource($this->conexao)) {
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
		// Apenas desconecte se o objeto $conexao for resource
		if (is_resource($this->conexao)) {
			if (Config::obter("Database.debug") !== true) {
				@odbc_close($this->conexao);
				$this->conexao = false;
			} else {
				odbc_close($this->conexao);
				$this->conexao = false;
			}
		}
	}
}

?>