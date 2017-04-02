<?php
/**
 * Classe responsável por representar uma Database Access Layer de objetos do tipo Imagem
 */

namespace App\Database;

use App\Database\Dal;
use App\Objects\Imagem;
use App\Database\SqlComando;
use Config\DalImagemConfig;

class DalImagem extends Dal {
	// Cria uma imagem no banco de dados de acordo com o objeto Imagem passado como argumento
	public function criarImagem($imagem) {
		$sql = new SqlComando();
		
		$sql->insert("Imagens", 
			[
				"usr_id" => $imagem->getUsuarioId(),
				"img_titulo" => $imagem->getTitulo(),
				"img_descricao" => $imagem->getDescricao(),
				"img_data_criacao" => $imagem->getDataCriacao(2),
				"img_extensao" => $imagem->getExtensao(),
				"img_privada" => ($imagem->getPrivada()) ? "1" : "0"
			]
		);

		$this->conexao->conectar();
		$this->executar($sql, true);

		$sql = new SqlComando();
		$sql->select("TOP 1 img_id")->as("id")->from("Imagens")->order("img_id", "DESC");

		$resultadoId = $this->executar($sql);

		$id = null;

		if ($resultadoId != false && odbc_num_rows($resultadoId) >= 1) {
			$id = intval(odbc_fetch_array($resultadoId)["id"]);
		}

		$this->conexao->desconectar();

		return $id;
	}

	// Obtem um objeto Imagem de acordo com o id passado
	public function obterImagem($id, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select("TOP 1 *")->from("Imagens")->where("img_id", "=", $id);

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagem = null;

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			$array = odbc_fetch_array($resultado);

			$imagem = new Imagem(
				$array["img_id"],
				$array["img_data_criacao"],
				$array["usr_id"],
				$array["img_titulo"],
				$array["img_descricao"],
				$array["img_extensao"],
				$array["img_privada"],
				$paraApi
			);
		}

		$this->conexao->desconectar();

		return $imagem;
	}

	// Obtem uma lista de objetos Imagem de acordo com a string de busca passada
	public function listarImagens($procura, $paraApi=false) {
		$sql = new SqlComando();

		if (DalImagemConfig::LISTAR_IMAGENS_LIMITE > 0) {
			$sql->select("TOP ".DalImagemConfig::LISTAR_IMAGENS_LIMITE." *");
		} else {
			$sql->select();
		}

		$sql->from("Imagens")->where("img_titulo", "LIKE", "%".$procura."%")->or()->expressao("img_descricao", "LIKE", "%".$procura."%")->or()->expressao("img_id", "LIKE", "%".$procura."%")->or()->expressao("img_data_criacao", "LIKE", "%".$procura."%");

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			for ($i = 0; $i < odbc_num_rows($resultado); $i++) {
				$array = odbc_fetch_array($resultado);

				$imagem = new Imagem(
					$array["img_id"],
					$array["img_data_criacao"],
					$array["usr_id"],
					$array["img_titulo"],
					$array["img_descricao"],
					$array["img_extensao"],
					$array["img_privada"],
					$paraApi
				);

				array_push($imagens, $imagem);
			}
		}

		$this->conexao->desconectar();

		return $imagens;
	}

	// Obtem uma lista de objetos Imagem de um autor
	public function listarImagensUsuario($usuarioId, $paraApi=false) {
		$sql = new SqlComando();

		if (DalImagemConfig::LISTAR_IMAGENS_LIMITE > 0) {
			$sql->select("TOP ".DalImagemConfig::LISTAR_IMAGENS_LIMITE." *");
		} else {
			$sql->select();
		}

		$sql->from("Imagens")->where("usr_id", "=", $usuarioId)->and()->expressao("img_privada", "=", "0")->order("img_id", "DESC");

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			for ($i = 0; $i < odbc_num_rows($resultado); $i++) {
				$array = odbc_fetch_array($resultado);

				$imagem = new Imagem(
					$array["img_id"],
					$array["img_data_criacao"],
					$array["usr_id"],
					$array["img_titulo"],
					$array["img_descricao"],
					$array["img_extensao"],
					$array["img_privada"],
					$paraApi
				);

				array_push($imagens, $imagem);
			}
		}

		$this->conexao->desconectar();

		return $imagens;
	}

	// Obtem uma lista de objetos Imagem recentes
	public function listarRecentes($paraApi=false) {
		$sql = new SqlComando();

		if (DalImagemConfig::LISTAR_RECENTES_LIMITE > 0) {
			$sql->select("TOP ".DalImagemConfig::LISTAR_RECENTES_LIMITE." *");
		} else {
			$sql->select();
		}
		
		$sql->from("Imagens")->where("img_privada", "=", "0")->order("img_id", "DESC");

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$imagens = [];

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			for($i = 0; $i < odbc_num_rows($resultado); $i++) {
				$array = odbc_fetch_array($resultado);

				$imagem = new Imagem(
					$array["img_id"],
					$array["img_data_criacao"],
					$array["usr_id"],
					$array["img_titulo"],
					$array["img_descricao"],
					$array["img_extensao"],
					$array["img_privada"],
					$paraApi
				);

				array_push($imagens, $imagem);
			}
		}

		return $imagens;
	}

	// Obtem a contagem de todas as imagens no banco de dados
	public function contagemImagens() {
		$sql = new SqlComando();
		$sql->select("COUNT(*)")->as("contagem")->from("Imagens");

		$resultado = $this->executar($sql);

		$contagem = 0;

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			$contagem = intval(odbc_fetch_array($resultado)["contagem"]);
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
				"img_privada" => ($imagem->getPrivada) ? "1" : "0"
			]
		)->where("img_id", "=", $imagem->getId());

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}

	// Deleta uma imagem do banco de dados de acordo com a id passada por argumento
	public function deletarImagem($id) {
		$sql = new SqlComando();

		$sql->delete("Imagens")->where("img_id", "=", $id);

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}
}

?>