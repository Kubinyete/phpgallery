<main>
	<div class="conteudo-container">
		<h1>Login</h1>
			<p>Efetue login em uma conta já existente</p>
			<form id="login-form" class="aut-formulario" method="POST" autocomplete="off">
			<input type="hidden" name="a" value="l">
				<label for="loginNome">Nome</label>
				<input id="loginNome" type="text" name="nom" placeholder="Nome do usuário" maxlength="<?= $itens["loginNome_maxlength"]; ?>">
				<?php if ($itens["login_acao"] === "l" && $itens["login_erro_mensagem"] !== null): ?>
				<i class="fa fa-warning"></i>
				<?php endif; ?>
				<br>
				<label for="loginSenha">Senha</label>
				<input id="loginSenha" type="password" name="sen" placeholder="Senha do usuário" maxlength="<?= $itens["loginSenha_maxlength"]; ?>">
				<br>
				<button type="submit">Enviar</button>
				<?php if ($itens["login_acao"] === "l" && $itens["login_erro_mensagem"] !== null): ?>
				<span class="caixaerro">
					<?= $itens["login_erro_mensagem"]; ?>
				</span>
				<script type="text/javascript">
					$("#login-form input").keypress(
						function() {
							$("#login-form i.fa-warning, span.caixaerro").remove();
							$("#login-form input").off();
						}
					);
				</script>
				<?php endif; ?>
			</form>
		<h1>Registre-se</h1>
			<p>Crie uma nova conta</p>
			<form id="registrar-form" class="aut-formulario" method="POST" autocomplete="off">
				<input type="hidden" name="a" value="r">
				<label for="registraNome">Nome</label>
				<input id="registraNome" type="text" name="nom" placeholder="Nome do usuário" maxlength="<?= $itens["registraNome_maxlength"]; ?>">
				<?php if ($itens["login_acao"] === "r" && $itens["login_erro_mensagem"] !== null): ?>
				<i class="fa fa-warning"></i>
				<?php endif; ?>
				<br>
				<label for="registraSenha">Senha</label>
				<input id="registraSenha" type="password" name="sen" placeholder="Senha do usuário" maxlength="<?= $itens["registraSenha_maxlength"]; ?>">
				<br>
				<label for="registraConfirmaSenha">Confirmar senha</label>
				<input id="registraConfirmaSenha" type="password" name="consen" placeholder="Senha do usuário" maxlength="<?= $itens["registraSenha_maxlength"]; ?>">
				<br>
				<button type="submit">Registrar</button>
				<?php if ($itens["login_acao"] === "r" && $itens["login_erro_mensagem"] !== null): ?>
				<span class="caixaerro">
					<?= $itens["login_erro_mensagem"]; ?>
				</span>
				<script type="text/javascript">
					$("#registrar-form input").keypress(
						function() {
							$("#registrar-form i.fa-warning, span.caixaerro").remove();
							$("#registrar-form input").off();
						}
					);
				</script>
				<?php endif; ?>
			</form>
	</div>
</main>
