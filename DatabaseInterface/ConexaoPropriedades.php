<?php
namespace PHPGallery\DatabaseInterface;

/**
 * Classe estática responsável por segurar todas as propriedades de conexão
 */
class ConexaoPropriedades {
	public static $server = "localhost\\SQLEXPRESS";
	public static $database = "PHPGallery2";
	public static $autenticacao_windows = true;

	public static $usuario = "localhost\\Vitor";
	public static $senha = "";

	// Retorna a string de conexão do odbc
	public static function obter_string_conexao() {
		return "DRIVER=SQL Server;" . "SERVER=" . self::$server . ";DATABASE=" . self::$database . ((self::$autenticacao_windows) ? ";Trusted_Connection=yes" : "");
	}
}

?>