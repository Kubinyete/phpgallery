<?php
/**
 * Classe responsável por representar uma Database Access Layer de objetos do tipo Comentario
 */

namespace App\Database;

use App\Database\Dal;
use App\Objects\Comentario;
use App\Database\SqlComando;
use Config\DalComentarioConfig;

class DalComentario extends Dal {
	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Cria um comentário no banco de dados de acordo com o objeto Comentario passado como argumento
	public function criarComentario($comentario) {
		$sql = new SqlComando();
		
		$sql->insert("Comentarios", 
			[
				"img_id" => $comentario->getImagemId(),
				"usr_id" => $comentario->getUsuarioId(),
				"cmt_conteudo" => $comentario->getConteudo(),
				"cmt_data_criacao" => $comentario->getDataCriacao(2),
			]
		)->semicolon()->select("@@IDENTITY")->as("id");

		$this->conexao->conectar();
		$resultadoId = $this->executar($sql, true);

		$id = null;

		if ($resultadoId != false && odbc_num_rows($resultadoId) >= 1) {
			$id = itnval(odbc_fetch_array($resultadoId)["id"]);
		}

		$this->conexao->desconectar();

		return $id;
	}

	// Obtem um objeto Comentario de acordo com o id passado
	public function obterComentario($id, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select("TOP 1 *")->from("Comentarios")->where("cmt_id", "=", $id);

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$comentario = null;

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			$array = odbc_fetch_array($resultado);

			$comentario = new Comentario(
				$array["cmt_id"],
				$array["cmt_data_criacao"],
				$array["img_id"],
				$array["usr_id"],
				$array["cmt_conteudo"],
				$paraApi
			);
		}

		$this->conexao->desconectar();

		return $comentario;
	}

	// Obtem uma lista de objetos Comentario de acordo com o id da imagem passada
	public function listarComentarios($imgId, $paraApi=false) {
		$sql = new SqlComando();

		if (DalComentarioConfig::LISTAR_COMENTARIOS_LIMITE > 0) {
			$sql->select("TOP ".DalComentarioConfig::LISTAR_COMENTARIOS_LIMITE." *");
		} else {
			$sql->select();
		}

		$sql->from("Comentarios")->where("img_id", "=", $imgId);

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$comentarios = [];

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			for ($i = 0; $i < odbc_num_rows($resultado); $i++) {
				$array = odbc_fetch_array($resultado);

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
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}

	// Deleta um comentário do banco de dados de acordo com a id passada por argumento
	public function deletarComentario($id) {
		$sql = new SqlComando();

		$sql->delete("Comentarios")->where("cmt_id", "=", $id);

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}
}

?>