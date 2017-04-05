<?php
/**
 * Classe responsável por representar um comentário em nossa aplicação
 */

namespace App\Objects;

use App\Utils\Utils;

class Comentario extends Objeto {
	// Os atributos precisam ser públicos para que nossa Api leia e retorne uma string JSON
	public $imagemId;
	public $usuarioId;
	public $conteudo;

	public function __construct($id, $dataCriacao, $imagemId, $usuarioId, $conteudo, $paraApi=false) {
		parent::__construct($id, $dataCriacao);

		$this->setImagemId($imagemId);
		$this->setUsuarioId($usuarioId);
		$this->setConteudo($conteudo);

		// Se vamos utilizar esse objeto como uma resposta Api, formate o conteûdo
		if ($paraApi) {
			$this->conteudo = $this->getConteudo(true);
		}
	}

	public function getImagemId() {
		return $this->imagemId;
	}

	public function setImagemId($valor) {
		$this->imagemId = intval($valor);
	}

	public function getUsuarioId() {
		return $this->usuarioId;
	}

	public function setUsuarioId($valor) {
		$this->usuarioId = intval($valor);
	}

	public function getConteudo($formatar=false, $filtrarAspas=false) {
		$conteudo = $this->conteudo;
		if ($filtrarAspas) {
			$conteudo = Utils::filtrarAspasJs($conteudo);
		}
		return ($formatar) ? htmlentities($conteudo, ENT_QUOTES) : $this->conteudo;
	}

	public function setConteudo($valor) {
		$this->conteudo = strval($valor);
	}
}

?>