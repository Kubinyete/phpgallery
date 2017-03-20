<?php
/**
 * Registra a função de auto-carregar classes
 */

spl_autoload_register(
	function ($nomeClasse) {
		$nomeClasse = str_replace("\\", DIRECTORY_SEPARATOR, $nomeClasse);

		require_once dirname(__DIR__).DIRECTORY_SEPARATOR.$nomeClasse.".php";
	}
);

?>