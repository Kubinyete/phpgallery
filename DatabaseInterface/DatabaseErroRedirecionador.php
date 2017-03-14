<?php
namespace PHPGallery\DatabaseInterface;

/**
 * Classe estática responsável por redirecionar o pedido para uma página de erro, com uma mensagem mais "amigável" de erro para o usuário
 */
class DatabaseErroRedirecionador {
	private static $pagina_erro = "database_erro.php";

	public static function enviar_erro($codigo=0) {
		header("Status: 307", true, 307);
		header("Location: " . self::$pagina_erro . "?err=" . $codigo);
		exit();
	}
}

?>