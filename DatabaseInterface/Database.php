<?php
namespace PHPGallery\DatabaseInterface;

require_once "DatabaseErroDefinicoes.php";
require_once "DatabaseErroRedirecionador.php";

/**
 * Classe mestre responsável por representar uma Database Access Layer
 */
class DatabaseAL {
	protected $_conexao;

	public function __construct($conexao) {
		$this->_conexao = $conexao;
	}

	// Função principal de executar um SQL, todas as interfaces de acesso ao banco de dados precisará desta função
	public function executar($sql, $salvar=false) {
		$resultado_id = @odbc_exec($this->_conexao->get_conexao(), $sql);

		// Se erramos algum comando, redirecione para a página de erro na pasta local & pare a execução do script
		if (!$resultado_id) {
			DatabaseErroRedirecionador::enviar_erro(DE_FALHA_EFETUAR_COMANDO);
		}

		// Salvar modificações?
		if ($salvar) {
			$ok = @odbc_commit($this->_conexao->get_conexao());

			if (!$ok) {
				DatabaseErroRedirecionador::enviar_erro(DE_FALHA_SALVAR);
			}
		}

		return $resultado_id;
	}

	// Função responsável por filtrar todas as escape strings em uma frase, evitando problemas futuros na hora de inserir. Ex: It's a beautiful day outside -> It''s a beautiful day outside
	public static function filtrar_escape_string_mssql($string) {
		$string = strval($string);
		$retorno = "";

		for ($i = 0; $i < strlen($string); $i++) {
			if ($string[$i] === "'") {
				$retorno .= "'" . $string[$i];
			} else {
				$retorno .= $string[$i];
			}
		}

		return $retorno;
	}
}

?>
