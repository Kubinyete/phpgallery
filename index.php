<?php
/**
 * Script principal que processará todos os pedidos e requisições de URL
 */

require_once __DIR__.DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Http\Pedido;
use App\Http\Resposta;
use App\Controllers\HomeController;
use App\Controllers\NotFoundController;
use App\Controllers\ErroController;
use App\Models\HomeModel;
use App\Models\NotFoundModel;
use App\Models\ErroModel;
use App\Database\Conexao;

Resposta::conteudoTipo("text/html; charset=utf-8");
Resposta::header("Content-Language", "pt-BR");
date_default_timezone_set("America/Sao_Paulo");

$requisicao = Pedido::obter("v", "GET");

if ($requisicao === null) {
	$requisicao = "home";
}

switch ($requisicao) {
	case "home":
		$conexao = new Conexao();
		$modelo = new HomeModel($conexao);
		$controlador = new HomeController($modelo);
		$controlador->rodar()->renderizar();
		break;
	case "erro":
		$erroCodigo = Pedido::obter("c", "GET");
		$modelo = new ErroModel(null);
		$controlador = new ErroController($modelo);

		Resposta::status(500);
		$controlador->rodar($erroCodigo)->renderizar();
		break;
	default:
		$modelo = new NotFoundModel(null);
		$controlador = new NotFoundController($modelo);

		Resposta::status(404);
		$controlador->rodar()->renderizar();
		break;
}

?>