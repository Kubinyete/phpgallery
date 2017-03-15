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
				date("Y-m-d H:m-i"),
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
}

?>
