<?php
namespace PHPGallery\WebInterface;

define("VE_DESCONHECIDO", 0);
define("VE_LOGIN_INVALIDO", 1);
define("VE_REGISTRA_NOME_INVALIDO", 2);
define("VE_REGISTRA_SENHA_INVALIDA", 3);
define("VE_REGISTRA_CONFIRMA_SENHA_INVALIDA", 4);
define("VE_REGISTRA_JA_EXISTE", 5);
define("VE_REGISTRA_NOME_TAMANHO_INVALIDO", 6);
define("VE_REGISTRA_SENHA_TAMANHO_INVALIDO", 7);

/**
 * Classe responsável por segurar todas as mensagens de erro da classe Validação
 */
class ValidacaoErroDefinicoes {
	public static $validacao_erros = [
		VE_DESCONHECIDO => "Ocorreu um erro desconhecido ao tentar verificar as informações.",
		VE_LOGIN_INVALIDO => "O nome de usuário ou senha está incorreto.",
		VE_REGISTRA_NOME_INVALIDO => "O nome de usuário informado contêm carácteres inválidos, somente [a-z, A-Z, 0-9] são permitidos.",
		VE_REGISTRA_SENHA_INVALIDA => "A senha informada contêm carácteres inválidos, somente [a-z, A-Z, 0-9] são permitidos.",
		VE_REGISTRA_CONFIRMA_SENHA_INVALIDA => "A confirmação da senha não está de acordo com a senha informada.",
		VE_REGISTRA_JA_EXISTE => "O nome do usuário informado já existe.",
		VE_REGISTRA_NOME_TAMANHO_INVALIDO => "O tamanho do nome de usuário informado está inválido."
	];
}

?>
