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
require_once "WebInterface/Pedido.php";

use PHPGallery\WebInterface\Pedido;

$pedido_pagina = (Pedido::existe("v", "GET")) ? Pedido::obter("v", "GET") : "home";

/**
 * Se for preciso atualizar alguma coisa no cabeçalho do documento e no cabeçalho do corpo
 * importe a sessão antes de importar tais arquivos, então passe um valor de um script para
 * o outro através de constantes
 * Ex: meta tags html, og tags
 */

/* Definido o título das páginas apartir do pedido da pagina */
switch ($pedido_pagina) {
    case "home":
        define("HTML_TITULO", "Home");
        break;
    case "login":
        define("HTML_TITULO", "Área de autenticação");
}

require_once "WebInterface/cabecalho.php";
require_once "WebInterface/cabecalho_corpo.php";

/* Definindo o importe necessário para tal página */
switch ($pedido_pagina) {
    case "home":
        require_once "WebInterface/home.php";
        break;
    case "login":
        require_once "WebInterface/login.php";
        break;
    case "perfil":
        #require_once "WebInterface/perfil.php";
        break;
    case "enviar":
        #require_once "WebInterface/enviar.php";
        break;
    case "procurar":
        #require_once "WebInterface/procurar.php";
        break;
    case "download":
        #require_once "WebInterface/download.php";
        break;
    case "imagem":
        #require_once "WebInterface/imagem.php";
        break;
    default:
        require_once "WebInterface/404.php";
        break;
}

/* Definindo se tal página utilizará nossa visualizacão de imagem */
if ($pedido_pagina == "home") {
    require_once "WebInterface/Templates/template_visualizacao.html";
}

require_once "WebInterface/rodape.php";

?>
</body>
</html>
