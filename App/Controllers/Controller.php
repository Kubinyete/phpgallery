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

	public function getModel() {
		return $this->model;
	}

	// Todo Controller derivado terá sua própria implementação da função rodar()
	public abstract function rodar($usuarioLogado);
}

?>