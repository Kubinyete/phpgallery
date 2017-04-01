<?php
/**
 * Controlador responsável por processar o envio de uma imagem ou a requisição de uma página de envio
 */

namespace App\Controllers;

use App\Controllers\Controller;

class EnviarController extends Controller {
	// $model
	
	public function rodar($usuarioLogado, $acao="i", $imagem=[], $imagemTitulo="", $imagemDescricao="", $imagemPrivada="0") {
		if ($acao === "r") {
			return $this->model->enviar($usuarioLogado, $imagem, $imagemTitulo, $imagemDescricao, ($imagemPrivada === "1") ? true : false);
		} else {
			return $this->model->index($usuarioLogado);
		}
	}
}

?>