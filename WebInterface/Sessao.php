<?php
namespace PHPGallery\WebInterface;

set_include_path("..");

require_once "DatabaseInterface/Conexao.php";
require_once "DatabaseInterface/DatabaseUsuario.php";

use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\DatabaseInterface\DatabaseALUsuario;

/**
 * Classe responsável por representar uma sessão PHP
 */
class Sessao {
	public static function iniciar() {
		@session_start();
	}

	// Retorna o id da sessão atual
	public static function get_id() {
		return @session_id();
	}

	// Retorna se a sessão atual é valida como id, se ela conter um caráctere inválido a sessão não foi criada
	public static function sessao_valida() {
		$id_sessao = self::get_id();

		if (strlen($id_sessao) < 1 || strlen($id_sessao) > 128) {
			return false;
		}

		$retorno = true;
		for ($i = 0; $i < strlen($id_sessao); $i++) {
			if (ord($id_sessao[$i]) <= 47 || ord($id_sessao[$i]) >= 58 && ord($id_sessao[$i]) <= 64 || ord($id_sessao[$i]) >= 91 && ord($id_sessao[$i]) <= 96 || ord($id_sessao[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}

	// Se nossa sessão atual está inválida, crie um novo id de sessão
	public static function validar() {
		if (!self::sessao_valida()) {
			self::recriar_id();
		}
	}

	// Valida o estado de nosso usuário atual em sessão armazenado em comparação com o do banco de dados
	public static function validar_usuario() {
		$usuario_armazenado = self::get_usuario();

		if ($usuario_armazenado !== null) {
			$dal = new DatabaseALUsuario(new Conexao());
			$novo_usuario = $dal->obter_usuario($usuario_armazenado->get_id());

			if ($novo_usuario !== null) {
				if (!$usuario_armazenado->igual($novo_usuario)) {
					self::set_usuario($novo_usuario);
				}
			} else {
				//Usuário foi deletado do banco de dados
				self::set_usuario(null);
			}
		}
	}

	// Recria o id da sessão atual
	public static function recriar_id() {
		@session_regenerate_id();
	}

	public static function get_valor($string) {
		if (!isset($_SESSION[$string])) {
			return;
		}

		return $_SESSION[$string];
	}

	public static function set_valor($string, $novo_valor) {
		$_SESSION[$string] = $novo_valor;
	}

	public static function get_usuario() {
		return self::get_valor("usuario");
	}

	public static function set_usuario($usuario) {
		self::set_valor("usuario", $usuario);
	}
}

?>
