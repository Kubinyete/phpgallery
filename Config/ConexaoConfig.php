<?php
/**
 * Configuração padrão para inicializar um objeto Conexao
 * utilizando no momento ODBC para SQLServer
 */

namespace Config;

class ConexaoConfig {
	// Impede o redirecionamento do pedido se ocorrer um erro na consulta
	// tambêm permite a visualização do erro odbc na página atual e
	// informa a comandoString dos objetos SqlComando
	const MODO_DEBUG = false;

	const SERVER = 'localhost\SQLEXPRESS';
	const DATABASE = 'phpgallery';
	const AUTENTICACAO_WINDOWS = true;

	const USUARIO = '';
	const SENHA = '';

	public static function getStringConexao() {
		return 'Driver=SQL Server;'.'Server='.self::SERVER.';Database='.self::DATABASE.((self::AUTENTICACAO_WINDOWS) ? ';Trusted_Connection=yes;' : ';User Id='.self::USUARIO.';Password='.self::SENHA.';');
	}
}

?>