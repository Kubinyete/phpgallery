<?php
namespace PHPGallery\DatabaseInterface;

require_once "Database.php";

set_include_path("..");

require_once "DatabaseObjeto/Usuario.php";

use PHPGallery\DatabaseObjeto\Usuario;

/**
 * Interface de acesso ao banco de dados que abrange a manipulação de objetos Usuario
 */
class DatabaseALUsuario extends DatabaseAL {
	protected static $procura_maximo_usuarios = 100;

	public function __construct($conexao) {
		parent::__construct($conexao);
	}

	// Insere no banco de dados um novo objeto Usuario
	public function criar_usuario($usuario) {
		$sql = "INSERT INTO Usuarios (usr_nome, usr_senha, usr_data_criacao, usr_online_timestamp) VALUES ('" . $usuario->get_nome() . "', '" . $usuario->get_senha() . "', '" . $usuario->get_data_criacao() . "', " . $usuario->get_online_timestamp() . ");";

		$this->_conexao->conectar();
		$this->executar($sql, true);
		$novo_usuario = $this->obter_usuario($usuario->get_nome());

		$this->_conexao->desconectar();

		return $novo_usuario;
	}

	// Obtem um Usuario do banco de dados conforme sua propriedade nome ou id
	// $restrito -> se esta consulta é para obter um Usuario pelo nome, não permita tentar selecionar
	// o Usuario pelo seu id se a string passada for possível converter para int
	public function obter_usuario($valor, $restrito=false) {
		if (!$restrito) {
			$int_valor = intval($valor);
			$sql = "";
			if ($int_valor > 0) {
				$sql = "SELECT TOP 1 * FROM Usuarios WHERE usr_id=" . $valor . ";";
			} else {
				$sql = "SELECT TOP 1 * FROM Usuarios WHERE usr_nome='" . $valor . "';";
			}
		} else {
			$sql = "SELECT TOP 1 * FROM Usuarios WHERE usr_nome='" . self::filtrar_escape_string_mssql($valor) . "';";
		}

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$usuario = null;

		if (odbc_num_rows($retorno_id) >= 1) {
			$array = odbc_fetch_array($retorno_id);
			$usuario = new Usuario(
				$array["usr_id"],
				$array["usr_nome"],
				$array["usr_senha"],
				false,
				$array["usr_descricao"],
				$array["usr_tem_imagem_perfil"],
				$array["usr_data_criacao"],
				$array["usr_online_timestamp"]
			);
		}

		$this->_conexao->desconectar();

		return $usuario;
	}

	// Obtêm uma contagem de todas os usuários presentes no banco de dados
	public function obter_contagem_usuarios() {
		$sql = "SELECT COUNT(*) as contagem FROM Usuarios;";

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$contagem = 0;

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			$contagem = intval(odbc_fetch_array($retorno_id)["contagem"]);
		}

		$this->_conexao->desconectar();

		return $contagem;
	}

	// Obtem um Usuario do banco de dados conforme sua propriedade nome ou id para uma resposta API
	public function obter_usuario_api($valor) {
		$int_valor = intval($valor);
		$sql = "";
		if ($int_valor > 0) {
			$sql = "SELECT TOP 1 usr_id, usr_nome, usr_descricao, usr_tem_imagem_perfil, usr_data_criacao, usr_online_timestamp FROM Usuarios WHERE usr_id=" . $valor . ";";
		} else {
			$sql = "SELECT TOP 1 usr_id, usr_nome, usr_descricao, usr_tem_imagem_perfil, usr_data_criacao, usr_online_timestamp FROM Usuarios WHERE usr_nome='" . $valor . "';";
		}

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		$usuario = null;

		if (odbc_num_rows($retorno_id) >= 1) {
			$array = odbc_fetch_array($retorno_id);
			$usuario = new Usuario(
				$array["usr_id"],
				$array["usr_nome"],
				"",
				false,
				$array["usr_descricao"],
				$array["usr_tem_imagem_perfil"],
				$array["usr_data_criacao"],
				$array["usr_online_timestamp"],
				true
			);
		}

		$this->_conexao->desconectar();

		return $usuario;
	}

	// Faz uma busca no banco de dados e retorna uma lista de Usuario que tem nome parecido com a string de busca passada
	public function procurar_usuarios($valor) {
		$int_valor = intval($valor);
		$sql = "SELECT TOP " . self::$procura_maximo_usuarios . " * FROM Usuarios WHERE usr_nome LIKE '%" . DatabaseAL::filtrar_escape_string_mssql($valor) . "%'". (($int_valor > 0) ? " OR usr_id=" . $int_valor : "") . " ORDER BY usr_id DESC;";

		$usuarios = [];

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			for ($i = 0; $i < odbc_num_rows($retorno_id); $i++) {
				$array = odbc_fetch_array($retorno_id);
				array_push($usuarios,
					new Usuario(
						$array["usr_id"],
						$array["usr_nome"],
						$array["usr_senha"],
						false,
						$array["usr_descricao"],
						$array["usr_tem_imagem_perfil"],
						$array["usr_data_criacao"],
						$array["usr_online_timestamp"]
					)
				);
			}
		}

		$this->_conexao->desconectar();

		return $usuarios;
	}

	// Faz uma busca no banco de dados e retorna uma lista de Usuario que tem nome parecido com a string de busca passada para uma resposta API
	public function procurar_usuarios_api($valor) {
		$int_valor = intval($valor);
		$sql = "SELECT TOP " . self::$procura_maximo_usuarios . " usr_id, usr_nome, usr_descricao, usr_tem_imagem_perfil, usr_data_criacao, usr_online_timestamp FROM Usuarios WHERE usr_nome LIKE '%" . DatabaseAL::filtrar_escape_string_mssql($valor) . "%'". (($int_valor > 0) ? " OR usr_id=" . $int_valor : "") . " ORDER BY usr_id DESC;";

		$usuarios = [];

		$this->_conexao->conectar();
		$retorno_id = $this->executar($sql);

		if ($retorno_id && odbc_num_rows($retorno_id) >= 1) {
			for ($i = 0; $i < odbc_num_rows($retorno_id); $i++) {
				$array = odbc_fetch_array($retorno_id);
				array_push($usuarios,
					new Usuario(
						$array["usr_id"],
						$array["usr_nome"],
						"",
						false,
						$array["usr_descricao"],
						$array["usr_tem_imagem_perfil"],
						$array["usr_data_criacao"],
						$array["usr_online_timestamp"],
						true
					)
				);
			}
		}

		$this->_conexao->desconectar();

		return $usuarios;
	}

	// Atualiza o estado de um objeto no banco de dados conforme suas mudanças no objeto do sistema
	public function atualizar_usuario($usuario) {
		$db_usuario = $this->obter_usuario($usuario->get_id());

		if (!$db_usuario) {
			return;
		}

		$local_descricao = trim($usuario->get_descricao());

		$sql = "UPDATE Usuarios SET";
		$sql_tam_ini = strlen($sql);

		$sql_end = " WHERE usr_id=" . $usuario->get_id() . ";";

		if ($usuario->get_nome() !== $db_usuario->get_nome()) {
			$sql .= " usr_nome='" . $usuario->get_nome() . "'";
		}

		if ($usuario->get_senha() !== $db_usuario->get_senha()) {
			$sql .= " usr_senha='" . $usuario->get_senha() . "'";
		}

		if ($local_descricao !== $db_usuario->get_descricao()) {
			$sql .= " usr_descricao='" . DatabaseAL::filtrar_escape_string_mssql($local_descricao) . "'";
		}

		if ($usuario->get_tem_imagem_perfil() !== $db_usuario->get_tem_imagem_perfil()) {
			$sql .= " usr_tem_imagem_perfil='" . ($usuario->get_tem_imagem_perfil()) ? "1'" : "0'";
		}

		if ($usuario->get_online_timestamp() !== $db_usuario->get_online_timestamp()) {
			$sql .= " usr_online_timestamp=" . $usuario->get_online_timestamp();
		}

		if ($sql_tam_ini == strlen($sql)) {
			return;
		}

		$this->_conexao->conectar();
		$this->executar($sql . $sql_end, true);
		$novo_usuario = $this->obter_usuario($usuario->get_id());
		$this->_conexao->desconectar();

		return $novo_usuario;
	}

	// Remove um determinado Usuario do banco de dados
	public function remover_usuario($usuario) {
		$sql = "DELETE FROM Usuarios WHERE usr_id=" . $usuario->get_id() . ";";

		$this->_conexao->conectar();
		$this->executar($sql, true);
		$this->_conexao->desconectar();
	}
}

?>
