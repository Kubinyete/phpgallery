<?php
namespace PHPGallery\WebInterface;

require_once "ValidacaoErro.php";
require_once "ValidacaoErroDefinicoes.php";
require_once "Resposta.php";

set_include_path("..");

require_once "DatabaseInterface/DatabaseUsuario.php";
require_once "DatabaseObjeto/Usuario.php";

use PHPGallery\DatabaseInterface\DatabaseALUsuario;
use PHPGallery\DatabaseObjeto\Usuario;

/**
 * Classe responsável por efetuar o registro de Usuários, Imagens & Comentários através da validação dos dados
 */
class Validacao {
	protected $_conexao;

	public static $min_caracteres_nome = 4;
	public static $max_caracteres_nome = 16;

	public static $min_caracteres_senha = 6;
	public static $max_caracteres_senha = 32;

	public function __construct($conexao) {
		$this->_conexao = $conexao;
	}

	// Retorna false se o campo atual contêm algum caráctere inválido
	public static function campo_sem_caracteres_invalidos($string) {
		if ($string === null) {
			return false;
		}

		$retorno = true;
		for ($i = 0; $i < strlen($string); $i++) {
			if (ord($string[$i]) <= 47 || ord($string[$i]) >= 58 && ord($string[$i]) <= 64 || ord($string[$i]) >= 91 && ord($string[$i]) <= 96 || ord($string[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}

	// Retorna se o tamanho da cadeia de carácteres está dentro do permitido
	// $nome_ou_senha => (true) nome
	// $nome_ou_senha => (false) senha
	public static function campo_tamanho_esta_valido($string, $nome_ou_senha) {
		if ($string === null) {
			return false;
		}

		if ($nome_ou_senha) {
			return ((strlen($string) <= self::$max_caracteres_nome) && (strlen($string) >= self::$min_caracteres_nome));
		} else {
			return ((strlen($string) <= self::$max_caracteres_senha) && (strlen($string) >= self::$min_caracteres_senha));
		}
	}

	// Efetua login no sistema
	// se o usuário informado o login corretamente, retorna o objeto Usuario do banco de dados
	// para então ser implementado na sessão atual
	public function efetuar_login($nome, $senha) {
		// Vamos já negar campos inválidos, evitando uma conexão inútil em busca de um usr_nome ou usr_senha inválido
		if (!self::campo_sem_caracteres_invalidos($nome)) {
			throw new ValidacaoErro(VE_LOGIN_INVALIDO);
		} else if (!self::campo_sem_caracteres_invalidos($senha)) {
			throw new ValidacaoErro(VE_LOGIN_INVALIDO);
		}

		$dal = new DatabaseALUsuario($this->_conexao);
		$database_usuario = $dal->obter_usuario($nome, true);

		if ($database_usuario !== null) {
			// Vamos verificar se o login está correto
			$usuario = new Usuario(
				0,
				$nome,
				$senha,
				true,
				"",
				false,
				"0000-00-00 00:00:00",
				0,
				false
			);

			if ($usuario->get_senha() === $database_usuario->get_senha()) {
				// O login é válido
				Sessao::set_usuario($database_usuario);
				Resposta::redirecionar("?v=home");
			} else {
				// O login é inválido
				throw new ValidacaoErro(VE_LOGIN_INVALIDO);
			}
		} else {
			throw new ValidacaoErro(VE_LOGIN_INVALIDO);
		}
	}

	// Registra um usuário no sistema
	public function registrar_usuario($nome, $senha, $confirma_senha) {
		if (!self::campo_sem_caracteres_invalidos($nome)) {
			throw new ValidacaoErro(VE_REGISTRA_NOME_INVALIDO);
		} else if (!self::campo_sem_caracteres_invalidos($senha)) {
			throw new ValidacaoErro(VE_REGISTRA_SENHA_INVALIDA);
		} else if (!self::campo_tamanho_esta_valido($nome, true)) {
			throw new ValidacaoErro(VE_REGISTRA_NOME_TAMANHO_INVALIDO);
		} else if (!self::campo_tamanho_esta_valido($senha, false)) {
			throw new ValidacaoErro(VE_REGISTRA_SENHA_TAMANHO_INVALIDO);
		}

		$dal = new DatabaseALUsuario($this->_conexao);
		$database_usuario = $dal->obter_usuario($nome, true);

		if ($database_usuario === null) {
			// Registre
			if ($senha !== $confirma_senha) {
				throw new ValidacaoErro(VE_REGISTRA_CONFIRMA_SENHA_INVALIDA);
			}

			$usuario = new Usuario(
				0,
				$nome,
				$senha,
				true,
				"",
				false,
				// Para inserir, o SQLServer só aceita YYYYMMDD HH:MM:SS
				date("Y-m-d H:m:i"),
				time(),
				false
			);

			$usuario = $dal->criar_usuario($usuario);
			Sessao::set_usuario($usuario);
			Resposta::redirecionar("?v=home");
		} else {
			// O usuário já existe
			throw new ValidacaoErro(VE_REGISTRA_JA_EXISTE);
		}
	}
}

?>
