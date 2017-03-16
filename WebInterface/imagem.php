<?php
/**
 * Página de visualização de imagem
 */

namespace PHPGallery\WebInterface;

require_once "Pedido.php";
require_once "Resposta.php";

set_include_path("..");
require_once "DatabaseInterface/Conexao.php";
require_once "DatabaseInterface/DatabaseImagem.php";
require_once "DatabaseInterface/DatabaseUsuario.php";
require_once "DatabaseInterface/DatabaseComentario.php";

use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\DatabaseInterface\DatabaseALImagem;
use PHPGallery\DatabaseInterface\DatabaseALUsuario;
use PHPGallery\DatabaseInterface\DatabaseALComentario;

$id = intval(Pedido::obter("id", "GET"));
$imagem = null;
$autor = null;

if ($id > 0) {
    $conexao = new Conexao();

    $dal = new DatabaseALImagem($conexao);
    $imagem = $dal->obter_imagem($id);

    if ($imagem !== null) {
        $dal = new DatabaseALUsuario($conexao);
        $autor = $dal->obter_usuario($imagem->get_usr_id());
    }
}

?>
    <?php if ($imagem !== null) { ?>
    <main>
        <div class="conteudo-divisao">
            <i class="conteudo-divisao-icone fa fa-photo"></i>
            <h1><?php echo $imagem->get_titulo(true); ?></h1>
        </div>
        <script>
            $(document).ready(
                function() {
                    phpgallery.irPara(".conteudo-divisao", -50, false);
                }
            );
        </script>
        <div class="conteudo">
            <div class="imagem-container">
                <img src="<?php echo $imagem->obter_imagem_url(); ?>" alt="<?php echo $imagem->get_titulo(true); ?>">
                <div class="imagem-descricao-container">
                    <h2><?php echo $imagem->get_titulo(true); ?></h2>
                    <p class="imagem-descricao"><?php echo $imagem->get_descricao(true); ?></p>
                    <span class="imagem-data">Adicionado em <?php echo $imagem->get_data_criacao(true); ?></span>
                </div>
                <div class="imagem-usuario-container <?php if ($autor->esta_online()) { echo "imagem-usuario-container-online"; } ?>">
                    <a class="link" href="/?v=perfil&amp;u=<?php echo $autor->get_nome(); ?>">
                        <img draggable="false" src="<?php echo $autor->obter_imagem_url(); ?>" alt="Imagem de perfil do autor.">
                        <span><?php echo $autor->get_nome(); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <?php } else { Resposta::status(404); ?>
    <main class="erro-notfound">
        <div class="conteudo-erro-notfound">
            <span class="erro-titulo">:(</span>
            <br>
            <span class="erro-descricao">A imagem que você está procurando não existe. Aqui está um link para à <a href="/" class="link link-azul">página principal</a>.</span>
            <br>
            <span class="erro-descricao">404 Not Found</span>
        </div>
    </main>
    <?php } ?>
