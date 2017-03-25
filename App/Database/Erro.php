<?php
/**
 * Arquivo responsável por definir as constantes de erro e
 * conter a classe de definições dos erros utilizados pela Conexao
 * e SqlComando
 */

namespace App\Database;

abstract class Erro {
	const DBERRO_DESCONHECIDO = 0;
	const DBERRO_FALHA_CONEXAO = 1;
	const DBERRO_FALHA_COMANDO = 2;
	const DBERRO_FALHA_SALVAR = 3;

	// O pedido que será feito para mostrar uma página de erro para o usuário
	// '%' é o código de erro a ser visualizado
	const SCRIPT_ERRO = "/?v=erro&c=%";

	// As definições de cada erro utilizado pelas constantes acima
	const DEFINICOES = [
		self::DBERRO_DESCONHECIDO => "Ocorreu um erro desconhecido ao tentar consultar o banco de dados.",
		self::DBERRO_FALHA_CONEXAO => "Não foi possível estabelecer uma conexão com o banco de dados.",
		self::DBERRO_FALHA_COMANDO => "Ocorreu um erro ao tentar interagir com o banco de dados.",
		self::DBERRO_FALHA_SALVAR => "Não foi possível armazenar as modificações feitas até o momento no banco de dados."
	];
}

?>