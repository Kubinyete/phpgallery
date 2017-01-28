<?php
	define("RESPOSTA_SEM_DESCRICAO", "Nenhuma descrição está disponível.");
	define("RESPOSTA_SEM_TITULO", "Nenhum título está disponível.");
	define("IMAGENS_USUARIO_ORIGEM", "/resources/profile/");
	define("IMAGENS_USUARIO_EXT", ".jpg");
	define("IMAGENS_ORIGEM", "/resources/image/");
	define("IMAGENS_USUARIO_PADRAO", "/resources/profile/user-default.jpg");

	//Classe responsável por representar um usuário
	class Usuario {
		public $id;
		public $nome;
		public $senha;
		public $descricao;
		public $temImagem;
		public $imagemUrl;

		//Os argumentos $senha & $descricao serão atribuidos null automaticamente
		//devido a necessidade em alguns casos de consultar apenas o $nome do usuário
		//Exemplo: uma busca no banco de dados para encontrar um usuário específico
		//Pois estou procurando apenas passar objetos como parâmetros em funções de
		//consulta em nossa classe de conexão com o banco de dados
		public function __construct($nome, $senha=null, $descricao=null, $temImagem=false, $id=0) {
			$this->nome = $nome;
			$this->senha = $senha;
			$this->descricao = $descricao;
			if ($this->descricao !== null) {
				$this->descricao = utf8_encode($this->descricao);
			}
			$this->id = $id;
			($temImagem === "1") ? $this->temImagem = true : $this->temImagem = false;
		}

		//É utilizado indiretamente como o ID da imagem de perfil do usuário
		//resources/profile/nome_md5_hash.jpg
		public function nome_md5_hash() {
			return md5($this->nome);
		}

		//É a representação md5 da senha do usuário, apenas utilizado ao criar um novo usuário
		//no banco dados
		public function senha_md5_hash() {
			return md5($this->senha);
		}

		//API: Gera o url que contêm a imagem do usuário
		public function gerar_imagem_url() {
			$this->imagemUrl = $this->imagem_url();
		}

		//Retorna a descrição do usuário formatada corretamente para seu armazenamento no banco
		//de dados
		//Este método pode ser utilizado tanto para armazenar no banco de dados quanto para
		//mostrar em uma página
		public function descricao_formatada($validarString, $retornarTemplateSemDescricao) {
			$retorno = null;
			if ($this->descricao !== null) {
				if ($validarString) {
					$retorno = trim($this->descricao);
					$retorno = htmlspecialchars($retorno);
				} else {
					return $this->descricao;
				}
			} else if ($retornarTemplateSemDescricao) {
				return RESPOSTA_SEM_DESCRICAO;
			}

			return $retorno;
		}

		//API: Substitui nossa descrição atual por uma versão "HTML safe"
		public function gerar_descricao_formatada() {
			$this->descricao = $this->descricao_formatada(true, true);
		}

		//Retorna o caminho inteiro da imagem do usuário
		public function imagem_url() {
			if ($this->temImagem) {
				return IMAGENS_USUARIO_ORIGEM . $this->nome_md5_hash() . IMAGENS_USUARIO_EXT;
			} else {
				return IMAGENS_USUARIO_PADRAO;
			}
		}
	}

	//Classe responsável por representar uma imagem
	class Imagem {
		public $id;
		public $titulo;
		public $descricao;
		public $privado;
		public $ext;
		public $autor;
		public $imagemUrl;

		public function __construct($titulo, $descricao=null, $privado=false, $ext=null, $autor=null, $id=0) {
			$this->titulo = $titulo;
			if ($this->titulo !== null) {
				$this->titulo = utf8_encode($this->titulo);
			}
			$this->descricao = $descricao;
			if ($this->descricao !== null) {
				$this->descricao = utf8_encode($this->descricao);
			}
			$this->privado = ($privado == "1") ? true : false;
			$this->id = intval($id);
			$this->ext = $ext;
			$this->autor = $autor;
		}

		//Retorna a hash md5 do id da imagem, é utilizado para armazenar a imagem com o nome md5
		//Exemplo: resources/image/id_md5_hash.png
		public function id_md5_hash() {
			return md5($this->id);
		}

		//API: Gera o caminho da imagem para ser utilizado na resposta JSON
		public function gerar_imagem_url() {
			$this->imagemUrl = $this->imagem_url();
		}

		//Retorna a descrição da imagem formatada corretamente para seu armazenamento no banco
		//de dados
		//Este método pode ser utilizado tanto para armazenar no banco de dados quanto para
		//mostrar em uma página
		public function descricao_formatada($validarString, $retornarTemplateSemDescricao) {
			$retorno = null;
			if ($this->descricao !== null) {
				if ($validarString) {
					$retorno = trim($this->descricao);
					$retorno = htmlspecialchars($retorno);
				} else {
					return $this->descricao;
				}
			} else if ($retornarTemplateSemDescricao) {
				return RESPOSTA_SEM_DESCRICAO;
			}

			return $retorno;
		}

		//API: Substitui nossa descrição atual por uma versão "HTML safe"
		public function gerar_descricao_formatada() {
			$this->descricao = $this->descricao_formatada(true, true);
		}

		//Retorna o titulo formatado
		public function titulo_formatado($validarString, $retornarTemplateSemDescricao) {
			$retorno = null;
			if ($this->titulo !== null) {
				if ($validarString) {
					$retorno = trim($this->titulo);
					$retorno = htmlspecialchars($retorno);
				} else {
					return $this->titulo;
				}
			} else if ($retornarTemplateSemDescricao) {
				return RESPOSTA_SEM_TITULO;
			}

			return $retorno;
		}

		//API: Substitui nosso título atual por uma versão "HTML safe"
		public function gerar_titulo_formatado() {
			$this->titulo = $this->titulo_formatado(true, true);
		}

		//Retorna o caminho inteiro da imagem
		public function imagem_url() {
			return IMAGENS_ORIGEM . $this->id_md5_hash() . $this->ext;
		}
	}
?>