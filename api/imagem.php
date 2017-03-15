<?php
/**
 * Portão principal de pedidos Api
 * Retorna imagens
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/ImagemApi.php";
require_once "DatabaseInterface/Conexao.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\ImagemApi;
use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\WebInterface\Resposta;


Resposta::conteudo_tipo("application/json");

$api = new ImagemApi(new Conexao());

if (isset($_GET["recentes"]) && $_GET["recentes"] === "1") {
	$api->obter_recentes();
} else if (isset($_GET["procurar"])) {
	$api->procurar_imagens($_GET["procurar"]);
} else if (isset($_GET["id"])) {
	$api->obter_imagem($_GET["id"]);
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
