<?php
/**
 * Classe responsável por representar uma Database Access Layer de objetos do tipo Usuario
 */

namespace App\Database;

use App\Database\Dal;
use App\Objects\Usuario;
use App\Database\SqlComando;
use Config\DalUsuarioConfig;

class DalUsuario extends Dal {
	// Cria um usuário no banco de dados de acordo com o objeto Usuario passado como argumento
	public function criarUsuario($usuario) {
		$sql = new SqlComando();
		
		$sql->insert("Usuarios", 
			[
				"usr_nome" => $usuario->getNome(),
				"usr_senha" => $usuario->getSenha(),
				"usr_descricao" => $usuario->getDescricao(),
				"usr_tem_imagem_perfil" => ($usuario->getTemImagemPerfil()) ? "1" : "0",
				"usr_data_criacao" => $usuario->getDataCriacao(2),
				"usr_online_timestamp" => $usuario->getOnlineTimestamp()
			]
		);

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}

	// Obtem um objeto Usuario de acordo com o id passado
	// paraApi: retorna um objeto Usuario pronto para ser utilizado pela api
	public function obterUsuario($utilizarId, $valor, $paraApi=false) {
		$sql = new SqlComando();

		$sql->select("TOP 1 *")->from("Usuarios");

		if ($utilizarId) {
			$sql->where("usr_id", "=", $valor);
		} else {
			$sql->where("usr_nome", "=", $valor);
		}

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$usuario = null;

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			$array = odbc_fetch_array($resultado);

			$usuario = new Usuario(
				$array["usr_id"],
				$array["usr_data_criacao"],
				$array["usr_nome"],
				$array["usr_senha"],
				false,
				$array["usr_descricao"],
				$array["usr_tem_imagem_perfil"],
				$array["usr_online_timestamp"],
				$paraApi
			);
		}

		$this->conexao->desconectar();

		return $usuario;
	}

	// Obtem uma lista de objetos Usuario de acordo com a string de busca passada
	// paraApi: utiliza objetos Usuario pronto para ser utilizado pela api
	public function listarUsuarios($procura, $paraApi=false) {
		$sql = new SqlComando();

		if (DalUsuarioConfig::LISTAR_USUARIOS_LIMITE > 0) {
			$sql->select("TOP ".DalUsuarioConfig::LISTAR_USUARIOS_LIMITE." *");
		} else {
			$sql->select();
		}

		$sql->from("Usuarios")->where("usr_nome", "LIKE", "%".$procura."%")->order("usr_id", "DESC");

		$this->conexao->conectar();
		$resultado = $this->executar($sql);

		$usuarios = [];

		if ($resultado != false && odbc_num_rows($resultado) >= 1) {
			for ($i = 0; $i < odbc_num_rows($resultado); $i++) {
				$array = odbc_fetch_array($resultado);

				$usuario = new Usuario(
					$array["usr_id"],
					$array["usr_data_criacao"],
					$array["usr_nome"],
					$array["usr_senha"],
					false,
					$array["usr_descricao"],
					$array["usr_tem_imagem_perfil"],
					$array["usr_online_timestamp"],
					$paraApi
				);

				array_push($usuarios, $usuario);
			}
		}

		$this->conexao->desconectar();

		return $usuarios;
	}

	// Atualiza o estado de um objeto no banco de dados de acordo com sua representação passada pelo argumento
	public function atualizarUsuario($usuario) {
		$sql = new SqlComando();

		$sql->update("Usuarios", 
			[
				"usr_descricao" => $usuario->getDescricao(),
				"usr_tem_imagem_perfil" => ($usuario->getTemImagemPerfil()) ? "1" : "0",
				"usr_online_timestamp" => $usuario->getOnlineTimestamp()
			]
		)->where("usr_id", "=", $usuario->getId());

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}

	// Deleta um usuário do banco de dados de acordo com a string do nome passado por argumento
	public function deletarUsuario($nome) {
		$sql = new SqlComando();

		$sql->delete("Usuarios")->where("usr_nome", "=", $nome);

		$this->conexao->conectar();
		$this->executar($sql, true);
		$this->conexao->desconectar();
	}
}

?>