<?php
/**
 * Classe contendo diversas funções úteis 
 */

namespace App\Utils;

class Utils {
	// Filtra todas as " & ' de uma string devolvendo \" & \'
	public static function filtrarAspasJs($string) {
		return str_replace('\'', '\\\'', $string);
	}

	// Imprime o comando SQL de um objeto SqlComando para fins de debug
	public static function imprimirSqlComando($sqlComando) {
		echo "\n<hr>\n";
		echo "<h1 style='color: rgba(0,0,0,.8)'>Database.debug > Executando o SqlComando...</h1>\n";
		echo "<pre style='background-color: #ddd; color: rgba(0,0,0,.6); width: 100%; word-wrap: break-word; white-space: unset'>Dal::executar() > SqlComando::getComandoString() = ".$sqlComando->getComandoString()."</pre>\n";
		echo "<hr>\n";
	}
}

?>