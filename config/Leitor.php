<?php
/**
 * Leitor de configurações
 */

namespace Config;

use Exception;

class Leitor {
	private $raw_json;

	public function __construct($arquivo) {
		if (!file_exists($arquivo)) {
			throw new Exception('O arquivo de configurações \''.$arquivo.'\' não existe.');
		} else {
			$this->raw_json = @file_get_contents($arquivo);
		}
	}

	public function getRawJson() {
		return $this->raw_json;
	}

	public function setRawJson($valor) {
		$this->raw_json = $valor;
	}

	public function setArquivo($arquivo) {
		self::__construct($arquivo);
	}

	public function getJsonObjeto() {
		return json_decode($this->raw_json, true);
	}
}

?>