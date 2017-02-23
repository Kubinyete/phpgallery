<?php
	//Classe responsável por representar um comentário
	class Comentario {
		public $id;
		public $imagemId;
		public $conteudo;
		public $autor;
		public $dataCriacao;

		public function __construct($imagemId=0, $conteudo=null, $autor=null, $dataCriacao=null, $id=0) {
			$this->id = intval($id);
			$this->imagemId = intval($imagemId);
			$this->conteudo = $conteudo;
			$this->autor = $autor;
			$this->dataCriacao = $dataCriacao;
		}

		//Retorna o conteúdo formatado
		public function conteudo_formatado() {
			$retorno = null;

			if ($this->conteudo !== null) {
					$retorno = trim($this->conteudo);
					$retorno = htmlspecialchars($retorno);
			} else {
				return $this->conteudo;
			}

			return $retorno;
		}

		//API: Substitui nosso conteúdo atual por uma versão "HTML safe"
		public function gerar_conteudo_formatado() {
			$this->conteudo = $this->conteudo_formatado();
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