<?php
/**
 * Classe responsável por representar um comando SQL
 */

namespace App\Database;

class SqlComando {
	private $comandoString;

	public function __construct($comandoString="") {
		$this->comandoString = $comandoString;
	}

	public function getComandoString() {
		return $this->comandoString;
	}

	public function setComandoString($valor) {
		$this->comandoString = $valor;
	}

	// Utilizado para filtrar todas as escape strings de uma string
	public static function filtrarEscapeStringSql($string) {
		return str_replace("'", "\\'", strval($string));
	}

	// Equivalente ao comando SELECT {Atributos}
	// adiciona o comando para nossa comandoString
	public function select($algo="*") {
		if (!strpos(",", $algo)) {
			$this->comandoString .= "SELECT ".$algo." ";
		} else {
			$this->comandoString .= "SELECT (".$algo.") ";
		}

		return $this;
	}

	// Equivalente ao comando FROM {Tabela}
	// adiciona o comando para nossa comandoString
	public function from($algo) {
		$this->comandoString .= "FROM ".$algo." ";

		return $this;
	}

	// Equivalente ao comando WHERE {Atributo} {>, <, =, LIKE, BETWEEN, etc} {Valor}
	// adiciona o comando para nossa comandoString
	public function where($algo, $expressao, $algo2, $filtrarAlgo2=true) {
		$this->comandoString .= "WHERE ".$algo." ".$expressao." ".(($filtrarAlgo2) ? "'".self::filtrarEscapeStringSql($algo2)."'" : $algo2)." ";

		return $this;
	}

	// Adiciona um separador de comandos para nossa query
	public function semicolon() {
		$this->comandoString .= "; ";

		return $this;
	}

	// Equivalente ao comando INSERT INTO {Tabela}({Atributo1, Atributo2, etc}) VALUES ({Valor1, Valor2, etc})
	// adiciona o comando para nossa comandoString
	public function insert($tabela, $arrayAtributosValores, $filtrarValores=true) {
		$atributosString = "";
		$valoresString = "";
		$primeiro = true;

		foreach ($arrayAtributosValores as $atributo => $valor) {
			if ($valor === null) {
				$atualValor = "NULL";
			} else {
				$atualValor = (($filtrarValores) ? "'".self::filtrarEscapeStringSql($valor)."'" : $valor);
			}
			
			if ($primeiro) {
				$atributosString .= $atributo;
				$valoresString .= $atualValor;
				$primeiro = false;
			} else {
				$atributosString .= ", ".$atributo;
				$valoresString .= ", ".$atualValor;
			}
		}

		$this->comandoString .= "INSERT INTO ".$tabela." (".$atributosString.") VALUES (".$valoresString.") ";

		return $this;
	}

	// Equivalente ao comando UPDATE {Tabela} SET {Atributo1=Valor1, Atributo2=Valor2, etc}
	// adiciona o comando para nossa comandoString
	public function update($tabela, $arrayAtributosValores, $filtrarValores=true) {
		$setString = "";
		$primeiro = true;

		foreach ($arrayAtributosValores as $atributo => $valor) {
			if ($valor === null) {
				$localValor = "NULL";
			} else {
				$localValor = (($filtrarValores) ? "'".self::filtrarEscapeStringSql($valor)."'" : $valor);
			}

			if ($primeiro) {
				$setString .= $atributo."=".$localValor;
				$primeiro = false;
			} else {
				$setString .= ", ".$atributo."=".$localValor;
			}
		}

		$this->comandoString .= "UPDATE ".$tabela." SET ".$setString." ";

		return $this;
	}

	// Equivalente ao comando DELETE FROM {Tabela}
	// adiciona o comando para nossa comandoString
	public function delete($tabela) {
		$this->comandoString .= "DELETE FROM ".$tabela." ";

		return $this;
	}

	// Equivalente ao comando ORDER BY {Atributo} {ASC/DESC}
	public function order($atributo, $ordem) {
		$this->comandoString .= "ORDER BY ".$atributo." ".$ordem." ";

		return $this;
	}

	// Equivalente ao comando AS {Apelido}
	public function as($apelido) {
		$this->comandoString .= "AS ".$apelido." ";

		return $this;
	}

	// Equivalente ao comando OR
	public function or() {
		$this->comandoString .= "OR ";

		return $this;
	}

	// Equivalente ao comando AND
	public function and() {
		$this->comandoString .= "AND ";

		return $this;
	}

	// Equivalente a uma expressão utilizada por um comando
	// Ex: nome='valor'
	public function expressao($valor, $operador, $valor2, $filtrarValor2=true) {
		$this->comandoString .= $valor." ".$operador." ".(($filtrarValor2) ? "'".self::filtrarEscapeStringSql($valor2)."'" : $valor2)." ";

		return $this;
	}

	public function limit($numero) {
		$this->comandoString .= 'LIMIT '.$numero.' ';

		return $this;
	}
}

?>