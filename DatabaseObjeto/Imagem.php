<?php
namespace PHPGallery\DatabaseObjeto;

require_once "Objeto.php";
require_once "Referencias.php";

/**
 * Classe responsável por representar uma Imagem do banco de dados
 */
class Imagem extends Objeto {
	// Título da imagem se o mesmo estiver vazio (NULL)
	protected static $titulo_padrao = "Nenhum título está disponível.";
	// Descrição da imagem se o mesmo estiver vazio (NULL)
	protected static $descricao_padrao = "Nenhuma descrição está disponível.";

	public $_usr_id;
	public $_titulo;
	public $_descricao;
	public $_extensao;

	public function __construct($id=0, $usr_id=0, $titulo="", $descricao="", $data_criacao="", $extensao="") {
		parent::__construct($id, $data_criacao);

		$this->set_usr_id($usr_id);
		$this->set_titulo($titulo);
		$this->set_descricao($descricao);
		$this->set_extensao($extensao);
	}

	public function get_usr_id() {
		return $this->_usr_id;
	}

	public function set_usr_id($valor) {
		$this->_usr_id = intval($valor);
	}

	public function get_titulo($formatar_tags=false) {
		if ($formatar_tags) {
			if (strlen($this->_titulo) < 1) {
				return self::$titulo_padrao;
			} else {
				return htmlspecialchars($this->_titulo);
			}
		} else {
			return $this->_titulo;
		}
	}

	public function set_titulo($valor) {
		$this->_titulo = strval($valor);
	}

	public function get_descricao($formatar_tags=false) {
		if ($formatar_tags) {
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

	public function get_extensao($retornarPonto=false) {
		return (($retornarPonto) ? "." : "") . $this->_extensao;
	}

	public function set_extensao($valor) {
		$this->_extensao = strval($valor);
	}

	// Obtem o caminho da imagem em questão Ex: (/resources/image/{md5_hash}{ext})
	public function obter_imagem_url() {
		return Referencias::$caminho_imagens . md5($this->get_id()) . $this->get_extensao(true);
	}
}

?>
