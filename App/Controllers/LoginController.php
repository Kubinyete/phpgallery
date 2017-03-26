<?php
/**
 * Controlador da página de login
 */

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\LoginErro;

class LoginController extends Controller {
	// $model
	const MAX_CARACTERES_NOME = 16;
	const MIN_CARACTERES_NOME = 4;
	const MAX_CARACTERES_SENHA = 32;
	const MIN_CARACTERES_SENHA = 6;
	
	// Valida a string e retorna se ela está de acordo para registrar um usuário / senha
	private static function stringValida($string) {
		if ($string === null) {
			return false;
		}

		$retorno = true;
		for ($i = 0; $i < strlen($string); $i++) {
			if (ord($string[$i]) <= 47 || ord($string[$i]) >= 58 && ord($string[$i]) <= 64 || ord($string[$i]) >= 91 && ord($string[$i]) <= 96 || ord($string[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}

	// Retorna se o tamanho da cadeia de carácteres está dentro do permitido
	// $paraNome => (true) nome
	// $paraNome => (false) senha
	private static function tamanhoValido($string, $paraNome) {
		if ($string === null) {
			return false;
		}

		if ($paraNome) {
			return ((strlen($string) <= self::MAX_CARACTERES_NOME) && (strlen($string) >= self::MIN_CARACTERES_NOME));
		} else {
			return ((strlen($string) <= self::MAX_CARACTERES_SENHA) && (strlen($string) >= self::MIN_CARACTERES_SENHA));
		}
	}

	public function rodar($usuarioLogado, $acao, $usuarioNome, $usuarioSenha, $usuarioConSenha) {
		$errosLista = [];

		if ($acao === "r" || $acao === "l") {
			if (!self::stringValida($usuarioNome)) {
				array_push($errosLista, LoginErro::NOME_INVALIDO);
			}

			if (!self::tamanhoValido($usuarioNome, true)) {
				array_push($errosLista, LoginErro::NOME_TAMANHO_INVALIDO);
			}

			if (!self::stringValida($usuarioSenha)) {
				array_push($errosLista, LoginErro::SENHA_INVALIDA);
			}

			if (!self::tamanhoValido($usuarioSenha, false)) {
				array_push($errosLista, LoginErro::SENHA_TAMANHO_INVALIDO);
			}

			if ($acao === "r" && $usuarioSenha !== $usuarioConSenha) {
				array_push($errosLista, LoginErro::REGISTRAR_CONFIRMA_SENHA_INVALIDA);
			}
		}

		if ($acao === "i") {
			return $this->model->index($usuarioLogado);
		} else if ($acao === "r") {
			return $this->model->registrar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha);
		} else {
			return $this->model->logar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha);
		}
	}
}

?>