<?php
/**
 * Classe responsável por representar um usuário da nossa aplicação
 */

namespace App\Objects;

use App\Objects\Objeto;
use Config\UsuarioConfig;

class Usuario extends Objeto {
	public $nome;
	protected $senha;
	public $descricao;
	public $temImagemPerfil;
	public $onlineTimestamp;

	public function __construct($id, $dataCriacao, $nome, $senha, $encriptografarSenha, $descricao, $temImagemPerfil, $onlineTimestamp, $paraApi=false) {
		parent::__construct($id, $dataCriacao);
		
		$this->setNome($nome);
		$this->setDescricao($descricao);
		$this->setTemImagemPerfil($temImagemPerfil);
		$this->setOnlineTimestamp($onlineTimestamp);

		if (!$paraApi) {
			$this->setSenha($senha, $encriptografarSenha);
		} else {
			unset($this->senha);
			$this->descricao = $this->getDescricao(true);
			$this["estaOnline"] = $this->estaOnline();
			$this["imagemUrl"] = $this->getImagemUrl();
		}
	}

	public function getNome() {
		return $this->nome;
	}

	public function setNome($valor) {
		$this->nome = strval($valor);
	}

	public function getSenha() {
		return $this->senha;
	}

	public function setSenha($valor, $encriptografarSenha) {
		if ($encriptografarSenha) {
			$this->senha = hash(UsuarioConfig::HASH_ALGORITIMO, strval($valor));
		} else {
			$this->senha = strval($valor);
		}
	}

	public function getDescricao($formatar=false) {
		if ($formatar) {
			if (strlen($this->descricao) < 1) {
				return UsuarioConfig::DESCRICAO_PADRAO;
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

	public function getTemImagemPerfil() {
		return $this->temImagemPerfil;
	}

	public function setTemImagemPerfil($valor) {
		$this->temImagemPerfil = boolval($valor);
	}

	public function getOnlineTimestamp() {
		return $this->onlineTimestamp;
	}

	public function setOnlineTimestamp($valor) {
		$this->onlineTimestamp = intval($valor);
	}

	public function estaOnline() {
		return ($this->getOnlineTimestamp + UsuarioConfig::PERIODO_ONLINE >= time());
	}

	public function getImagemUrl() {
		if ($this->getTemImagemPerfil()) {
			return UsuarioConfig::CAMINHO_IMAGENS_PERFIL.hash(UsuarioConfig::HASH_NOME_IMAGEM_PERFIL, $this->getId()).".".UsuarioConfig::IMAGEM_EXTENSAO_PADRAO;
		} else {
			return UsuarioConfig::CAMINHO_IMAGEM_PERFIL_PADRAO;
		}
	}

	public function igualA($usuario) {
		$retorno = true;

		if ($this->getNome() !== $usuario->getNome()) {
			$retorno = false;

		} else if ($this->getSenha() !== $usuario->getSenha()) {
			$retorno = false;

		} else if ($this->getDescricao() !== $usuario->getDescricao()) {
			$retorno = false;

		} else if ($this->getTemImagemPerfil() !== $usuario->getTemImagemPerfil()) {
			$retorno = false;

		} else if ($this->getOnlineTimestamp() !== $usuario->getOnlineTimestamp()) {
			$retorno = false;
		}

		return $retorno;
	}
}

?>