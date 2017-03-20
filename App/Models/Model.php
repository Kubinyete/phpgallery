<?php
/**
 * Classe que representará um Model em nossa aplicação MVC
 */

namespace App\Models;

abstract class Model {
	// Necessário a conexão pois o Model acessa a nossa Dal e retorna informações importantes para
	// um objeto View, que então irá renderizar a página retornando o HTML para o usuário
	protected $dal;

	public function __construct($dal) {
		$this->dal = $dal;
	}

	// Mostrará a página do modelo atual
	// retorna a View desta página para que então
	// 'renderizá-la'
	public abstract function index();
}

?>