<?php
/**
 * Portão principal de pedidos Api
 * Retorna usuários
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/UsuarioApi.php";
require_once "DatabaseInterface/Conexao.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\UsuarioApi;
use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\WebInterface\Resposta;


Resposta::conteudo_tipo("application/json");

$api = new UsuarioApi(new Conexao());

if (isset($_GET["procurar"])) {
	$api->procurar_usuarios($_GET["procurar"]);
} else if (isset($_GET["u"])) {
	$api->obter_usuario($_GET["u"]);
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
