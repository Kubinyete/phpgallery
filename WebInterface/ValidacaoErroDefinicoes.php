<?php
namespace PHPGallery\WebInterface;

define("VE_DESCONHECIDO", 0);
define("VE_LOGIN_INVALIDO", 1);

/**
 * Classe responsável por segurar todas as mensagens de erro da classe Validação
 */
class ValidacaoErroDefinicoes {
	public static $validacao_erros = [
		VE_DESCONHECIDO => "Ocorreu um erro desconhecido ao tentar verificar as informações.",
		VE_LOGIN_INVALIDO => "O nome de usuário ou senha está incorreto."
	];
}

?>