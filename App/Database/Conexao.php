<?php
/**
 * Classe responsável por encapsular uma conexão com o banco de dados
 */

namespace App\Database;

use Config\ConexaoConfig;
use App\Database\Erro;
use App\Http\Resposta;

class Conexao {
	protected $conexao;
	protected $stringConexao;
	protected $usuario;
	protected $senha;

	public function __construct($stringConexao=null, $usuario=null, $senha=null) {
		$this->conexao = false;
		$this->stringConexao =$stringConexao;
		$this->usuario = $usuario;
		$this->senha = $senha;

		$this->conectar();
	}

	public function getConexao() {
		return $this->conexao;
	}

	public function conectar() {
		if (!$this->conexao) {
			if ($this->stringConexao === null) {
				// Use as configurações de ConexaoConfig
				if (!ConexaoConfig::MODO_DEBUG) {
					$this->conexao = @odbc_connect(ConexaoConfig::getStringConexao(), ConexaoConfig::USUARIO, ConexaoConfig::SENHA);
				} else {
					$this->conexao = odbc_connect(ConexaoConfig::getStringConexao(), ConexaoConfig::USUARIO, ConexaoConfig::SENHA);
				}
			} else {
				// Use as configurações passadas por parâmetro
				if (!ConexaoConfig::MODO_DEBUG) {
					$this->conexao = @odbc_connect($this->stringConexao, $this->usuario, $this->senha);
				} else {
					$this->conexao = odbc_connect($this->stringConexao, $this->usuario, $this->senha);
				}
			}

			// Se não foi possível conectar, envie um erro para o usuário (redrecione o pedido para o nosso processador de pedidos,
			// com a finalidade de mostrar uma tela de erro)
			if (!is_resource($this->conexao)) {
				if (!ConexaoConfig::MODO_DEBUG) {
					Resposta::erro(Erro::DBERRO_FALHA_CONEXAO, true);
				}
			}
		}
	}

	public function desconectar() {
		if (is_resource($this->conexao)) {
			if (!ConexaoConfig::MODO_DEBUG) {
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