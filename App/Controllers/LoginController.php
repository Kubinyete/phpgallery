<?php
/**
 * Controlador da página de login
 */

namespace App\Controllers;

use App\Controllers\Controller;
use Config\Config;

class LoginController extends Controller {
	// $model
	
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
			return ((strlen($string) <= Config::obter("Usuarios.max_caracteres_nome")) && (strlen($string) >= Config::obter("Usuarios.min_caracteres_nome")));
		} else {
			return ((strlen($string) <= Config::obter("Usuarios.max_caracteres_senha")) && (strlen($string) >= Config::obter("Usuarios.min_caracteres_senha")));
		}
	}

	public function rodar($usuarioLogado, $acao="i", $usuarioNome="", $usuarioSenha="", $usuarioConSenha="") {
		$errosLista = [];

		if ($acao === "r" || $acao === "l") {
			if (!self::stringValida($usuarioNome)) {
				array_push($errosLista, Config::obter("MvcErrors.Login.NOME_CARACTERES_INVALIDOS"));
			}

			if (!self::tamanhoValido($usuarioNome, true)) {
				array_push($errosLista, Config::obter("MvcErrors.Login.NOME_TAMANHO_INVALIDO"));
			}

			if (!self::stringValida($usuarioSenha)) {
				array_push($errosLista, Config::obter("MvcErrors.Login.SENHA_CARACTERES_INVALIDOS"));
			}

			if (!self::tamanhoValido($usuarioSenha, false)) {
				array_push($errosLista, Config::obter("MvcErrors.Login.SENHA_TAMANHO_INVALIDO"));
			}

			// Apenas tente verificar isso se estamos registrando
			if ($acao === "r" && $usuarioSenha !== $usuarioConSenha) {
				array_push($errosLista, Config::obter("MvcErrors.Login.REGISTRAR_CONFIRMACAO_INVALIDA"));
			}
		}

		if ($acao === "i") {
			// Index
			return $this->model->index($usuarioLogado);
		} else if ($acao === "r") {
			// Registrar
			return $this->model->registrar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha);
		} else {
			// Logar
			return $this->model->logar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha);
		}
	}
}

?>