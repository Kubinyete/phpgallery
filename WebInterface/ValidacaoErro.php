<?php
namespace PHPGallery\WebInterface;

require_once "ValidacaoErroDefinicoes.php";

use Exception;

/**
 * Um erro de validação derivado de Exception
 */
class ValidacaoErro extends Exception {
	public function __construct($codigo=0) {
		if (isset(ValidacaoErroDefinicoes::$validacao_erros[$codigo])) {
			$this->message = ValidacaoErroDefinicoes::$validacao_erros[$codigo];
		} else {
			$this->message = ValidacaoErroDefinicoes::$validacao_erros[VE_DESCONHECIDO];
		}
	}
}

?>