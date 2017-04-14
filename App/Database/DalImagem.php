<?php
/**
 * Classe responsável por representar uma Database Access Layer de objetos do tipo Imagem
 */

namespace App\Database;

use App\Database\Dal;
use App\Objects\Imagem;
use App\Database\SqlComando;
use Config\Config;

class DalImagem extends Dal {
	// Cria uma imagem no banco de dados de acordo com o objeto Imagem passado como argumento
	public function criarImagem($imagem) {
		$sql = new SqlComando();
		
		$sql->insert("Imagens", 
			[
				"usr_id" => $imagem->getUsuarioId(),
				"img_titulo" => $imagem->getTitulo(),
				"img_descricao" => $imagem->getDescricao(),
				"img_data_criacao" => $imagem->getDataCriacao(),
				"img_extensao" => $imagem->getExtensao(),
				"img_privada" => ($imagem->getPrivada()) ? "1" : "0",
				"img_largura" => $imagem->getLargura(),
				"img_altura" => $imagem->getAltura()
			]
		);

		$this->conexao->conectar();
		$this->executar($sql);

		$sql = new SqlComando();
		$sql->select("img_id")->as("id")->from("Imagens")->order("img_id", "DESC")->limit(1);

		$resultadoId = $this->executar($sql);

		$id = null;

		if ($resultadoId != false) {
			$resultadoId = $resultadoId->fetchAll();
			if (count($resultadoId) > 0) {
				$id = intval($resultadoId[0]["id"]);
			}
		}

		$this->conexao->desconectar();

		$imagem->setId($id);

		return $id;
	}

	// Obtem um objeto Imagem de acordo com o id passado
	public function obterImagem($id, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Imagens")->where("img_id", "=", $id)->limit(1);

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagem = null;

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				$imagem = new Imagem(
					$resultado[0]["img_id"],
					$resultado[0]["img_data_criacao"],
					$resultado[0]["usr_id"],
					$resultado[0]["img_titulo"],
					$resultado[0]["img_descricao"],
					$resultado[0]["img_extensao"],
					$resultado[0]["img_privada"],
					$resultado[0]["img_largura"],
					$resultado[0]["img_altura"],
					$paraApi
				);
			}
		}

		$this->conexao->desconectar();

		return $imagem;
	}

	// Obtem uma lista de objetos Imagem de acordo com a string de busca passada
	public function listarImagens($procura, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Imagens")->where("img_titulo", "LIKE", "%".$procura."%")->or()->expressao("img_descricao", "LIKE", "%".$procura."%")->or()->expressao("img_id", "LIKE", "%".$procura."%")->or()->expressao("img_data_criacao", "LIKE", "%".$procura."%");

		if (Config::obter("Imagens.listar_limite") > 0) {
			$sql->limit(Config::obter("Imagens.listar_limite"));
		}

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				foreach ($resultado as $array) {
					$imagem = new Imagem(
						$array["img_id"],
						$array["img_data_criacao"],
						$array["usr_id"],
						$array["img_titulo"],
						$array["img_descricao"],
						$array["img_extensao"],
						$array["img_privada"],
						$array["img_largura"],
						$array["img_altura"],
						$paraApi
					);

					array_push($imagens, $imagem);
				}
			}
		}

		$this->conexao->desconectar();

		return $imagens;
	}

	// Obtem uma lista de objetos Imagem de um autor
	public function listarImagensUsuario($usuarioId, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Imagens")->where("usr_id", "=", $usuarioId)->and()->expressao("img_privada", "=", "0")->order("img_id", "DESC");

		if (Config::obter("Imagens.listar_usuarios_limite") > 0) {
			$sql->limit(Config::obter("Imagens.listar_usuarios_limite"));
		}

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				foreach ($resultado as $array) {
					$imagem = new Imagem(
						$array["img_id"],
						$array["img_data_criacao"],
						$array["usr_id"],
						$array["img_titulo"],
						$array["img_descricao"],
						$array["img_extensao"],
						$array["img_privada"],
						$array["img_largura"],
						$array["img_altura"],
						$paraApi
					);

					array_push($imagens, $imagem);
				}
			}
		}

		$this->conexao->desconectar();

		return $imagens;
	}

	// Obtem uma lista de objetos Imagem recentes
	public function listarRecentes($paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Imagens")->where("img_privada", "=", "0")->order("img_id", "DESC");

		if (Config::obter("Imagens.listar_recentes_limite") > 0) {
			$sql->limit(Config::obter("Imagens.listar_recentes_limite"));
		}

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				foreach ($resultado as $array) {
					$imagem = new Imagem(
						$array["img_id"],
						$array["img_data_criacao"],
						$array["usr_id"],
						$array["img_titulo"],
						$array["img_descricao"],
						$array["img_extensao"],
						$array["img_privada"],
						$array["img_largura"],
						$array["img_altura"],
						$paraApi
					);

					array_push($imagens, $imagem);
				}
			}
		}

		return $imagens;
	}

	// Obtem a contagem de todas as imagens no banco de dados
	public function contagemImagens() {
		$sql = new SqlComando();

		$sql->select("COUNT(img_id)")->as("contagem")->from("Imagens");

		$resultado = $this->executar($sql);

		$contagem = 0;

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();
			if (count($resultado) > 0) {
				$contagem = intval($resultado[0]["contagem"]);
			}
		}

		return $contagem;
	}

	// Atualiza o estado de um objeto no banco de dados de acordo com sua representação passada pelo argumento
	public function atualizarImagem($imagem) {
		$sql = new SqlComando();

		$sql->update("Imagens", 
			[
				"img_titulo" => $imagem->getTitulo(),
				"img_descricao" => $imagem->getDescricao(),
				"img_privada" => ($imagem->getPrivada) ? "1" : "0",
				"img_largura" => $imagem->getLargura(),
				"img_altura" => $imagem->getAltura()
			]
		)->where("img_id", "=", $imagem->getId());

		$this->conexao->conectar();
		$this->executar($sql);
		$this->conexao->desconectar();
	}

	// Deleta uma imagem do banco de dados de acordo com a id passada por argumento
	public function deletarImagem($id) {
		$sql = new SqlComando();

		$sql->delete("Imagens")->where("img_id", "=", $id);

		$this->conexao->conectar();
		$this->executar($sql);
		$this->conexao->desconectar();
	}
}

?>