<?php
/**
 * Classe responsável por estabelecer o acesso as configurações
 */

namespace Config;

use Config\Leitor;

abstract class Config {
	const OBTER_DELIMITADOR = ".";
	private static $config;

	public static function carregar($arquivo) {
		$lt = new Leitor($arquivo);
		self::$config = $lt->getJsonObjeto();
	}

	public static function obter($string) {
		$retorno = null;
		$array = explode(self::OBTER_DELIMITADOR, $string);

		foreach ($array as $chave) {
			if ($retorno === null) {
				$retorno = &self::$config[$chave];
			} else {
				$retorno = &$retorno[$chave];
			}
		}

		return $retorno;
	}
}

?>