<?php
/**
 * Portão principal de pedidos Api
 * Retorna usuários
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/UsuarioApi.php";
require_once "DatabaseInterface/Conexao.php";
require_once "WebInterface/Pedido.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\UsuarioApi;
use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\WebInterface\Pedido;
use PHPGallery\WebInterface\Resposta;


Resposta::conteudo_tipo("application/json");

$api = new UsuarioApi(new Conexao());

if (Pedido::existe("procurar", "GET")) {
	$api->procurar_usuarios(Pedido::obter("procurar", "GET"));
} else if (Pedido::existe("u", "GET")) {
	$api->obter_usuario(Pedido::obter("u", "GET"));
} else {
	$api->enviar_erro(AE_INVALIDO_NAO_ENCONTRADO);
}

?>
