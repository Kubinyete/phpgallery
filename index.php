<?php
/**
 * Script principal que processará todos os pedidos e requisições de URL
 */

require_once __DIR__.DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Http\Pedido;
use App\Http\Resposta;
use App\Session\Sessao;
use App\Status\Status;
use App\Controllers\HomeController;
use App\Controllers\NotFoundController;
use App\Controllers\ErroController;
use App\Controllers\ImagemController;
use App\Controllers\PerfilController;
use App\Controllers\LoginController;
use App\Controllers\EnviarController;
use App\Models\HomeModel;
use App\Models\NotFoundModel;
use App\Models\ErroModel;
use App\Models\ImagemModel;
use App\Models\PerfilModel;
use App\Models\LoginModel;
use App\Models\EnviarModel;
use App\Database\Conexao;


Resposta::conteudoTipo("text/html; charset=utf-8");
Resposta::header("Content-Language", "pt-BR");
Resposta::header("X-UA-Compatible", "IE=Edge");
date_default_timezone_set("America/Sao_Paulo");


$conexao = new Conexao();


Sessao::iniciar();
Sessao::validar();


$usuarioLogado = Sessao::getUsuario();
if ($usuarioLogado !== null) {
	
	$usuarioLogadoStatus = new Status($conexao, $usuarioLogado);
	
	if (!$usuarioLogadoStatus->estaOnline()) {
		$usuarioLogadoStatus->heartbeat();
	}
}


Sessao::validarUsuario($conexao);


$requisicao = Pedido::obter("v", "GET");
// Se não for informado querystring, apenas assuma que o usuário requistiou: "/" -> "/?v=home"
if ($requisicao === null) {
	$requisicao = "home";
}

// Nosso roteador baseado na requisição GET da querystring 'v'
switch ($requisicao) {
	case "home":
		$modelo = new HomeModel($conexao);
		$controlador = new HomeController($modelo);
		$controlador->rodar($usuarioLogado)->renderizar();

		break;
	case "imagem":
		$id = Pedido::obter("id", "GET");

		$modelo = new ImagemModel($conexao);
		$controlador = new ImagemController($modelo);
		$controlador->rodar($usuarioLogado, $id)->renderizar();
		
		break;
	case "perfil":
		$nome = Pedido::obter("u", "GET");

		$modelo = new PerfilModel($conexao);
		$controlador = new PerfilController($modelo);
		$controlador->rodar($usuarioLogado, $nome)->renderizar();
		
		break;
	case "login":
		$acao = Pedido::obter("a", "POST");
		$logoff = Pedido::obter("l", "GET");

		if ($usuarioLogado !== null) {
			if ($logoff === "1") {
				Sessao::setUsuario(null);
				$usuarioLogadoStatus->offline();
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

		$modelo = new LoginModel($conexao);
		$controlador = new LoginController($modelo);

		$retornoArray = $controlador->rodar($usuarioLogado, $acao, $usuarioNome, $usuarioSenha, $usuarioConSenha);
		
		if ($retornoArray["retorno"] === "view") {
			$retornoArray["retorno_obj"]->renderizar();
		} else if ($retornoArray["retorno"] === "usuario") {
			Sessao::setUsuario($retornoArray["retorno_obj"]);
			Resposta::redirecionar("/?v=home", true);
		}

		break;
	case "enviar":
		$acao = Pedido::obter("a", "POST");

		switch ($acao) {
			case "r":
				break;
			case "i":
			default:
				$acao = "i";
				break;
		}

		$imagem = Pedido::obterArquivo("img");
		$imagemTitulo = Pedido::obter("imgti", "POST");
		$imagemDescricao = Pedido::obter("imgde", "POST");
		$imagemPrivada = Pedido::obter("imgpr", "POST");

		$modelo = new EnviarModel($conexao);
		$controlador = new EnviarController($modelo);

		$retornoArray = $controlador->rodar($usuarioLogado, $acao, $imagem, $imagemTitulo, $imagemDescricao, $imagemPrivada);

		if ($retornoArray["retorno"] === "view") {
			$retornoArray["retorno_obj"]->renderizar();
		} else if ($retornoArray["retorno"] === "imagem") {
			Resposta::redirecionar($retornoArray["retorno_obj"]->getLink(), true);
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