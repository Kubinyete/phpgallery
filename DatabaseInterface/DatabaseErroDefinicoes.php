<?php
namespace PHPGallery\DatabaseInterface;

define("DE_DESCONHECIDO", 0);
define("DE_FALHA_AO_CONECTAR", 1);
define("DE_FALHA_EFETUAR_COMANDO", 2);
define("DE_FALHA_SALVAR", 3);

/**
 * Classe estática que contém todas as definições e respostas para determinados erros no banco de dados
 */
class DatabaseErroDefinicoes {
	public static $database_erros = [
		DE_DESCONHECIDO => "Ocorreu um erro desconhecido.",
		DE_FALHA_AO_CONECTAR => "Não foi possível estabelecer uma conexão com o banco de dados.",
		DE_FALHA_EFETUAR_COMANDO => "Ocorreu um erro ao tentar consultar o banco de dados.",
		DE_FALHA_SALVAR => "Ocorreu um erro ao tentar salvar as alterações no banco de dados."
	];
}

?>