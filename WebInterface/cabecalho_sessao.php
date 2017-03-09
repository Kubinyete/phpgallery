<?php
/**
 * Vamos executar todas essas ações na hora de utilizar algo relacionado a sessões
 * está incluido em todas as páginas da aplicação
 */

namespace PHPGallery\WebInterface;

require_once "Sessao.php";

Sessao::iniciar();
Sessao::validar();
Sessao::validar_usuario();

?>