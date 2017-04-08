<?php
/**
 * Script principal que processará todos os pedidos e requisições de URL
 */

require_once __DIR__.DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

use App\Http\Pedido;
use App\Http\Resposta;
use App\Session\Sessao;
use App\Status\Status;
use App\Database\Conexao;
use App\Http\Roteador;

date_default_timezone_set("America/Sao_Paulo");
Resposta::conteudoTipo("text/html; charset=utf-8");
Resposta::header("Content-Language", "pt-BR");
Resposta::header("X-UA-Compatible", "IE=Edge");

$conexao = new Conexao();

/**
 * Sessão & Status (requer Conexao)
 */

Sessao::iniciar();
Sessao::validar();
Sessao::validarUsuario($conexao);

$usuarioLogado = Sessao::getUsuario();
$usuarioLogadoStatusGerenciador = new Status($conexao, $usuarioLogado);

if ($usuarioLogado !== null && !$usuarioLogadoStatusGerenciador->estaOnline()) {
	$usuarioLogadoStatusGerenciador->heartbeat();
	Sessao::validarUsuario($conexao);
}

/**
 * Pedido -> Roteador
 */

$requisicao = Pedido::obter("v", "GET");

// Se não for informado querystring, apenas assuma que o usuário requistiou: "/" -> "/?v=home"
if ($requisicao === null) {
	$requisicao = "home";
}

$roteador = new Roteador($usuarioLogado, $conexao, $usuarioLogadoStatusGerenciador);
$roteador->rodar($requisicao);

?>