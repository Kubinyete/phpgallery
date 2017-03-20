<?php
/**
 * Classe base que representará um Controlador do modelo MVC
 */

namespace App\Controllers;

abstract class Controller {
	protected $model;
	protected $parametros;

	// Recebe um array com parâmetros da querystring
	public function __construct($model, $parametros=[]) {
		$this->model = $model;
		$this->parametros = $parametros;
	}

	// De acordo com nossos parâmetros, chame um Model e atualize as informações necessárias
	// e por fim envie a página completa
	public abstract function rodar();
}

?>