<?php
/**
 * Script principal que processará todos os pedidos e requisições de URL
 */

require_once __DIR__.DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Http\Pedido;
use App\Http\Resposta;
use App\Session\Sessao;
use App\Controllers\HomeController;
use App\Controllers\NotFoundController;
use App\Controllers\ErroController;
use App\Controllers\ImagemController;
use App\Controllers\PerfilController;
use App\Models\HomeModel;
use App\Models\NotFoundModel;
use App\Models\ErroModel;
use App\Models\ImagemModel;
use App\Models\PerfilModel;
use App\Database\Conexao;

Resposta::conteudoTipo("text/html; charset=utf-8");
Resposta::header("Content-Language", "pt-BR");
date_default_timezone_set("America/Sao_Paulo");

Sessao::iniciar();
Sessao::validar();
Sessao::validarUsuario();

$requisicao = Pedido::obter("v", "GET");

if ($requisicao === null) {
	$requisicao = "home";
}

switch ($requisicao) {
	case "home":
		$modelo = new HomeModel(new Conexao());
		$controlador = new HomeController($modelo);
		$usuarioLogado = Sessao::getUsuario();
		$controlador->rodar($usuarioLogado)->renderizar();
		break;
	case "imagem":
		$id = Pedido::obter("id", "GET");

		$modelo = new ImagemModel(new Conexao());
		$controlador = new ImagemController($modelo);
		$usuarioLogado = Sessao::getUsuario();
		$controlador->rodar($usuarioLogado, $id)->renderizar();
		break;
	case "perfil":
		$nome = Pedido::obter("u", "GET");

		$modelo = new PerfilModel(new Conexao());
		$controlador = new PerfilController($modelo);
		$usuarioLogado = Sessao::getUsuario();
		$controlador->rodar($usuarioLogado, $nome)->renderizar();
		break;
	case "erro":
		$erroCodigo = Pedido::obter("c", "GET");

		$modelo = new ErroModel(null);
		$controlador = new ErroController($modelo);
		$usuarioLogado = Sessao::getUsuario();

		Resposta::status(500);
		$controlador->rodar($usuarioLogado ,$erroCodigo)->renderizar();
		break;
	default:
		$modelo = new NotFoundModel(null);
		$controlador = new NotFoundController($modelo);
		$usuarioLogado = Sessao::getUsuario();

		Resposta::status(404);
		$controlador->rodar($usuarioLogado)->renderizar();
		break;
}

?>