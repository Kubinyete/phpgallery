<?php
namespace PHPGallery\DatabaseInterface;

require_once "Database.php";

set_include_path("..");

require_once "DatabaseObjeto/Imagem.php";

use PHPGallery\DatabaseObjeto\Imagem;

/**
 * Interface de acesso ao banco de dados responsável por abranger métodos de manipulação de objetos Imagem
 */
class DatabaseALImagem extends DatabaseAL {
	protected static $procura_maximo_imagens = 100;
	protected static $recentes_maximo_imagens = 15;

	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Insere no banco de dados um objeto Imagem
	public function criar_imagem($imagem) {
		$local_titulo = trim($imagem->get_titulo());
		$local_descricao = trim($imagem->get_descricao());

		$sql = "INSERT INTO Imagens (usr_id, img_titulo, img_descricao, img_data_criacao, img_extensao) VALUES (" . $imagem->get_usr_id() . ", " . ( (strlen($local_titulo) < 1) ? "NULL" : "'" . DatabaseAL::filtrar_escape_string_mssql($local_titulo) . "'") . ", " . ( (strlen($local_descricao) < 1) ? "NULL" : "'" . DatabaseAL::filtrar_escape_string_mssql($local_descricao) . "'") . ", '" . $imagem->get_data_criacao_inserir() . "', '" . $imagem->get_extensao() . "'); SELECT @@IDENTITY AS identidade;";

		$this->_conexao->conectar();
		$resultado_id = $this->executar($sql, true);

		$nova_imagem = null;

		if ($resultado_id && odbc_num_rows($resultado_id) >= 1) {
			$nova_imagem_id = intval(odbc_fetch_array($resultado_id)["identidade"]);
			$nova_imagem = $this->obter_imagem($nova_imagem_id);
		}

		$this->_conexao->desconectar();

		return $nova_imagem;
	}

	// Obtem um objeto Imagem a partir de seu $id
	public function obter_imagem($id) {
		$int_id = intval($id);

		if ($int_id <= 0) {
			return;
		}

		$sql = "SELECT TOP 1 * FROM Imagens WHERE img_id=" . $id . ";";

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$imagem = null;

		if (odbc_num_rows($retorno_id) >= 1) {
			$array = odbc_fetch_array($retorno_id);
			$imagem = new Imagem(
				$array["img_id"],
				$array["usr_id"],
				$array["img_titulo"],
				$array["img_descricao"],
				$array["img_data_criacao"],
				$array["img_extensao"]
			);
		}

		$this->_conexao->desconectar();

		return $imagem;
	}

	// Procura uma lista de Imagem com base na string de busca passada
	public function procurar_imagens($valor) {
		$int_valor = intval($valor);

		$sql = "SELECT TOP " . self::$procura_maximo_imagens . " * FROM Imagens WHERE img_titulo LIKE '%" . DatabaseAL::filtrar_escape_string_mssql($valor) . "%' OR img_descricao LIKE '%" . DatabaseAL::filtrar_escape_string_mssql($valor) . "%'" . (($int_valor > 0) ? " OR img_id=" . $int_valor : "") . " ORDER BY img_id DESC;";

		$imagens = [];

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			for ($i = 0; $i < odbc_num_rows($retorno_id); $i++) {
				$array = odbc_fetch_array($retorno_id);
				array_push($imagens,
					new Imagem(
						$array["img_id"],
						$array["usr_id"],
						$array["img_titulo"],
						$array["img_descricao"],
						$array["img_data_criacao"],
						$array["img_extensao"]
					)
				);
			}
		}

		$this->_conexao->desconectar();

		return $imagens;
	}

	// Obtêm uma contagem de todas as imagens presentes no banco de dados
	public function obter_contagem_imagens() {
		$sql = "SELECT COUNT(*) as contagem FROM Imagens;";

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$contagem = 0;

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			$contagem = intval(odbc_fetch_array($retorno_id)["contagem"]);
		}

		$this->_conexao->desconectar();

		return $contagem;
	}

	// Obtêm uma lista de imagens recentes adicionadas ao banco de dados
	public function obter_recentes() {
		$sql = "SELECT TOP " . self::$recentes_maximo_imagens . " * FROM Imagens ORDER BY img_id DESC;";

		$imagens = [];

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			for ($i = 0; $i < odbc_num_rows($retorno_id); $i++) {
				$array = odbc_fetch_array($retorno_id);
				array_push($imagens,
					new Imagem(
						$array["img_id"],
						$array["usr_id"],
						$array["img_titulo"],
						$array["img_descricao"],
						$array["img_data_criacao"],
						$array["img_extensao"]
					)
				);
			}
		}

		$this->_conexao->desconectar();

		return $imagens;
	}

	// Atualiza uma imagem no banco de dados conforme suas mudanças no objeto Imagem
	public function atualizar_imagem($imagem) {
		$db_imagem = $this->obter_imagem($imagem->get_id());

		if (!$db_imagem) {
			return;
		}

		$local_titulo = trim($imagem->get_titulo());
		$local_descricao = trim($imagem->get_descricao());

		$sql = "UPDATE Imagens SET";
		$sql_tam_ini = strlen($sql);

		$sql_end = " WHERE img_id=" . $imagem->get_id() . ";";

		if ($local_titulo !== $db_imagem->get_titulo()) {
			$sql .= " img_titulo=" . ( (strlen($local_titulo) < 1) ? "NULL" : "'" . DatabaseAL::filtrar_escape_string_mssql($local_titulo) . "'");
		}

		if ($local_descricao !== $db_imagem->get_descricao()) {
			$sql .= " img_descricao=" . ( (strlen($local_descricao) < 1) ? "NULL" : "'" . DatabaseAL::filtrar_escape_string_mssql($local_descricao) . "'");
		}

		if ($sql_tam_ini == strlen($sql)) {
			return;
		}

		$this->_conexao->conectar();
		$this->executar($sql . $sql_end, true);
		$nova_imagem = $this->obter_imagem($imagem->get_id());
		$this->_conexao->desconectar();

		return $nova_imagem;
	}

	// Remove uma imagem do banco de dados informando seu objeto Imagem
	public function remover_imagem($imagem) {
		$sql = "DELETE FROM Imagens WHERE img_id=" . $imagem->get_id() . ";";

		$this->_conexao->conectar();
		$this->executar($sql, true);
		$this->_conexao->desconectar();
	}
}

?>
