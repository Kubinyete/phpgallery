<?php
/**
 * Representa o nosso modelo de acesso para exibição e efetuação de login na aplicação
 */

namespace App\Models;

use App\Models\Model;
use App\Database\DalUsuario;
use App\Objects\Usuario;
use App\Views\LoginView;
use App\MvcErrors\LoginErro;

class LoginModel extends Model {
	// $conexao
	
	public function index($usuarioLogado) {
		return [
			"retorno" => "view",
			"retorno_obj" => new LoginView($usuarioLogado)
		];
	}

	// Efetua login
	public function logar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha) {
		if (count($errosLista) <= 0) {
			$dal = new DalUsuario($this->conexao);
			$dbUsuario = $dal->obterUsuario(false, $usuarioNome);

			if ($dbUsuario !== null) {
				$usuario = new Usuario(0, "", "", $usuarioSenha, true, "", false, 0);
				if ($dbUsuario->getSenha() === $usuario->getSenha()) {
					return [
						"retorno" => "usuario",
						"retorno_obj" => $dbUsuario
					];
				} else {
					array_push($errosLista, LoginErro::LOGIN_SENHA_ERRADA);
					return $this->erro($usuarioLogado, $acao, $errosLista);
				}
			} else {
				array_push($errosLista, LoginErro::LOGIN_USUARIO_NAO_EXISTE);
				return $this->erro($usuarioLogado, $acao, $errosLista);
			}
		// Já ocorreu erros na camadada Controller acima, apenas retorne esses erros
		} else {
			return $this->erro($usuarioLogado, $acao, $errosLista);
		}
	}

	// Registra um usuário
	public function registrar($usuarioLogado, $acao, $errosLista, $usuarioNome, $usuarioSenha) {
		if (count($errosLista) <= 0) {
			$dal = new DalUsuario($this->conexao);
			$dbUsuario = $dal->obterUsuario(false, $usuarioNome);

			if ($dbUsuario === null) {
				$usuario = new Usuario(0, date("Y-m-d H:i:s"), $usuarioNome, $usuarioSenha, true, "", false, time());
				
				$dal->criarUsuario($usuario);

				return [
					"retorno" => "usuario",
					"retorno_obj" => $usuario
				];

			} else {
				array_push($errosLista, LoginErro::REGISTRAR_USUARIO_JA_EXISTE);
				return $this->erro($usuarioLogado, $acao, $errosLista);
			}
		// Já ocorreu erros na camadada Controller acima, apenas retorne esses erros
		} else {
			return $this->erro($usuarioLogado, $acao, $errosLista);
		}
	}

	// Retorna uma LoginView com uma string de erro
	// de acordo com a lista de erros informados
	public function erro($usuarioLogado, $acao, $errosLista) {
		$mensagem = "";
		$separador = "<br>\n";

		foreach ($errosLista as $codigo) {
			if (isset(LoginErro::DEFINICOES[$codigo])) {
				$mensagem .= LoginErro::DEFINICOES[$codigo].$separador;
			}
		}

		return [
			"retorno" => "view",
			"retorno_obj" => new LoginView($usuarioLogado, $acao, $mensagem)
		];
	}
}

?>