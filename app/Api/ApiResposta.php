<?php
/**
 * Classe responsável por representar uma encapsulação de um objeto como resposta de um determinado
 * processador de pedidos Api
 */

namespace App\Api;

class ApiResposta {
	private $objeto;

	public function __construct($objeto) {
		$this->setObjeto($objeto);
	}

	public function getObjeto() {
		return $this->objeto;
	}

	public function setObjeto($valor) {
		$this->objeto = [
			"dados" => $valor
		];
	}

	public function obter() {
		return json_encode($this->getObjeto(), JSON_PRETTY_PRINT);
	}

	public function enviar() {
		echo $this->obter();
	}
}

?>