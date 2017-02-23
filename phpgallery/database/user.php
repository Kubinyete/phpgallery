<?php
	//Classe responsável por representar um usuário
	class Usuario {
		public $id;
		public $nome;
		public $senha;
		public $descricao;
		public $temImagem;
		public $imagemUrl;
		public $dataRegistro;

		//Os argumentos $senha & $descricao serão atribuidos null automaticamente
		//devido a necessidade em alguns casos de consultar apenas o $nome do usuário
		//Exemplo: uma busca no banco de dados para encontrar um usuário específico
		//Pois estou procurando apenas passar objetos como parâmetros em funções de
		//consulta em nossa classe de conexão com o banco de dados
		//$dataRegistro apenas será recebido como parâmetro quando obtido do banco de dados,
		//Para o registro de um novo usuário, utilize o método gerar_data_registro()
		public function __construct($nome, $senha=null, $descricao=null, $temImagem=false, $dataRegistro=null, $id=0) {
			$this->nome = $nome;
			$this->senha = $senha;
			$this->descricao = $descricao;
			$this->id = intval($id);
			($temImagem === "1") ? $this->temImagem = true : $this->temImagem = false;
			$this->dataRegistro = $dataRegistro;
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

		//Gera uma data de criação da conta do usuário
		public function gerar_data_registro() {
			date_default_timezone_set("America/Sao_Paulo");
			$this->dataRegistro = date("d/m/y H:i:s");
		}

		//Ao mostrar para o usuário, apenas queremos a data de registro e não o horário
		public function data_registro() {
			$data = "";

			for ($i = 0; $i < $this->dataRegistro; $i++) {
				if ($i >= 8) {
					break;
				} else {
					$data .= $this->dataRegistro[$i];
				}
			}
			return $data;
		}
	}
?>