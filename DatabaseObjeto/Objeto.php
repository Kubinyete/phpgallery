<?php
namespace PHPGallery\DatabaseObjeto;

/**
 * Classe mestre de todos os objetos do nosso banco de dados
 */
class Objeto {
	public $_id;
	public $_data_criacao;

	public function __construct($id=0, $data_criacao) {
		$this->set_id($id);
		$this->set_data_criacao($data_criacao);

		$tm = "America/Sao_Paulo";
		if (date_default_timezone_get() !== $tm) {
			date_default_timezone_set($tm);
		}
	}

	public function get_id() {
		return $this->_id;
	}

	public function set_id($valor) {
		$this->_id = intval($valor);
	}

	public function get_data_criacao($formatar=false) {
		return ($formatar) ? $this->obter_data_criacao_formatada() : $this->_data_criacao;
	}

	public function set_data_criacao($valor) {
		//YYYY-MM-DD HH:MM:SS
		$local = strval($valor);
		if (strlen($local) >= 19) {
			$this->_data_criacao = $local;
		} else {
			// Não é possível aceitar uma data menor que 19 carácteres pois obter_data_criacao_formatada() irá cortar a string em posições específicas
			throw new Exception("A data a ser inserida não é válida.");
		}
	}

	protected function obter_data_criacao_formatada() {
		return substr($this->_data_criacao, 8, 2) . "/" . substr($this->_data_criacao, 5, 2) . "/" . substr($this->_data_criacao, 0, 4) . " ás " . substr($this->_data_criacao, 11, 8);
	}
}

?>
