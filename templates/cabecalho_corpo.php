<header>
	<div class="centro">
		<a href="/?v=home">
			<img src="<?php echo $itens["recursos"]; ?>phpgallery-logo.png" alt="Logo" draggable="false">
		</a>
		<?php if ($itens["usr_logado"] !== null) { ?>
		<!-- -->
		<div class="usuario-container">
			<button id="usuarioMenuBtn" onclick="phpgallery.usuarioMenu.gerenciar();"><i class="fa fa-caret-down"></i></button>
			<a href="<?php echo $itens["usr_logado"]->getLink(); ?>">
				<img src="<?php echo $itens["usr_logado"]->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
				<span class="usuario-nome"><?php echo $itens["usr_logado"]->getNome(); ?></span>
			</a>
		</div>
		<?php } ?>
		<!-- -->
		<nav id="headerNavegacao">
			<ul><!--
				--><li>
					<a href="/?v=home">Home</a>
				</li><!--
			<?php if ($itens["usr_logado"] !== null) { ?>
			--><li>
					<a href="/?v=perfil">Perfil</a>
				</li><!--
				--><li>
					<a href="/?v=enviar">Enviar</a>
				</li><!--
			<?php } else { ?>
			--><li>
					<a href="/?v=login">Login</a>
				</li><!--
			<?php } ?>
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
<?php if ($itens["usr_logado"] !== null) { ?>
<nav id="usuarioMenu">
	<ul>
		<li>
			<a href="/?v=login&l=1">Sair</a>
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
<?php } ?>
