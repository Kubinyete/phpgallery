<?php
namespace PHPGallery\DatabaseInterface;

require_once "Database.php";

set_include_path("..");

require_once "DatabaseObjeto/Comentario.php";

use PHPGallery\DatabaseObjeto\Comentario;

/**
 * Interface de acesso ao banco de dados com foco em objetos Comentario
 */
class DatabaseALComentario extends DatabaseAL {
	protected static $listar_maximo_comentarios = 100;

	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	public function criar_comentario($comentario) {
		$local_conteudo = trim($comentario->get_conteudo());

		$sql = "INSERT INTO Comentarios (img_id, usr_id, cmt_conteudo, cmt_data_criacao) VALUES (" . $comentario->get_img_id() . ", " . $comentario->get_usr_id() . ", '" . $local_conteudo . "', '" . $comentario->get_data_criacao() . "'); SELECT @@IDENTITY AS identidade;";

		$this->_conexao->conectar();
		$resultado_id = $this->executar($sql, true);

		$novo_comentario = null;

		if ($resultado_id && odbc_num_rows($resultado_id) >= 1) {
			$novo_comentario_id = intval(odbc_fetch_array($resultado_id)["identidade"]);
			$novo_comentario = $this->obter_comentario($novo_comentario_id);
		}

		$this->_conexao->desconectar();

		return $novo_comentario;
	}

	// Retorna um objeto Comentario a partir de um determinado $id
	public function obter_comentario($id) {
		$int_id = intval($id);

		if ($int_id <= 0) {
			return;
		}

		$sql = "SELECT TOP 1 * FROM Comentarios WHERE cmt_id=" . $id . ";";

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$comentario = null;

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			$array = odbc_fetch_array($retorno_id);
			$comentario = new Comentario(
				$array["cmt_id"],
				$array["img_id"],
				$array["usr_id"],
				$array["cmt_conteudo"],
				$array["cmt_data_criacao"]
			);
		}

		$this->_conexao->desconectar();

		return $comentario;
	}

	// Obtêm uma contagem de todas os comentários presentes no banco de dados
	public function obter_contagem_comentarios() {
		$sql = "SELECT COUNT(*) as contagem FROM Comentarios;";

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$contagem = 0;

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			$contagem = intval(odbc_fetch_array($retorno_id)["contagem"]);
		}

		$this->_conexao->desconectar();

		return $contagem;
	}

	// Retorna uma lista contendo todos (ou parte, dentro dos limites) os comentários de um objeto Imagem
	public function obter_comentarios($imagem) {
		$sql = "SELECT TOP " . self::$listar_maximo_comentarios . " * FROM Comentarios WHERE img_id=" . $imagem->get_id() . " ORDER BY cmt_id DESC;";

		$comentarios = [];

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			for ($i = 0; $i < odbc_num_rows($retorno_id); $i++) {
				$array = odbc_fetch_array($retorno_id);
				array_push($comentarios, 
					new Comentario(
						$array["cmt_id"],
						$array["img_id"],
						$array["usr_id"],
						$array["cmt_conteudo"],
						$array["cmt_data_criacao"]
					)
				);
			}
		}

		$this->_conexao->desconectar();

		return $comentarios;
	}

	// Atualiza o estado de um objeto Comentario no banco de dados a partir de um objeto no sistema
	public function atualizar_comentario($comentario) {
		$this->_conexao->conectar();
		$db_comentario = $this->obter_comentario($comentario->get_id());

		if (!$db_comentario) {
			return $this->_conexao->desconectar();
		}

		$local_conteudo = trim($comentario->get_conteudo());

		$sql = "UPDATE Comentarios SET";
		$sql_tam_ini = strlen($sql);

		$sql_end = " WHERE cmt_id=" . $comentario->get_id() . ";";

		if ($local_conteudo !== $db_comentario->get_conteudo()) {
			$sql .= " cmt_conteudo='" . DatabaseAL::filtrar_escape_string_mssql($local_conteudo) . "'";
		}

		if ($sql_tam_ini == strlen($sql)) {
			return $this->_conexao->desconectar();
		}

		$this->executar($sql . $sql_end, true);
		$novo_comentario = $this->obter_comentario($comentario->get_id());
		$this->_conexao->desconectar();

		return $novo_comentario;
	}

	// Remove um objeto Comentario do banco de dados a partir de um objeto em nosso sistema
	public function remover_comentario($comentario) {
		$sql = "DELETE FROM Comentarios WHERE cmt_id=" . $comentario->get_id() . ";";

		$this->_conexao->conectar();
		$this->executar($sql, true);
		$this->_conexao->desconectar();
	}
}

?>