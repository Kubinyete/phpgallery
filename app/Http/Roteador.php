<?php
/**
 * Classe reponsável pelas rotas dos pedidos
 */

namespace App\Http;

use App\Http\Pedido;
use App\Http\Resposta;
use App\Session\Sessao;
use App\Controllers\HomeController;
use App\Controllers\NotFoundController;
use App\Controllers\ErroController;
use App\Controllers\ImagemController;
use App\Controllers\PerfilController;
use App\Controllers\LoginController;
use App\Controllers\EnviarController;
use App\Controllers\PerfilEditController;
use App\Controllers\ImagemEditController;
use App\Controllers\DownloadController;
use App\Models\HomeModel;
use App\Models\NotFoundModel;
use App\Models\ErroModel;
use App\Models\ImagemModel;
use App\Models\PerfilModel;
use App\Models\LoginModel;
use App\Models\EnviarModel;
use App\Models\PerfilEditModel;
use App\Models\ImagemEditModel;
use App\Models\DownloadModel;
use Config\Config;

class Roteador {
	private $usuarioLogado;
	private $usuarioLogadoStatusGerenciador;
	private $conexao;

	public function __construct($usuarioLogado, $conexao, $usuarioLogadoStatusGerenciador) {
		$this->usuarioLogado = $usuarioLogado;
		$this->usuarioLogadoStatusGerenciador = $usuarioLogadoStatusGerenciador;
		$this->conexao = $conexao;
	}

	public function getConexao() {
		return $this->conexao;
	}

	public function getUsuarioLogado() {
		return $this->usuarioLogado;
	}

	public function getUsuarioLogadoStatusGerenciador() {
		return $this->usuarioLogadoStatusGerenciador;
	}

	public function rodar($requisicao='home') {
		// Nosso roteador baseado na requisição GET da querystring 'v'
		switch ($requisicao) {
			case "home":
				$modelo = new HomeModel($this->getConexao());
				$controlador = new HomeController($modelo);
				$controlador->rodar($this->getUsuarioLogado())->renderizar();
				break;
			case "imagem":
				$id = Pedido::obter("i", "GET");
				$cmtConteudo = Pedido::obter("cmtcon", "POST");

				$modelo = new ImagemModel($this->getConexao());
				$controlador = new ImagemController($modelo);
				$controlador->rodar($this->getUsuarioLogado(), $id, $cmtConteudo)->renderizar();
				break;
			case "perfil":
				$nome = Pedido::obter("i", "GET");

				$modelo = new PerfilModel($this->getConexao());
				$controlador = new PerfilController($modelo);
				$controlador->rodar($this->getUsuarioLogado(), $nome)->renderizar();
				break;
			case "login":
				$acao = Pedido::obter("a", "POST");
				$logoff = Pedido::obter("i", "GET");

				if ($this->getUsuarioLogado() !== null) {
					if ($logoff === "1") {
						Sessao::setUsuario(null);
						$this->getUsuarioLogadoStatusGerenciador()->offline();
						Resposta::redirecionar(Config::obter('Views.href_login'), true);
					} else {
						Resposta::redirecionar(Config::obter('Views.href_home'), true);
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

				$modelo = new LoginModel($this->getConexao());
				$controlador = new LoginController($modelo);

				$retornoArray = $controlador->rodar($this->getUsuarioLogado(), $acao, $usuarioNome, $usuarioSenha, $usuarioConSenha);
				
				if ($retornoArray["retorno"] === "view") {
					$retornoArray["retorno_obj"]->renderizar();
				} else if ($retornoArray["retorno"] === "usuario") {
					Sessao::setUsuario($retornoArray["retorno_obj"]);
					Resposta::redirecionar(Config::obter('Views.href_home'), true);
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

				$modelo = new EnviarModel($this->getConexao());
				$controlador = new EnviarController($modelo);

				$retornoArray = $controlador->rodar($this->getUsuarioLogado(), $acao, $imagem, $imagemTitulo, $imagemDescricao, $imagemPrivada);

				if ($retornoArray["retorno"] === "view") {
					$retornoArray["retorno_obj"]->renderizar();
				} else if ($retornoArray["retorno"] === "imagem") {
					Resposta::redirecionar($retornoArray["retorno_obj"]->getLink(), true);
				}
				break;
			case "perfil-edit":
				$imagem = Pedido::obterArquivo("usrim");
				$descricao = Pedido::obter("usrde", "POST");
				$imagemFundo = Pedido::obter("usrif", "POST");

				$modelo = new PerfilEditModel($this->getConexao());
				$controlador = new PerfilEditController($modelo);

				$controlador->rodar($this->getUsuarioLogado(), $imagem, $descricao, $imagemFundo)->renderizar();
				break;
			case "imagem-edit":
				$imagemId = Pedido::obter('i', 'GET');

				$modelo = new ImagemEditModel($this->getConexao());
				$controlador = new ImagemEditController($modelo);

				$controlador->rodar($this->getUsuarioLogado(), $imagemId)->renderizar();
				break;
			case "erro":
				$erroCodigo = Pedido::obter("i", "GET");

				$modelo = new ErroModel($this->getConexao());
				$controlador = new ErroController($modelo);

				Resposta::status(500);
				$controlador->rodar($this->getUsuarioLogado(), $erroCodigo)->renderizar();
				break;
			case "download":
				$id = Pedido::obter('i');

				$modelo = new DownloadModel($this->getConexao());
				$controlador = new DownloadController($modelo);

				$retorno = $controlador->rodar($this->getUsuarioLogado(), $id);

				if ($retorno['sucesso']) {
					$paraMime = str_replace('jpg', 'jpeg', $retorno['imagem_tipo']);

					Resposta::conteudoTipo('image/'.$paraMime);
					Resposta::header('Content-Disposition', 'attachment; filename='.$retorno['imagem_arquivo']);

					echo $retorno['conteudo'];
				} else {
					Resposta::status(404);
					$retorno['conteudo']->renderizar();
				}
				break;
			default:
				$modelo = new NotFoundModel($this->getConexao());
				$controlador = new NotFoundController($modelo);

				Resposta::status(404);
				$controlador->rodar($this->getUsuarioLogado())->renderizar();
				break;
		}
	}
}

?>