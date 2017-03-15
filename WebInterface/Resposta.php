<?php
namespace PHPGallery\WebInterface;

/**
 * Classe responsável por representar uma resposta HTTP
 */
class Resposta {
    public static function redirecionar($localizacao) {
        header("Location: " . $localizacao);
    }
}
?>
