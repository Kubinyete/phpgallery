<?php
/**
 * Portão principal de pedidos Api
 * Retorna imagens
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/ImagemApi.php";
require_once "DatabaseInterface/Conexao.php";
require_once "WebInterface/Pedido.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\ImagemApi;
use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\WebInterface\Pedido;
use PHPGallery\WebInterface\Resposta;


Resposta::conteudo_tipo("application/json");

$api = new ImagemApi(new Conexao());

if (Pedido::obter("recentes", "GET") === "1") {
	$api->obter_recentes();
} else if (Pedido::existe("procurar", "GET")) {
	$api->procurar_imagens(Pedido::obter("procurar", "GET"));
} else if (Pedido::existe("id", "GET")) {
	$api->obter_imagem(Pedido::obter("id", "GET"));
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
