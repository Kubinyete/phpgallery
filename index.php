<?php
/**
 * Utilizando o modelo de Front controller para a aplicação
 * https://en.wikipedia.org/wiki/Front_controller
 * "The front controller software design pattern is listed in several pattern catalogs
 *  and related to the design of Web applications. It is "a controller that handles all
 *  requests for a Web site",[1] which is a useful structure for Web application
 *  developers to achieve the flexibility and reuse without code redundancy."
 */

namespace PHPGallery;

require_once "WebInterface/cabecalho_sessao.php";

$pedido_pagina = (isset($_GET["v"])) ? $_GET["v"] : "home";

/**
 * Se for preciso atualizar alguma coisa no cabeçalho do documento e no cabeçalho do corpo
 * importe a sessão antes de importar tais arquivos, então passe um valor de um script para
 * o outro através de constantes
 * Ex: meta tags html, og tags
 */

require_once "WebInterface/cabecalho.php";
require_once "WebInterface/cabecalho_corpo.php";



switch ($pedido_pagina) {
    case "home":
        require_once "WebInterface/home.php";
        break;
    case "perfil":
        require_once "WebInterface/perfil.php";
        break;
    case "enviar":
        require_once "WebInterface/enviar.php";
        break;
    //404 Not Found
    default:
        require_once "WebInterface/404.php";
        break;
}

?>
</body>
</html>
