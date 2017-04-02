<?php
/**
 * Classe responsável por representar um objeto genérico para que
 * outros objetos específicos derivem propriedades deste objeto mestre
 */

namespace App\Objects;

abstract class Objeto {
	// Os atributos precisam ser públicos para que nossa Api leia e retorne uma string JSON
	public $id;
	public $dataCriacao;

	public function __construct($id, $dataCriacao) {
		$this->setId($id);
		$this->setDataCriacao($dataCriacao);
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = intval($id);
	}

	public function getDataCriacao($modo=0) {
		$modo = intval($modo);

		switch ($modo) {
			// Retorna o valor
			case 0:
				return $this->dataCriacao;
				break;
			// Retorna o valor formatado para visualização
			case 1:
				return substr($this->dataCriacao, 8, 2)."/".substr($this->dataCriacao, 5, 2)."/".substr($this->dataCriacao, 0, 4)." ás ".substr($this->dataCriacao, 11, 8);
				break;
			// Retorna o valor formatado para inserção no banco de dados
			// necessário pois os dados de tipo datetime retornam YYYY-MM-DD HH:MM:SS
			// sendo que para inserir é necessário informar YYYYMMDD HH:MM:SS
			case 2:
				return str_replace("-", "", $this->dataCriacao);
				break;
			default:
				return $this->dataCriacao;
				break;
		}
	}

	public function setDataCriacao($valor) {
		$this->dataCriacao = strval($valor);
	}

	// Para testes
	public function toString() {
		var_dump($this);
	}
}

?>