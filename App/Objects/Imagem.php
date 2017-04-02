<?php
/**
 * Classe responsável por representar uma imagem em nossa aplicação
 */

namespace App\Objects;

use App\Objects\Objeto;
use Config\ImagemConfig;

class Imagem extends Objeto {
	// Os atributos precisam ser públicos para que nossa Api leia e retorne uma string JSON
	public $usuarioId;
	public $titulo;
	public $descricao;
	public $extensao;
	public $privada;

	public function __construct($id, $dataCriacao, $usuarioId, $titulo, $descricao, $extensao, $privada, $paraApi=false) {
		parent::__construct($id, $dataCriacao);

		$this->setUsuarioId($usuarioId);
		$this->setTitulo($titulo);
		$this->setDescricao($descricao);
		$this->setExtensao($extensao);

		// Se não estamos utilizando esse objeto para respostas Api
		// atualize a informação privada
		if (!$paraApi) {
			$this->setPrivada($privada);
		} else {
			// Se estamos usando para Api, retire informações privadas do objeto e formate alguns atributos
			unset($this->privada);
			$this->titulo = $this->getTitulo(true);
			$this->descricao = $this->getDescricao(true);
			$this->imagemUrl = $this->getImagemUrl();
		}
	}

	public function getUsuarioId() {
		return $this->usuarioId;
	}

	public function setUsuarioId($valor) {
		$this->usuarioId = intval($valor);
	}

	public function getTitulo($formatar=false) {
		if ($formatar) {
			if (strlen($this->titulo) < 1) {
				return ImagemConfig::TITULO_PADRAO;
			} else {
				return htmlspecialchars($this->titulo);
			}
		} else {
			return $this->titulo;
		}
	}

	public function setTitulo($valor) {
		$this->titulo = strval($valor);
	}

	public function getDescricao($formatar=false) {
		if ($formatar) {
			if (strlen($this->descricao) < 1) {
				return ImagemConfig::DESCRICAO_PADRAO;
			} else {
				return htmlspecialchars($this->descricao);
			}
		} else {
			return $this->descricao;
		}
	}

	public function setDescricao($valor) {
		$this->descricao = strval($valor);
	}

	public function getExtensao($adicionarPonto=false) {
		return (($adicionarPonto) ? "." : "").$this->extensao;
	}

	public function setExtensao($valor) {
		$this->extensao = strval($valor);
	}

	public function getPrivada() {
		return $this->privada;
	}

	public function setPrivada($valor) {
		$this->privada = boolval($valor);
	}

	public function getImagemUrl($adicionarSeparador=false) {
		return (($adicionarSeparador) ? "/" : "").ImagemConfig::CAMINHO_IMAGENS.hash(ImagemConfig::HASH_NOME_IMAGEM, $this->getId()).$this->getExtensao(true);
	}

	public function getMiniaturaUrl() {
		return str_replace("%", $this->getId(), ImagemConfig::PROCESSADOR_MINIATURAS);
	}

	public function getLink() {
		return str_replace("%", $this->getId(), ImagemConfig::LINK_IMAGEM);
	}
}

?>