<?php
namespace PHPGallery\WebInterface;

require_once "Validacao.php";



?>
    <main>
        <div class="conteudo-divisao">
            <i class="conteudo-divisao-icone fa fa-sign-in"></i>
            <h1>Efetuar login</h1>
        </div>
        <div class="conteudo">
            <form class="login-form" method="POST" action="" autocomplete="off">
                <input type="hidden" name="v" value="login">
                <input type="hidden" name="r" value="0">
                <label for="nome">Nome</label>
                <input name="nome" type="text" name="u" placeholder="Nome do usuário" required="on"><br>
                <label for="senha">Senha</label>
                <input name="senha" type="password" name="s" placeholder="Senha" required="on"><br>
                <button type="submit">Login</button>
            </form>
        </div>
        <div class="conteudo-divisao">
            <i class="conteudo-divisao-icone fa fa-user-o"></i>
            <h1>Registrar</h1>
        </div>
        <div class="conteudo">
            <form class="login-form" method="POST" action="" autocomplete="off">
                <input type="hidden" name="v" value="login">
                <input type="hidden" name="r" value="1">
                <label for="nome">Nome</label>
                <input name="nome" type="text" name="u" placeholder="Nome do usuário" required="on"><br>
                <label for="senha">Senha</label>
                <input name="senha" type="password" name="s" placeholder="Senha" required="on"><br>
                <label for="senha">Confirme sua senha</label>
                <input name="senha" type="password" name="s2" placeholder="Digite sua senha novamente" required="on"><br>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </main>
