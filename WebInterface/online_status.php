<?php
/**
 * Responsável por atualizar o estado do usuário, se ele não estiver mais online e requisitou uma página
 * atualize sua timestamp de ultima vez online
 */
namespace PHPGallery\WebInterface;

require_once "Sessao.php";

set_include_path("..");

require_once "DatabaseInterface/Conexao.php";
require_once "DatabaseInterface/DatabaseUsuario.php";

use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\DatabaseInterface\DatabaseALUsuario;

$usuario = Sessao::get_usuario();

if ($usuario !== null && !$usuario->esta_online()) {
    $usuario->set_online_timestamp(time());
    $dal = new DatabaseALUsuario(new Conexao());
    $dal->atualizar_usuario($usuario);
}

?>
