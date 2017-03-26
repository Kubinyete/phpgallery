<?php
/**
 * Objeto responsável por conter métodos de manipulação da sessão atual
 */
namespace App\Session;

use App\Database\DalUsuario;

class Sessao {
	public static function iniciar() {
		@session_start();
	}

	// Retorna o id da sessão atual
	public static function getId() {
		return @session_id();
	}

	public static function getValor($string) {
		if (!isset($_SESSION[$string])) {
			return;
		}

		return $_SESSION[$string];
	}

	public static function setValor($string, $novoValor) {
		$_SESSION[$string] = $novoValor;
	}

	public static function getUsuario() {
		return self::getValor("usuario");
	}

	public static function setUsuario($usuario) {
		self::setValor("usuario", $usuario);
	}

	// Retorna se a sessão atual é valida como id, se ela conter um caráctere inválido a sessão não foi criada
	public static function sessaoValida() {
		$sessaoId = self::getId();

		if (strlen($sessaoId) < 1 || strlen($sessaoId) > 128) {
			return false;
		}

		$retorno = true;
		for ($i = 0; $i < strlen($sessaoId); $i++) {
			if (ord($sessaoId[$i]) <= 47 || ord($sessaoId[$i]) >= 58 && ord($sessaoId[$i]) <= 64 || ord($sessaoId[$i]) >= 91 && ord($sessaoId[$i]) <= 96 || ord($sessaoId[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}

	// Se nossa sessão atual está inválida, crie um novo id de sessão
	public static function validar() {
		if (!self::sessaoValida()) {
			self::recriarId();
		}
	}

	// Valida o estado de nosso usuário atual em sessão armazenado em comparação com o do banco de dados
	public static function validarUsuario($conexao) {
		$usuarioArmazenado = self::getUsuario();

		if ($usuarioArmazenado !== null) {
			$dal = new DalUsuario($conexao);
			$novoUsuario = $dal->obterUsuario(false, $usuarioArmazenado->getNome());

			if ($novoUsuario !== null) {
				if (!$usuarioArmazenado->igualA($novoUsuario)) {
					self::setUsuario($novoUsuario);
				}
			} else {
				// Usuário foi deletado do banco de dados
				self::setUsuario(null);
			}
		}
	}

	// Recria o id da sessão atual
	public static function recriarId() {
		@session_regenerate_id();
	}
}

?>
