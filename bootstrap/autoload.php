<?php
/**
 * Registra a função de auto-carregar classes
 */

spl_autoload_register(
	function ($caminhoClasse) {
		$caminhoClasse = explode("\\", $caminhoClasse);

		// App\Database\Class => app\Database\Class
		// Pois todas as pastas no diretório principal estão em lowercase
		if (isset($caminhoClasse[0])) {
			$caminhoClasse[0] = strtolower($caminhoClasse[0]);
		}

		$caminhoClasse = implode(DIRECTORY_SEPARATOR, $caminhoClasse);

		require_once dirname(__DIR__).DIRECTORY_SEPARATOR.$caminhoClasse.".php";
	}
);

?>