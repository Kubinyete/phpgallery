<?php
/**
 * Classe responsável por armazenar os erros de login de suas definições
 */

namespace App\Controllers;

use App\Controllers\LoginController;

abstract class LoginErro {
	const NOME_INVALIDO = 0;
	const SENHA_INVALIDA = 1;
	const NOME_TAMANHO_INVALIDO = 2;
	const SENHA_TAMANHO_INVALIDO = 3;

	const LOGIN_USUARIO_NAO_EXISTE = 4;
	const LOGIN_SENHA_ERRADA = 5;
	const REGISTRAR_USUARIO_JA_EXISTE = 6;
	const REGISTRAR_CONFIRMA_SENHA_INVALIDA = 7;

	const DEFINICOES = [
		self::NOME_INVALIDO => "O nome informado contêm um ou mais carácteres inválidos.",
		self::SENHA_INVALIDA => "A senha informada contêm um ou mais carácteres inválidos.",
		self::NOME_TAMANHO_INVALIDO => "O tamanho do nome informado está inválido, mínimo de ".LoginController::MIN_CARACTERES_NOME." e máximo de ".LoginController::MAX_CARACTERES_NOME." carácteres.",
		self::SENHA_TAMANHO_INVALIDO => "O tamanho da senha informada está inválida, mínimo de ".LoginController::MIN_CARACTERES_SENHA." e máximo de ".LoginController::MAX_CARACTERES_SENHA." carácteres.",
		self::LOGIN_USUARIO_NAO_EXISTE => "O nome de usuário ou senha está incorreto.",
		self::LOGIN_SENHA_ERRADA => "O nome de usuário ou senha está incorreto.",
		self::REGISTRAR_USUARIO_JA_EXISTE => "O nome de usuário informado já existe.",
		self::REGISTRAR_CONFIRMA_SENHA_INVALIDA => "A confirmação de senha não bate com a senha informada."
	];
}

?>