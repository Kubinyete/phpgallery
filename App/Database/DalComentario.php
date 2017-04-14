<?php
/**
 * Classe responsável por representar uma Database Access Layer de objetos do tipo Comentario
 */

namespace App\Database;

use App\Database\Dal;
use App\Objects\Comentario;
use App\Database\SqlComando;
use Config\Config;

class DalComentario extends Dal {
	// Cria um comentário no banco de dados de acordo com o objeto Comentario passado como argumento
	public function criarComentario($comentario) {
		$sql = new SqlComando();
		
		$sql->insert("Comentarios", 
			[
				"img_id" => $comentario->getImagemId(),
				"usr_id" => $comentario->getUsuarioId(),
				"cmt_conteudo" => $comentario->getConteudo(),
				"cmt_data_criacao" => $comentario->getDataCriacao(),
			]
		);

		$this->conexao->conectar();
		$this->executar($sql);

		$sql = new SqlComando();
		$sql->select("cmt_id")->as("id")->from("Comentarios")->order("cmt_id", "DESC")->limit(1);

		$resultadoId = $this->executar($sql);

		$id = null;

		if ($resultadoId != false) {
			$resultadoId = $resultadoId->fetchAll();
			if (count($resultadoId) > 0) {
				$id = intval($resultadoId[0]["id"]);
			}
		}

		$this->conexao->desconectar();

		$comentario->setId($id);

		return $id;
	}

	// Obtem um objeto Comentario de acordo com o id passado
	public function obterComentario($id, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Comentarios")->where("cmt_id", "=", $id)->limit(1);

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$comentario = null;

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				$comentario = new Comentario(
					$resultado[0]["cmt_id"],
					$resultado[0]["cmt_data_criacao"],
					$resultado[0]["img_id"],
					$resultado[0]["usr_id"],
					$resultado[0]["cmt_conteudo"],
					$paraApi
				);
			}
		}

		$this->conexao->desconectar();

		return $comentario;
	}

	// Obtem uma lista de objetos Comentario de acordo com o id da imagem passada
	public function listarComentarios($imgId, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select()->from("Comentarios")->where("img_id", "=", $imgId);

		if (Config::obter("Comentarios.listar_limite") > 0) {
			$sql->limit(Config::obter("Comentarios.listar_limite"));
		}

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$comentarios = [];

		if ($resultado != false) {
			$resultado = $resultado->fetchAll();

			if (count($resultado) > 0) {
				foreach ($resultado as $array) {
					$comentario = new Comentario(
						$array["cmt_id"],
						$array["cmt_data_criacao"],
						$array["img_id"],
						$array["usr_id"],
						$array["cmt_conteudo"],
						$paraApi
					);

					array_push($comentarios, $comentario);
				}
			}
		}

		$this->conexao->desconectar();

		return $comentarios;
	}

	// Atualiza o estado de um objeto no banco de dados de acordo com sua representação passada pelo argumento
	public function atualizarComentario($comentario) {
		$sql = new SqlComando();

		$sql->update("Comentarios", 
			[
				"cmt_conteudo" => $comentario->getConteudo()
			]
		)->where("cmt_id", "=", $comentario->getId());

		$this->conexao->conectar();
		$this->executar($sql);
		$this->conexao->desconectar();
	}

	// Deleta um comentário do banco de dados de acordo com a id passada por argumento
	public function deletarComentario($id) {
		$sql = new SqlComando();

		$sql->delete("Comentarios")->where("cmt_id", "=", $id);

		$this->conexao->conectar();
		$this->executar($sql);
		$this->conexao->desconectar();
	}
}

?>