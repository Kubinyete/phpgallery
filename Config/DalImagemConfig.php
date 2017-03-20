<?php
/**
 * Atributos utilizados pela classe DalImagem para conter configurações e limites
 * pré-estabelecidos
 */

namespace Config;

class DalImagemConfig {
	// O máximo de objetos que uma procura de imagens pode retornar,
	// se o valor informado for 0 ou menor, a procura retornará todos
	const LISTAR_IMAGENS_LIMITE = 100;
	// O máximo de objetos que uma listagem de recentes retornará
	const LISTAR_RECENTES_LIMITE = 40;
}

?>