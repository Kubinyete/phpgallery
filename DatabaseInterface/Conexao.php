<?php
namespace PHPGallery\DatabaseInterface;

require_once "ConexaoPropriedades.php";
require_once "DatabaseErroDefinicoes.php";
require_once "DatabaseErroRedirecionador.php";

/**
 * Classe responsável por encapsular o objeto de conexão do odbc em nosso sistema
 */
class Conexao {
	private $_conexao;

	public function __construct() {
		$this->_conexao = false;
	}

	// Ativa nossa conexão utilizando as propriedades disponíveis em ConexaoPropriedades
	public function conectar() {
		if (!$this->_conexao) {
			$this->_conexao = @odbc_connect(ConexaoPropriedades::obter_string_conexao(), ConexaoPropriedades::$usuario, ConexaoPropriedades::$senha);

			// Se não foi possível estabelecer uma conexão, redirecione o usuário para uma página de erro na pasta atual & pare a execução do script
			if (!$this->_conexao) {
				DatabaseErroRedirecionador::enviar_erro(DE_FALHA_AO_CONECTAR);
			}
		}
	}

	// Fecha a conexão atual;
	public function desconectar() {
		if ($this->_conexao) {
			@odbc_close($this->_conexao);
			$this->_conexao = false;
		}
	}

	public function get_conexao() {
		return $this->_conexao;
	}
}

?>
