<?php
namespace PHPGallery\DatabaseInterface;

set_include_path("..");

require_once "WebInterface/Resposta.php";

use PHPGallery\WebInterface\Resposta;

/**
 * Classe estática responsável por redirecionar o pedido para uma página de erro, com uma mensagem mais "amigável" de erro para o usuário
 */
class DatabaseErroRedirecionador {
	private static $pagina_erro = "database_erro.php";

	public static function enviar_erro($codigo=0) {
		Resposta::status(307);
		Resposta::redirecionar(self::$pagina_erro . "?err=" . $codigo);
		exit();
	}
}

?>
