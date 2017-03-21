<?php
/**
 * Classe base que representará um Controlador do modelo MVC
 */

namespace App\Controllers;

abstract class Controller {
	protected $model;

	// Recebe um model
	public function __construct($model) {
		$this->model = $model;
	}

	// De acordo com nossos parâmetros, chame um Model e atualize as informações necessárias
	// e por fim envie a página completa
	#public abstract function rodar();
}

?>