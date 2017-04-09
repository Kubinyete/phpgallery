<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de erro interno (erro no banco de dados)
 */

namespace App\Models;

use App\Models\Model;
use App\Views\ErroView;
use Config\Config;

class ErroModel extends Model {
	// $conexao
	
	public function index($usuarioLogado, $codigo=0) {
		if (isset(Config::obter("Database.Erro.Definicoes")[$codigo])) {
			$mensagem = Config::obter("Database.Erro.Definicoes")[$codigo];
		} else {
			$mensagem = Config::obter("Database.Erro.Definicoes")[Config::obter("Database.Erro.DESCONHECIDO")];
		}

		return new ErroView($usuarioLogado, $mensagem);
	}
}

?>