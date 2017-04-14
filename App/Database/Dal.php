<?php
/**
 * Classe responsável por representar uma Database Access Layer mestre
 * para que diversas outras herdem estas mesmas carácteristicas
 */

namespace App\Database;

use App\Http\Resposta;
use Config\Config;

abstract class Dal {
	protected $conexao;

	public function __construct($conexao) {
		$this->conexao = $conexao;
	}

	public function getConexao() {
		return $this->conexao;
	}

	// Executa um comando SQL através de um objeto SqlComando
	// em caso de falha, redireciona o usuário para uma página de erro e finaliza a execução
	// do script
	protected function executar($sqlComando) {
		if (Config::obter("Database.debug") === true) {
			// Imprimindo o comando na tela para teste
			echo "\n<hr>\n";
			echo "<h1 style='color: rgba(0,0,0,.8)'>Database.debug > Executando o SqlComando...</h1>\n";
			echo "<pre style='background-color: #ddd; color: rgba(0,0,0,.6); width: 100%; word-wrap: break-word; white-space: unset'>Dal::executar() > SqlComando::getComandoString() = ".$sqlComando->getComandoString()."</pre>\n";
			echo "<hr>\n";
		}
			
		$resultados = $this->getConexao()->getConexao()->query($sqlComando->getComandoString());
		
		// Se ocorreu alguma falha ao tentar executar o comando
		if (!$resultados) {
			// Desconecte imediatamente
			$this->getConexao()->desconectar();

			// Se não estivermos em modo DEBUG, redirecione para uma página de erro
			if (Config::obter("Database.debug") !== true) {
				Resposta::erro(Config::obter("Database.Erro.FALHA_COMANDO"), true);
			} else {
				exit();
			}
		}

		return $resultados;
	}
}

?>