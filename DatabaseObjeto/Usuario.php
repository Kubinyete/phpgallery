<?php
namespace PHPGallery\DatabaseObjeto;

require_once "Objeto.php";
require_once "Referencias.php";

/**
 * Classe responsável por representar um Usuário do nosso banco de dados
 */
class Usuario extends Objeto {
	// Descrição do usuário se o mesmo não tiver nenhuma descrição (NULL)
	protected static $descricao_padrao = "Nenhuma descrição está disponível para este usuário.";
	// O formato (extensão) padrão que todas as imagens de perfil terão
	protected static $imagem_extensao = ".jpg";
	// Periodo em segundos* que o usuário ficará como Online
	protected static $periodo_online = 60;

	public $_nome;
	public $_senha;
	public $_descricao;
	public $_tem_imagem_perfil;
	public $_online_timestamp;

	public function __construct($id=0, $nome="", $senha="", $encriptar_senha=false, $descricao="", $tem_imagem_perfil=false, $data_criacao="", $online_timestamp=0, $para_api=false) {
		parent::__construct($id, $data_criacao);

		$this->set_nome($nome);
		if (!$para_api) {
			$this->set_senha($senha, $encriptar_senha);
		} else {
			unset($this->_senha);
		}

		$this->set_descricao($descricao);
		$this->set_tem_imagem_perfil($tem_imagem_perfil);
		$this->set_online_timestamp($online_timestamp);
	}

	public function get_nome() {
		return $this->_nome;
	}

	public function set_nome($valor) {
		$this->_nome = strval($valor);
	}

	public function get_senha() {
		return $this->_senha;
	}

	// Para a camada de criação e validação de objetos, podemos encriptografar a senha na hora de criar o objeto (construtor está usando set_senha, e com o argumento $encriptar)
	public function set_senha($valor, $encriptar=false) {
		$this->_senha = ($encriptar) ? hash("sha256", strval($valor)) : strval($valor);
	}

	public function get_descricao($formatarTags=false) {
		if ($formatarTags) {
			if (strlen($this->_descricao) < 1) {
				return self::$descricao_padrao;
			} else {
				return htmlspecialchars($this->_descricao);
			}
		} else {
			return $this->_descricao;
		}
	}

	public function set_descricao($valor) {
		$this->_descricao = strval($valor);
	}

	public function get_tem_imagem_perfil() {
		return $this->_tem_imagem_perfil;
	}

	public function set_tem_imagem_perfil($valor) {
		$this->_tem_imagem_perfil = boolval($valor);
	}

	public function get_online_timestamp() {
		return $this->_online_timestamp;
	}

	public function set_online_timestamp($valor) {
		$this->_online_timestamp = intval($valor);
	}

	// Retorna se o usuário está Online ainda, com base no tempo limite que definimos na classe
	public function esta_online() {
		if ($this->get_online_timestamp() + self::$periodo_online >= time()) {
			return true;
		} else {
			return false;
		}
	}

	// Retorna o caminho da imagem de perfil do usuário Ex: (resources/profile/{md5_id}{ext})
	public function obter_imagem_url() {
		if ($this->get_tem_imagem_perfil()) {
			return Referencias::$caminho_imagens_perfil . md5($this->get_id()) . self::$imagem_extensao;
		} else {
			return Referencias::$imagem_perfil_padrao;
		}
	}

	// Retorna se este usuário é igual a outro usuário
	// (Excluindo as comparações entre id & data_criacao, pois nunca serão modificadas pelo sistema)
	public function igual($usuario) {
		$retorno = false;
		if ($this->_nome !== $usuario->_nome) {
			$retorno = true;
		} else if ($this->_senha !== $usuario->_senha) {
			$retorno = true;
		} else if ($this->_descricao !== $usuario->_descricao) {
			$retorno = true;
		} else if ($this->_tem_imagem_perfil !== $usuario->_tem_imagem_perfil) {
			$retorno = true;
		} else if ($this->_online_timestamp !== $usuario->_online_timestamp) {
			$retorno = true;
		}

		return $retorno;
	}
}

?>
