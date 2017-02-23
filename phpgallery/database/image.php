<?php
	//Classe responsável por representar uma imagem
	class Imagem {
		public $id;
		public $titulo;
		public $descricao;
		public $privado;
		public $ext;
		public $autor;
		public $imagemUrl;
		public $dataCriacao;
		public $imagemUrlMiniatura;

		//$dataCriacao apenas será recebido como parâmetro quando obtido do banco de dados,
		//Para o envio de uma nova imagem, utilize o método gerar_data_criacao()
		public function __construct($titulo, $descricao=null, $privado=false, $ext=null, $autor=null, $dataCriacao=null, $id=0) {
			$this->titulo = $titulo;
			$this->descricao = $descricao;
			$this->privado = ($privado == "1") ? true : false;
			$this->id = intval($id);
			$this->ext = $ext;
			$this->autor = $autor;
			$this->dataCriacao = $dataCriacao;
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

		//API: Gera o caminho da imagem miniatura para ser utilizado na resposta JSON
		public function gerar_imagem_url_miniatura() {
			$this->imagemUrlMiniatura = IMAGENS_PROCESSADOR_MINIATURAS . "?id=" . $this->id;
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

		//Gera uma data de criação utilizando a hora e data atual
		public function gerar_data_criacao() {
			date_default_timezone_set("America/Sao_Paulo");
			$this->dataCriacao = date("d/m/y H:i:s");
		}

		//Retorna uma versão "amigável" da nossa string $dataCricao
		public function data_criacao() {
			$data = "";
			$horario = "";

			for ($i = 0; $i < strlen($this->dataCriacao); $i++) {
				if ($i < 8) {
					$data .= $this->dataCriacao[$i];
				} else if ($i > 8) {
					$horario .= $this->dataCriacao[$i];
				}
			}

			return $data . " às " . $horario;
		}
	}
?>