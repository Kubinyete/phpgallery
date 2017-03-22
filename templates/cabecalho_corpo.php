<header>
	<div class="centro">
		<a href="/?v=home">
			<img src="<?php echo $caminhoRecursos; ?>phpgallery-logo.png" alt="Logo" draggable="false">
		</a>
		<?php if ($usuarioLogado !== null) { ?>
		<!-- -->
		<div class="usuario-container">
			<span class="usuario-nome"><?php echo $usuarioLogado->getNome(); ?></span>
			<img src="<?php echo $usuarioLogado->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
		</div>
		<?php } ?>
		<!-- -->
		<nav id="headerNavegacao">
			<ul><!--
				--><li>
					<a href="/?v=home">Home</a>
				</li><!--
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
