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
<?php } else { ?>
<p class="erro">Nenhuma imagem encontrada :(.</p>
<?php } ?>
