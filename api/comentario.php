<?php
/**
 * Portão principal de pedidos Api
 * retorna comentários
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/ComentarioApi.php";
require_once "DatabaseInterface/Conexao.php";
require_once "WebInterface/Pedido.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\ComentarioApi;
use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\WebInterface\Pedido;
use PHPGallery\WebInterface\Resposta;


Resposta::conteudo_tipo("application/json");

$api = new ComentarioApi(new Conexao());

if (Pedido::existe("imgid", "GET")) {
	$api->obter_comentarios(Pedido::obter("imgid", "GET");
} else if (Pedido::existe("id", "GET")) {
	$api->obter_comentario(Pedido::obter("id", "GET"));
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
