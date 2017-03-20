<?php
/**
 * Atributos utilizados pela classe DalComentario para conter configurações e limites
 * pré-estabelecidos
 */

namespace Config;

class DalComentarioConfig {
	// O máximo de objetos que uma procura de comentários pode retornar,
	// se o valor informado for 0 ou menor, a procura retornará todos
	const LISTAR_COMENTARIOS_LIMITE = 50;
}

?>