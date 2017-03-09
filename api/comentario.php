<?php
/**
 * Portão principal de pedidos Api
 * retorna comentários
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/ComentarioApi.php";
require_once "DatabaseInterface/Conexao.php";

use PHPGallery\ApiInterface\ComentarioApi;
use PHPGallery\DatabaseInterface\Conexao;



header("Content-Type: application/json");

$api = new ComentarioApi(new Conexao());

if (isset($_GET["imgid"])) {
	$api->obter_comentarios($_GET["imgid"]);
} else if (isset($_GET["id"])) {
	$api->obter_comentario($_GET["id"]);
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
