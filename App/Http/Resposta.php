<?php
/**
 * Classe responsável por conter métodos de resposta HTTP customizados
 */

namespace App\Http;

use App\Database\Erro;

class Resposta {
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

	public static function erro($codigo=Erro::DBERRO_DESCONHECIDO, $pararExecucao=false) {
		self::status(500);
		self::redirecionar(str_replace("%", $codigo, Erro::SCRIPT_ERRO), $pararExecucao);
	}
}

?>