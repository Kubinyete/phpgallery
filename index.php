<?php
/**
 * Script principal que processará todos os pedidos e requisições de URL
 */

require_once __DIR__.DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Http\Pedido;
use App\Http\Resposta;

use App\Controllers\HomeController;
use App\Models\HomeModel;

use App\Database\Conexao;
use App\Database\DalImagem;



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
		$dal = new DalImagem($conexao);
		$modelo = new HomeModel($dal);
		$controlador = new HomeController($modelo);

		$controlador->rodar()->renderizar();

		break;
	
	default:
		// TODO: 404
		break;
}

?>