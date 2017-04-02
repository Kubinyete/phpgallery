<?php
/**
 * Classe responsável por representar uma Database Access Layer mestre
 * para que diversas outras herdem estas mesmas carácteristicas
 */

namespace App\Database;

use App\Database\Erro;
use App\Http\Resposta;
use Config\ConexaoConfig;

abstract class Dal {
	protected $conexao;

	public function __construct($conexao) {
		$this->conexao = $conexao;
	}

	// Executa um comando SQL através de um objeto SqlComando
	// em caso de falha, redireciona o usuário para uma página de erro e finaliza a execução
	// do script
	protected function executar($sqlComando, $salvarModificacoes=false) {
		if (!ConexaoConfig::MODO_DEBUG) {
			$resultadoId = @odbc_exec($this->conexao->getConexao(), $sqlComando->getComandoString());
		} else {
			// Imprimindo o comando na tela para teste
			echo "\n<hr>\n";
			echo "<h1 style='color: rgba(0,0,0,.8)'>ConexaoConfig::MODO_DEBUG > Executando o SqlComando...</h1>\n";
			echo "<pre style='background-color: #ddd; color: rgba(0,0,0,.6); width: 100%; word-wrap: break-word; white-space: unset'>Dal::executar() > SqlComando::getComandoString() = ".$sqlComando->getComandoString()."</pre>\n";
			echo "<hr>\n";
			
			$resultadoId = odbc_exec($this->conexao->getConexao(), $sqlComando->getComandoString());
		}
		
		// Se ocorreu alguma falha ao tentar executar o comando
		if (!$resultadoId) {
			// Desconecte imediatamente
			$this->conexao->desconectar();

			// Se não estivermos em modo DEBUG, redirecione para uma página de erro
			if (!ConexaoConfig::MODO_DEBUG) {
				Resposta::erro(Erro::DBERRO_FALHA_COMANDO, true);
			}
		}

		// Se estamos alterando os registros e queremos salvar essas modifcações
		if ($salvarModificacoes) {
			if (!ConexaoConfig::MODO_DEBUG) {
				$estaOk = @odbc_commit($this->conexao->getConexao());
			} else {
				$estaOk = odbc_commit($this->conexao->getConexao());
			}

			// Se não foi possível salvar as alterações, desconecte imediatamente e envie um erro
			if (!$estaOk) {
				$this->conexao->desconectar();

				if (!ConexaoConfig::MODO_DEBUG) {
					Resposta::erro(Erro::DBERRO_FALHA_SALVAR, true);
				}
			}
		}

		return $resultadoId;
	}
}

?>