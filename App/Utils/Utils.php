<?php
/**
 * Classe contendo diversas funções úteis 
 */

namespace App\Utils;

class Utils {
	// Filtra todas as " & ' de uma string devolvendo \" & \'
	public static function filtrarAspasJs($string) {
		/*
		$retorno = "";
		for ($i=0; $i < strlen($string); $i++) {
			if ($string[$i] === "'") {
				$retorno .= "\\".$string[$i];
			} else if ($string[$i] === "\"") {
				$retorno .= "\\".$string[$i];
			} else {
				$retorno .= $string[$i];
			}
		}
		*/
		return str_replace('\'', '\\\'', $string);
	}
}

?>