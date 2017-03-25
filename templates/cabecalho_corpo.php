<header>
	<div class="centro">
		<a href="/?v=home">
			<img src="<?php echo $caminhoRecursos; ?>phpgallery-logo.png" alt="Logo" draggable="false">
		</a>
		<?php if ($usuarioLogado !== null) { ?>
		<!-- -->
		<div class="usuario-container">
			<a href="<?php echo $usuarioLogado->getLink(); ?>">
				<img src="<?php echo $usuarioLogado->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
				<span class="usuario-nome"><?php echo $usuarioLogado->getNome(); ?></span>
			</a>
		</div>
		<?php } ?>
		<!-- -->
		<nav id="headerNavegacao">
			<ul><!--
				--><li>
					<a href="/?v=home">Home</a>
				</li><!--
			<?php if ($usuarioLogado !== null) { ?>
			--><li>
					<a href="/?v=perfil">Perfil</a>
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
<script>
	$(window).scroll(
		function() {
			var scrollVertical = $(window).scrollTop();

			if (scrollVertical > 0 && !phpgallery.cabecalhoAnimAtivado) {
				$("header").addClass("ativado");
				phpgallery.cabecalhoAnimAtivado = true;
			} else if (scrollVertical <= 0 && phpgallery.cabecalhoAnimAtivado) {
				$("header").removeClass("ativado");
				phpgallery.cabecalhoAnimAtivado = false;
			}
		}
	);
</script>
