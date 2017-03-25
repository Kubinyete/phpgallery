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
use App\Controllers\LoginController;
use App\Models\HomeModel;
use App\Models\NotFoundModel;
use App\Models\ErroModel;
use App\Models\ImagemModel;
use App\Models\PerfilModel;
use App\Models\LoginModel;
use App\Database\Conexao;

Resposta::conteudoTipo("text/html; charset=utf-8");
Resposta::header("Content-Language", "pt-BR");
date_default_timezone_set("America/Sao_Paulo");

Sessao::iniciar();
Sessao::validar();
Sessao::validarUsuario();

$usuarioLogado = Sessao::getUsuario();

$requisicao = Pedido::obter("v", "GET");

if ($requisicao === null) {
	$requisicao = "home";
}

switch ($requisicao) {
	case "home":
		$modelo = new HomeModel(new Conexao());
		$controlador = new HomeController($modelo);
		$controlador->rodar($usuarioLogado)->renderizar();
		break;
	case "imagem":
		$id = Pedido::obter("id", "GET");

		$modelo = new ImagemModel(new Conexao());
		$controlador = new ImagemController($modelo);
		$controlador->rodar($usuarioLogado, $id)->renderizar();
		break;
	case "perfil":
		$nome = Pedido::obter("u", "GET");

		$modelo = new PerfilModel(new Conexao());
		$controlador = new PerfilController($modelo);
		$controlador->rodar($usuarioLogado, $nome)->renderizar();
		break;
	case "login":
		$acao = Pedido::obter("a", "POST");
		$logoff = Pedido::obter("l", "GET");

		if ($usuarioLogado !== null) {
			if ($logoff === "1") {
				Sessao::setUsuario(null);
				Resposta::redirecionar("/?v=login", true);
			} else {
				Resposta::redirecionar("/?v=home", true);
			}
		}

		switch ($acao) {
			case "l":
				break;
			case "r":
				break;
			case null:
			default:
				$acao = "i";
				break;
		}

		$usuarioNome = Pedido::obter("nom", "POST");
		$usuarioSenha = Pedido::obter("sen", "POST");
		$usuarioConSenha = Pedido::obter("consen", "POST");

		$modelo = new LoginModel(new Conexao());
		$controlador = new LoginController($modelo);

		$retornoArray = $controlador->rodar($usuarioLogado, $acao, $usuarioNome, $usuarioSenha, $usuarioConSenha);
		
		if ($retornoArray["retorno"] === "view") {
			$retornoArray["retorno_obj"]->renderizar();

		} else if ($retornoArray["retorno"] === "usuario") {
			Sessao::setUsuario($retornoArray["retorno_obj"]);
			Resposta::redirecionar("/?v=home", true);
		}

		break;
	case "erro":
		$erroCodigo = Pedido::obter("c", "GET");

		$modelo = new ErroModel(null);
		$controlador = new ErroController($modelo);

		Resposta::status(500);
		$controlador->rodar($usuarioLogado ,$erroCodigo)->renderizar();
		break;
	default:
		$modelo = new NotFoundModel(null);
		$controlador = new NotFoundController($modelo);

		Resposta::status(404);
		$controlador->rodar($usuarioLogado)->renderizar();
		break;
}

?>