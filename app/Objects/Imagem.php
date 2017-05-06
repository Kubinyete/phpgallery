<?php
/**
 * Classe responsável por representar uma imagem em nossa aplicação
 */

namespace App\Objects;

use App\Objects\Objeto;
use Config\Config;
use App\Utils\Utils;

class Imagem extends Objeto {
	// Os atributos precisam ser públicos para que nossa Api leia e retorne uma string JSON
	public $usuarioId;
	public $titulo;
	public $descricao;
	public $extensao;
	public $privada;
	public $largura;
	public $altura;

	public function __construct($id, $dataCriacao, $usuarioId, $titulo, $descricao, $extensao, $privada, $largura, $altura, $paraApi=false) {
		parent::__construct($id, $dataCriacao);

		$this->setUsuarioId($usuarioId);
		$this->setTitulo($titulo);
		$this->setDescricao($descricao);
		$this->setExtensao($extensao);
		$this->setLargura($largura);
		$this->setAltura($altura);

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

	public function getTitulo($formatar=false, $filtrarAspas=false) {
		if ($formatar) {
			if (strlen($this->titulo) < 1) {
				return Config::obter("Imagens.titulo_padrao");
			} else {
				$titulo = $this->titulo;
				if ($filtrarAspas) {
					$titulo = Utils::filtrarAspasJs($titulo);
				}
				return htmlentities($titulo, ENT_QUOTES);
			}
		} else {
			return $this->titulo;
		}
	}

	public function setTitulo($valor) {
		$this->titulo = strval($valor);
	}

	public function getDescricao($formatar=false, $filtrarAspas=false) {
		if ($formatar) {
			if (strlen($this->descricao) < 1) {
				return Config::obter("Imagens.descricao_padrao");
			} else {
				$descricao = $this->descricao;
				if ($filtrarAspas) {
					$descricao = Utils::filtrarAspasJs($descricao);
				}
				return htmlentities($descricao, ENT_QUOTES);
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

	public function getLargura() {
		return $this->largura;
	}

	public function setLargura($valor) {
		$this->largura = intval($valor);
	}

	public function getAltura() {
		return $this->altura;
	}

	public function setAltura($valor) {
		$this->altura = intval($valor);
	}

	public function getImagemUrl($adicionarSeparador=false) {
		return (($adicionarSeparador) ? "/" : "").Config::obter("Imagens.caminho_imagens").hash(Config::obter("Imagens.hash_nome"), $this->getId()).$this->getExtensao(true);
	}

	public function getMiniaturaUrl($adicionarSeparador=false) {
		return (($adicionarSeparador) ? "/" : "").Config::obter("Imagens.caminho_imagens").hash(Config::obter("Imagens.hash_nome"), $this->getId()).Config::obter("Imagens.miniatura_sufixo").'.'.Config::obter("Imagens.miniatura_extensao");
	}

	public function getLink() {
		return str_replace("%", $this->getId(), Config::obter("Imagens.link_imagem"));
	}

	public function getDownloadLink() {
		return str_replace('%', $this->getId(), Config::obter('Imagens.link_download'));
	}

	public function getEditarLink() {
		return str_replace('%', $this->getId(), Config::obter('Imagens.link_editar'));
	}
}

?>