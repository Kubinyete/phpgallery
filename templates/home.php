<main>
	<article>
		<h1>Adicionadas recentemente</h1>
		<p>Estas são as imagens recentemente adicionadas até o momento!</p>
		<?php if (count($imagens) >= 1) { ?>
		<ul class="imagens-lista"><!--
			<?php foreach ($imagens as $imagem) { ?>
			--><li>
				<a href="<?php echo $imagem->getLink(); ?>">
					<div class="imagem-container">
						<div style="background-image: url('<?php echo $imagem->getImagemUrl(); ?>')" class="imagem"></div>
						<div class="imagem-gradient"></div>
					</div>
					<span class="imagem-titulo">
						<?php echo $imagem->getTitulo(true); ?>
					</span>
				</a>
				<span class="imagem-descricao">
					<?php echo $imagem->getDescricao(true); ?>
				</span>
			</li><!-- 
			<?php } ?>
		--></ul>
		<h1>Estatísticas</h1>
		<p><span id="contagemImagens"><?php echo $contagemImagens; ?></span> <?php echo ($contagemImagens == 1) ? " Imagem enviada" : " Imagens enviadas" ?></p>
		<script>
			phpgallery.animarContagem("#contagemImagens", 1000);
		</script>	
		<?php } else { ?>
		<p class="erro">Nenhuma imagem encontrada no banco de dados :(.</p>
		<?php } ?>
	</article>
</main>
