<?php
/**
 * Classe reponsável por representar uma visualização do MVC
 */

namespace App\Views;

abstract class View {
	// Cada View tratará o renderizar de alguma forma
	// dependendo dos templates & guardados
	public abstract function renderizar();
}

?>