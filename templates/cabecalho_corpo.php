<header>
	<div class="centro">
		<a href="<?= $itens['href_home']; ?>">
			<img src="<?= $itens["recursos"]; ?>phpgallery-logo.png" alt="Logo" draggable="false">
		</a>
		<?php if ($itens["usr_logado"] !== null): ?>
		<!-- -->
		<div class="usuario-container">
			<button id="usuarioMenuBtn" onclick="phpgallery.usuarioMenu.gerenciar();"><i class="fa fa-caret-down"></i></button>
			<a href="<?= $itens["usr_logado"]->getLink(); ?>">
				<img src="<?= $itens["usr_logado"]->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
				<span class="usuario-nome"><?= $itens["usr_logado"]->getNome(); ?></span>
			</a>
		</div>
		<?php endif; ?>
		<!-- -->
		<nav id="headerNavegacao">
			<ul><!--
				--><li>
					<a href="<?= $itens['href_home']; ?>">Home</a>
				</li><!--
			<?php if ($itens["usr_logado"] !== null): ?>
			--><li>
					<a href="<?= $itens['href_perfil']; ?>">Perfil</a>
				</li><!--
				--><li>
					<a href="<?= $itens['href_enviar']; ?>">Enviar</a>
				</li><!--
			<?php else: ?>
			--><li>
					<a href="<?= $itens['href_login']; ?>">Login</a>
				</li><!--
			<?php endif; ?>
			--></ul>
		</nav>
	</div>
</header>
<script type="text/javascript">
	$(window).scroll(
		function() {
			var scrollVertical = $(window).scrollTop();

			if (scrollVertical > 0 && !phpgallery.cabecalho.animAtivada) {
				$("header").addClass("ativado");
				phpgallery.cabecalho.animAtivada = true;
			} else if (scrollVertical <= 0 && phpgallery.cabecalho.animAtivada) {
				$("header").removeClass("ativado");
				phpgallery.cabecalho.animAtivada = false;
			}
		}
	);
</script>
<?php if ($itens["usr_logado"] !== null): ?>
<nav id="usuarioMenu">
	<ul>
		<li>
			<a href="<?= $itens['href_editar_perfil']; ?>">Editar perfil</a>
		</li>
		<li>
			<a href="<?= $itens['href_login_sair']; ?>">Sair</a>
		</li>
	</ul>
</nav>
<script type="text/javascript">
	$(window).resize(
		function() {
			if (phpgallery.usuarioMenu.ativado) {
				phpgallery.usuarioMenu.ajustarPos();
			}
		}
	);
</script>
<?php endif; ?>
