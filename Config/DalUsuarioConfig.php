<?php
/**
 * Atributos utilizados pela classe DalUsuario para conter configurações e limites
 * pré-estabelecidos
 */

namespace Config;

abstract class DalUsuarioConfig {
	// O máximo de objetos que uma procura de usuários pode retornar,
	// se o valor informado for 0 ou menor, a procura retornará todos
	const LISTAR_USUARIOS_LIMITE = 100;
}

?>