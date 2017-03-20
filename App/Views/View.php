<?php
/**
 * Classe reponsável por representar uma visualização do MVC
 */

namespace App\Views;

use Config\ViewConfig;

abstract class View {
	// Objetos necessários
	protected $objetos;
	// Templates utilizadas
	const TEMPLATES = [];

	// Recebe um array de vários objetos necessários para renderizar a tela
	public function __construct($objetos) {
		$this->objetos = $objetos;
	}

	// Cada View tratará o renderizar de alguma forma
	// dependendo dos TEMPLATES & objetos guardados
	public abstract function renderizar();
}

?>