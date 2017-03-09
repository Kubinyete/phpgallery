<?php
namespace PHPGallery\DatabaseObjeto;

require_once "Objeto.php";

/**
 * Classe responsável por representar um Comentário do banco de dados
 */
class Comentario extends Objeto {
	public $_img_id;
	public $_usr_id;
	public $_conteudo;

	public function __construct($id=0, $img_id=0, $usr_id=0, $conteudo="", $data_criacao="") {
		parent::__construct($id, $data_criacao);

		$this->set_img_id($img_id);
		$this->set_usr_id($usr_id);
		$this->set_conteudo($conteudo);
	}

	public function get_img_id() {
		return $this->_img_id;
	}

	public function set_img_id($valor) {
		$this->_img_id = intval($valor);
	}

	public function get_usr_id() {
		return $this->_usr_id;
	}

	public function set_usr_id($valor) {
		$this->_usr_id = intval($valor);
	}

	public function get_conteudo($formatarTags=false) {
		return ($formatarTags) ? htmlspecialchars($this->_conteudo) : $this->_conteudo;
	}

	public function set_conteudo($valor) {
		$this->_conteudo = strval($valor);
	}
}

?>