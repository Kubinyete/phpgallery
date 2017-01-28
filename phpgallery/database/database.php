<?php
	require_once "objects.php";

	define("DB_USUARIO", "?");
	define("DB_SENHA", "?");
	define("DB_STRING_CONEXAO", "?");

	//MSSQL: filtrar escape strings
	//acrescenta uma nova ' em todas as ' da string
	//previne a execução de código SQL malicioso
	function filtrar_escape_string_mssql($string) {
		$string = strval($string);
		$retorno = "";

		for ($i = 0; $i < strlen($string); $i++) {
			if ($string[$i] === "'") {
				$retorno .= "'" . $string[$i];
			} else {
				$retorno .= $string[$i];
			}
		}

		return $retorno;
	}

	//Classe responsável por estabelecer uma conexão com o banco de dados e obter objetos
	class Database {
		//Nossa referência de link com o banco de dados
		protected $conexao;

		//Incializa a conexão
		public function __construct() {
			$this->conexao = odbc_connect(DB_STRING_CONEXAO, DB_USUARIO, DB_SENHA);

			if (!$this->conexao) {
				$this->erro("Não foi possível estabelecer uma conexão com o banco de dados.");
			}
		}

		//Finaliza a conexão
		public function finalizar() {
			odbc_close($this->conexao);
		}

		//Envia um erro e finaliza a execução do script
		private function erro($mensagem) {
			header("Status: 503", true, 503);
			exit($mensagem);
		}

		//Executa o comando e retorna o seu objeto referência
		public function executar($comando, $salvar=false) {
			$ok = odbc_exec($this->conexao, $comando);
			if (!$ok) {
				$this->erro("Ocorreu um erro ao realizar uma consulta no banco de dados.");
			} else {
				if ($salvar) {
					odbc_commit($this->conexao);
				}
				return $ok;
			}
 		}

 		//Retorna o número de imagens presentes no banco de dados
 		//$nome !== null: retorna o número de imagens enviadas ao banco de dados de um certo usuário
 		public function obter_numero_imagens($nome=null) {
 			$retorno = 0;

 			$nome = ($nome !== null) ? filtrar_escape_string_mssql($nome) : $nome;

 			if ($nome === null) {
 				$ok = $this->executar("SELECT COUNT(*) AS contagem FROM imagens");
 			} else {
 				$ok = $this->executar("SELECT COUNT(*) AS contagem FROM imagens WHERE img_autor='" . $nome . "'");
 			}

 			$retorno = odbc_fetch_array($ok)["contagem"];

 			return $retorno;
 		}

 		//Obtem um array que contêm todas as imagens recentes
 		public function obter_recentes() {
 			$resultados = [];

 			$ok = $this->executar("SELECT TOP 50 * FROM imagens WHERE img_privado=0 ORDER BY img_id DESC");
 			if (odbc_num_rows($ok) >= 1) {
 				for ($i = 0; $i < odbc_num_rows($ok); $i++) {
 					$imagem = odbc_fetch_array($ok);
 					$novaImagem = new Imagem($imagem["img_titulo"], $imagem["img_descricao"], $imagem["img_privado"], $imagem["img_ext"], $imagem["img_autor"], $imagem["img_id"]);
 					array_push($resultados, $novaImagem);
 				}
 			}

 			return $resultados;
 		}

 		//Obtem um array que contêm todas as imagens de uma busca
 		public function procurar_imagens($procuraString) {
 			$resultados = [];
 			$procuraString = filtrar_escape_string_mssql($procuraString);

 			$ok = $this->executar("SELECT TOP 50 * FROM imagens WHERE img_privado=0 AND (img_titulo LIKE '%" . $procuraString . "%' OR img_descricao LIKE '%" . $procuraString . "%' OR img_autor LIKE '%" . $procuraString . "%') ORDER BY img_id DESC");

 			if (odbc_num_rows($ok) >= 1) {
 				for ($i = 0; $i < odbc_num_rows($ok); $i++) {
 					$imagem = odbc_fetch_array($ok);
 					$novaImagem = new Imagem($imagem["img_titulo"], $imagem["img_descricao"], $imagem["img_privado"], $imagem["img_ext"], $imagem["img_autor"], $imagem["img_id"]);
 					array_push($resultados, $novaImagem);
 				}
 			}

 			return $resultados;
 		}

 		//Obtem um array que contêm todas as imagens de um usuário
 		public function obter_imagens_usuario($nome) {
 			$resultados = [];
 			$nome = filtrar_escape_string_mssql($nome);

 			$ok = $this->executar("SELECT TOP 50 * FROM imagens WHERE img_privado=0 AND img_autor='" . $nome . "'");

 			if (odbc_num_rows($ok) >= 1) {
 				for ($i = 0; $i < odbc_num_rows($ok); $i++) {
 					$imagem = odbc_fetch_array($ok);
 					$novaImagem = new Imagem($imagem["img_titulo"], $imagem["img_descricao"], $imagem["img_privado"], $imagem["img_ext"], $imagem["img_autor"], $imagem["img_id"]);
 					array_push($resultados, $novaImagem);
 				}
 			}

 			return $resultados;
 		}

 		//Obtem a ultima imagem de um determinado usuário
 		private function obter_ultima_imagem_usuario($nome) {
 			$retorno = null;

 			$ok = $this->executar("SELECT TOP 1 * FROM imagens WHERE img_autor='" . $nome . "' ORDER BY img_id DESC");

 			if (odbc_num_rows($ok) >= 1) {
 				for ($i = 0; $i < odbc_num_rows($ok); $i++) {
 					$imagem = odbc_fetch_array($ok);
 					$retorno = new Imagem($imagem["img_titulo"], $imagem["img_descricao"], $imagem["img_privado"], $imagem["img_ext"], $imagem["img_autor"], $imagem["img_id"]);
 				}
 			}

 			return $retorno;
 		}

 		//Obtem um array que contêm todos os usuários de uma busca
 		public function procurar_usuarios($procuraString) {
 			$resultados = [];
 			$procuraString = filtrar_escape_string_mssql($procuraString);

 			$ok = $this->executar("SELECT TOP 50 * FROM usuarios WHERE usr_nome LIKE '%" . $procuraString . "%' ORDER BY usr_nome ASC");

 			if (odbc_num_rows($ok) >= 1) {
 				for ($i = 0; $i < odbc_num_rows($ok); $i++) {
 					$usuario = odbc_fetch_array($ok);
 					array_push($resultados, new Usuario($usuario["usr_nome"], $usuario["usr_senha"], $usuario["usr_descricao"], $usuario["usr_temimagem"], $usuario["usr_id"]));
 				}
 			}

 			return $resultados;
 		}

 		//Obtem um usuáro
 		public function obter_usuario($usuarioNome) {
 			$retornoUsuario = null;
 			$procuraString = filtrar_escape_string_mssql($usuarioNome);

 			$ok = $this->executar("SELECT TOP 1 * FROM usuarios WHERE usr_nome='" . $procuraString . "'");

 			if (odbc_num_rows($ok) >= 1) {
				$dbusuario = odbc_fetch_array($ok);
				$retornoUsuario = new Usuario($dbusuario["usr_nome"], $dbusuario["usr_senha"], $dbusuario["usr_descricao"], $dbusuario["usr_temimagem"], $dbusuario["usr_id"]);
 			}

 			return $retornoUsuario;
 		}

 		//Obtem uma imagem
 		public function obter_imagem($imagemId) {
 			$retornoImagem = null;
 			$procuraString = filtrar_escape_string_mssql($imagemId);

 			$ok = $this->executar("SELECT TOP 1 * FROM imagens WHERE img_id='" . $procuraString . "'");

 			if (odbc_num_rows($ok) >= 1) {
				$dbimagem = odbc_fetch_array($ok);
				$retornoImagem = new Imagem($dbimagem["img_titulo"], $dbimagem["img_descricao"], $dbimagem["img_privado"], $dbimagem["img_ext"], $dbimagem["img_autor"], $dbimagem["img_id"]);
 			}

 			return $retornoImagem;
 		}

 		//Registra um usuário no banco de dados
 		public function registrar_usuario($usuario) {
 			$usuarioNome = filtrar_escape_string_mssql($usuario->nome);
 			$usuarioSenha = filtrar_escape_string_mssql($usuario->senha);

 			$this->executar("INSERT INTO usuarios (usr_nome, usr_senha) VALUES ('" . $usuarioNome . "', '" . $usuarioSenha . "')", true);
 		}

 		//Adiciona uma imagem ao banco de dados
 		public function adicionar_imagem($imagemObjeto) {

 			if ($imagemObjeto->titulo !== null && strlen($imagemObjeto->titulo) > 0) {
 				$imagemTitulo = "'" . filtrar_escape_string_mssql($imagemObjeto->titulo) . "'";
 			} else {
 				$imagemTitulo = "NULL";
 			}

 			if ($imagemObjeto->descricao !== null && strlen($imagemObjeto->descricao) > 0) {
 				$imagemDescricao = "'" . filtrar_escape_string_mssql($imagemObjeto->descricao) . "'";
 			} else {
 				$imagemDescricao = "NULL";
 			}

 			if ($imagemObjeto->privado) {
 				$imagemPrivado = "1";
 			} else {
 				$imagemPrivado = "0";
 			}

 			$this->executar("INSERT INTO imagens (img_titulo, img_descricao, img_privado, img_ext, img_autor) VALUES (" . $imagemTitulo . ", " . $imagemDescricao . ", '" . $imagemPrivado . "', '" . $imagemObjeto->ext . "', '" . $imagemObjeto->autor . "')", true);

 			return $this->obter_ultima_imagem_usuario($imagemObjeto->autor);
 		}
	}
?>
