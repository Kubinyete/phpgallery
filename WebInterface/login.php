<?php
namespace PHPGallery\WebInterface;

require_once "Validacao.php";
require_once "Pedido.php";
require_once "Sessao.php";
require_once "Resposta.php";

set_include_path("..");

require_once "DatabaseInterface/Conexao.php";

use PHPGallery\DatabaseInterface\Conexao;

if (Sessao::get_usuario() !== null) {
    // Fazer logoff
    if (Pedido::obter("l", "GET") === "1") {
        Sessao::set_usuario(null);
        Resposta::redirecionar("?v=login");
        exit();
    // Redirecione para a página principal
    } else {
        Resposta::redirecionar("?v=home");
        exit();
    }
}

$loginErro = false;

// Login
if (Pedido::obter("r", "POST") === "0") {
    try {
        $val = new Validacao(new Conexao());
        $val->efetuar_login(Pedido::obter("u", "POST"), Pedido::obter("s"), "POST");
        exit();
    } catch (ValidacaoErro $e) {
        $loginErro = $e->getMessage();
    }
// Registrar
} else if (Pedido::obter("r", "POST") === "1") {

}

?>
    <main>
        <div class="conteudo-divisao">
            <i class="conteudo-divisao-icone fa fa-sign-in"></i>
            <h1>Efetuar login</h1>
        </div>
        <div class="conteudo conteudo-centro">
            <?php if ($loginErro !== false) { ?>
            <script>
                phpgallery.loginErro = true;
            </script>
            <?php } ?>
            <form id="login-formulario" class="formulario" method="POST" autocomplete="off">
                <input type="hidden" name="v" value="login">
                <input type="hidden" name="r" value="0">
                <label for="login-nome">Nome</label>
                <input id="login-nome" maxlength="16" type="text" name="u" placeholder="Nome do usuário" required>
                <?php if ($loginErro !== false) { ?>
                <i class="fa fa-warning"></i>
                <?php } ?>
                <br>
                <label for="login-senha">Senha</label>
                <input id="login-senha" maxlength="32" type="password" name="s" placeholder="Senha" required>
                <?php if ($loginErro !== false) { ?>
                <span><?php echo $loginErro; ?></span>
                <script>
                    if (phpgallery.loginErro) {
                        $("#login-nome, #login-senha").keypress(
                            function() {
                                $("#login-formulario i").remove();
                                $("#login-formulario span").remove();
                                $("#login-nome, #login-senha").off();
                            }
                        );
                    }
                </script>
                <?php } ?>
                <br>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="conteudo-divisao">
            <i class="conteudo-divisao-icone fa fa-user-o"></i>
            <h1>Registrar</h1>
        </div>
        <div id="registra-formulario" class="conteudo conteudo-centro">
            <form class="formulario" method="POST" autocomplete="off">
                <input type="hidden" name="v" value="login">
                <input type="hidden" name="r" value="1">
                <label for="registra-nome">Nome</label>
                <input id="registra-nome" maxlength="16" type="text" name="u" placeholder="Nome do usuário" required><br>
                <label for="registra-senha">Senha</label>
                <input id="registra-senha" maxlength="32" type="password" name="s" placeholder="Senha" required><br>
                <label for="registra-confirma-senha">Confirme sua senha</label>
                <input id="registra-confirma-senha" maxlength="32" type="password" name="s2" placeholder="Senha" required><br>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </main>
