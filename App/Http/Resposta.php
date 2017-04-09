<?php
/**
 * Classe responsável por conter métodos de resposta HTTP customizados
 */

namespace App\Http;

use Config\Config;

abstract class Resposta {
	public static function header($chave, $valor) {
		header($chave.": ".$valor);
	}

	public static function conteudoTipo($conteudoTipo) {
		self::header("Content-Type", $conteudoTipo);
	}

	public static function status($codigo, $pararExecucao=false) {
		header("Status: ".$codigo, true, $codigo);

		if ($pararExecucao) {
			exit();
		}
	}

	public static function redirecionar($url, $pararExecucao=false) {
		header("Location: ".$url);

		if ($pararExecucao) {
			exit();
		}
	}

	public static function erro($codigo=0, $pararExecucao=false) {
		self::status(500);
		self::redirecionar(str_replace("%", $codigo, Config::obter("Database.Erro.requisicao")), $pararExecucao);
	}
}

?>