<?php
/**
 * Página de erro
 * se algum script de nossa Api apresentar um erro ao acessar o banco de dados e
 * redirecionar o pedido para uma página de erro, este arquivo será acessado
 */

namespace PHPGallery\Api;

set_include_path("..");

require_once "ApiInterface/ApiResposta.php";
require_once "DatabaseInterface/DatabaseErroDefinicoes.php";
require_once "WebInterface/Resposta.php";

use PHPGallery\ApiInterface\ApiResposta;
use PHPGallery\DatabaseInterface\DatabaseErroDefinicoes;
use PHPGallery\WebInterface\Resposta;


Resposta::status(500);
Resposta::conteudo_tipo("application/json");

$codigo = 0;

if (isset($_GET["err"])) {
	$codigo = intval($_GET["err"]);
}

$resposta = [
	"erro_database" => true,
	"erro_codigo" => (isset(DatabaseErroDefinicoes::$database_erros[$codigo])) ? $codigo : 0,
	"erro_mensagem" => (isset(DatabaseErroDefinicoes::$database_erros[$codigo])) ? DatabaseErroDefinicoes::$database_erros[$codigo] : DatabaseErroDefinicoes::$database_erros[DE_DESCONHECIDO]
];

$resposta = new ApiResposta($resposta);
$resposta->enviar();

?>
