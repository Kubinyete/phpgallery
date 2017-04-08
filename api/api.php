<?php
/**
 * Script responsável por processar os pedidos de api
 * retornando objetos JSON de acordo com os parâmetros passados via query string
 */

require_once dirname(__DIR__).DIRECTORY_SEPARATOR."bootstrap".DIRECTORY_SEPARATOR."autoload.php";

/**
 * Alvos
 * usr -> Usuários
 * img -> Imagens
 * cmt -> Comentários
 */

/**
 * ATT:
 * Os pedidos que apresentarem dois parâmetros
 * Ex: u=nome & s=busca
 * o processador dará prioridade à sua identificação primária (id / u)
 */

use App\Api\Api;
use App\Api\ApiResposta;
use App\Api\ApiUsuario;
use App\Api\ApiImagem;
use App\Api\ApiComentario;
use App\Database\Conexao;
use App\Http\Pedido;
use App\Http\Resposta;
use Config\ConexaoConfig;

// Para debug, desative o tipo de conteúdo JSON para que a formatação HTML dos erros funcionem
if (!ConexaoConfig::MODO_DEBUG) {
	Resposta::conteudoTipo("application/json");
}

$alvo = Pedido::obter("a");

switch ($alvo) {
	case "usr":
		$nome = Pedido::obter("u");
		$procuraString = Pedido::obter("s");

		if ($nome !== null) {
			$api = new ApiUsuario(new Conexao());
			$resposta = $api->obterUsuario($nome);
			$resposta->enviar();
		} else if ($procuraString !== null) {
			$api = new ApiUsuario(new Conexao());
			$resposta = $api->listarUsuarios($procuraString);
			$resposta->enviar();
		} else {
			Api::erro("Para obter um usuário ou uma lista de usuários, é necessário informar seu id ou uma string de busca.")->enviar();
		}

		break;
	case "img":
		$id = Pedido::obter("id");
		$procuraString = Pedido::obter("s");
		$recentes = Pedido::obter("r");

		if ($id !== null) {
			$api = new ApiImagem(new Conexao());
			$resposta = $api->obterImagem($id);
			$resposta->enviar();
		} else if ($procuraString !== null) {
			$api = new ApiImagem(new Conexao());
			$resposta = $api->listarImagens($procuraString);
			$resposta->enviar();
		} else if ($recentes === "1") {
			$api = new ApiImagem(new Conexao());
			$resposta = $api->listarRecentes();
			$resposta->enviar();
		} else {
			Api::erro("Para obter uma imagem ou uma lista de imagens, é necessário informar sua id ou uma string de busca.")->enviar();
		} 
		
		break;
	case "cmt":
		$id = Pedido::obter("id");
		$imgId = Pedido::obter("imgid");

		if ($id !== null) {
			$api = new ApiComentario(new Conexao());
			$resposta = $api->obterComentario($id);
			$resposta->enviar();
		} else if ($imgId !== null) {
			$api = new ApiComentario(new Conexao());
			$resposta = $api->listarComentarios($id);
			$resposta->enviar();
		} else {
			Api::erro("Para obter um comentário ou uma lista de comentários, é necessário informar seu id ou o id da imagem.")->enviar();
		}

		break;
	default:
		Api::erro("O parâmetro de alvo não foi informado corretamente.")->enviar();

		break;
}

?>