<?php
namespace PHPGallery\WebInterface;

/**
 * Classe responsável por representar um pedido HTTP
 * utilizado para obter e testar valores dos pedidos GET e POST
 */
class Pedido {
    /**
     * Retorna se tal $chave existe no nosso pedido GET / POST
     */
    public static function existe($chave, $metodo) {
        if (strtoupper($metodo) === "POST" || $metodo === true) {
            return isset($_POST[$chave]);
        } else if (strtoupper($metodo) === "GET" || $metodo === false) {
            return isset($_GET[$chave]);
        }
    }

    /**
     * Retorna determinado valor de uma chave de um pedido GET / POST somente se existir
     * não é necessário especificar se é um pedido $tipo GET ou POST
     * a própria função se encarregará de encontrar uma chave existente
     */
    public static function obter($chave, $tipo="AUTO") {
        $tipo = strtoupper($tipo);
        if ($tipo === "AUTO") {
            if (self::existe($chave, "POST")) {
                return $_POST[$chave];
            } else if (self::existe($chave, "GET")) {
                return $_GET[$chave];
            }
        } else if (($tipo === "POST" || $tipo === true) && self::existe($chave, "POST")) {
            return $_POST[$chave];
        } else if (($tipo === "GET" || $tipo === false) && self::existe($chave, "GET")) {
            return $_GET[$chave];
        }
    }
}
?>
