<?php
/**
 * Classe responsável por representar um pedido HTTP
 * utilizado para obter e testar valores dos pedidos GET e POST
 */

namespace App\Http;

class Pedido {
    // Retorna se tal chave existe no nosso pedido GET / POST
    public static function existe($chave, $metodo) {
        if (strtoupper($metodo) === "POST") {
            return isset($_POST[$chave]);
        } else if (strtoupper($metodo) === "GET") {
            return isset($_GET[$chave]);
        }
    }

    // Retorna o valor de uma chave do pedido GET / POST somente se ela existir
    // não é necessário especificar se é um pedido tipo GET ou POST
    // a própria função se encarregará de encontrar uma chave existente
    // se nenhum tipo for especificado
    public static function obter($chave, $tipo="AUTO") {
        $tipo = strtoupper($tipo);

        if ($tipo === "AUTO") {
            if (self::existe($chave, "POST")) {
                return $_POST[$chave];

            } else if (self::existe($chave, "GET")) {
                return $_GET[$chave];

            }
        } else if (($tipo === "POST") && self::existe($chave, "POST")) {
            return $_POST[$chave];

        } else if (($tipo === "GET") && self::existe($chave, "GET")) {
            return $_GET[$chave];
            
        }
    }
}
?>
