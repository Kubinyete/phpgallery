<?php
/**
 * Classe responsável por representar um usuário da nossa aplicação
 */

namespace App\Objects;

use App\Objects\Objeto;
use Config\UsuarioConfig;
use Config\ImagemConfig;
use App\Utils\Utils;

class Usuario extends Objeto {
	// Os atributos precisam ser públicos para que nossa Api leia e retorne uma string JSON
	public $nome;
	// Não queremos de jeito nenhum vazar a senha do usuário em uma resposta Api
	private $senha;
	public $descricao;
	public $temImagemPerfil;
	public $onlineTimestamp;
	private $admin;
	private $imgFundo;
	private $imgFundoExt;
	public $rep;

	public function __construct($id, $dataCriacao, $nome, $senha, $encriptografarSenha, $descricao, $temImagemPerfil, $onlineTimestamp, $admin, $imgFundo, $rep, $paraApi=false) {
		parent::__construct($id, $dataCriacao);
		
		$this->setNome($nome);
		$this->setDescricao($descricao);
		$this->setTemImagemPerfil($temImagemPerfil);
		$this->setOnlineTimestamp($onlineTimestamp);
		$this->setRep($rep);

		// Se não estamos lidando com Api
		if (!$paraApi) {
			$this->setSenha($senha, $encriptografarSenha);
			$this->setAdmin($admin);
			$this->setImgFundo($imgFundo);
		} else {
			// Retire o atributo de senha, pois será desnecessário e formate seus atributos
			unset($this->senha);
			unset($this->admin);
			unset($this->imgFundo);
			unset($this->imgFundoExt);
			$this->descricao = $this->getDescricao(true);
			$this->estaOnline = $this->estaOnline();
			$this->imagemUrl = $this->getImagemUrl();
			$this->imagemFundoUrl = $this->getImagemFundoUrl();
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

	public function getDescricao($formatar=false, $filtrarAspas=false) {
		if ($formatar) {
			if (strlen($this->descricao) < 1) {
				return UsuarioConfig::DESCRICAO_PADRAO;
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
		return ($this->getOnlineTimestamp() + UsuarioConfig::PERIODO_ONLINE >= time());
	}

	public function getAdmin() {
		return $this->admin;
	}

	public function setAdmin($valor) {
		$this->admin = ($valor === '1') ? true : false;
	}

	public function getImgFundo() {
		return $this->imgFundo;
	}

	public function setImgFundo($valor) {
		$this->imgFundo = intval($valor);
	}

	public function getImgFundoExt() {
		return $this->imgFundoExt;
	}

	public function setImgFundoExt($valor) {
		$this->imgFundoExt = strval($valor);
	}

	public function getRep() {
		return $this->rep;
	}

	public function setRep($valor) {
		$this->rep = intval($valor);
	}

	public function getImagemUrl($adicionarSeparador=false) {
		$sep = ($adicionarSeparador) ? "/" : "";

		if ($this->getTemImagemPerfil()) {
			return $sep.UsuarioConfig::CAMINHO_IMAGENS_PERFIL.hash(UsuarioConfig::HASH_NOME_IMAGEM_PERFIL, $this->getId()).".".UsuarioConfig::IMAGEM_EXTENSAO_PADRAO;
		} else {
			return $sep.UsuarioConfig::CAMINHO_IMAGEM_PERFIL_PADRAO;
		}
	}

	public function getImagemFundoUrl($adicionarSeparador=false) {
		$sep = ($adicionarSeparador) ? "/" : "";

		if ($this->getImgFundo() > 0) {
			return $sep.ImagemConfig::CAMINHO_IMAGENS.hash(ImagemConfig::HASH_NOME_IMAGEM, $this->getImgFundo()).".".$this->getImgFundoExt();
		} else {
			return $sep.UsuarioConfig::CAMINHO_IMAGEM_FUNDO_PADRAO;
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
		} else if ($this->getImgFundo() !== $usuario->getImgFundo()) {
			$retorno = false;
		} else if ($this->getAdmin() !== $usuario->getAdmin()) {
			$retorno = false;
		} else if ($this->getRep() !== $usuario->getRep()) {
			$retorno = false;
		}

		return $retorno;
	}

	public function getLink() {
		return str_replace("%", $this->getNome(), UsuarioConfig::LINK_USUARIO);
	}
}

?>