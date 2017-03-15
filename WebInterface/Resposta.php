<?php
namespace PHPGallery\WebInterface;

/**
 * Classe responsável por representar uma resposta HTTP
 */
class Resposta {
    /**
     * Envia um header para redirecionar o pedido atual
     */
    public static function redirecionar($localizacao) {
        header("Location: " . $localizacao);
    }

    /**
     * Envia um código HTTP
     */
    public static function status($cod) {
        header("Status: " . $cod, true, $cod);
    }

    /**
     * Modifica o mimetype do conteûdo a ser enviado
     */
    public static function conteudo_tipo($mimetype) {
        header("Content-Type: " . $mimetype);
    }
}
?>
