<?php
/**
 * Representa o nosso modelo de acesso para exibição de uma página de erro interno (erro no banco de dados)
 */

namespace App\Models;

use App\Models\Model;
use App\Views\ErroView;
use App\Database\Erro;

class ErroModel extends Model {
	public function index($usuarioLogado, $codigo) {
		if (isset(Erro::DEFINICOES[$codigo])) {
			$mensagem = Erro::DEFINICOES[$codigo];
		} else {
			$mensagem = Erro::DEFINICOES[Erro::DBERRO_DESCONHECIDO];
		}

		return new ErroView($usuarioLogado, $mensagem);
	}
}

?>