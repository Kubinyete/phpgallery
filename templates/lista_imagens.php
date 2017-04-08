<?php if (count($itens["imagens"]) >= 1): ?>
<ul class="imagens-lista"><!--
	<?php foreach ($itens["imagens"] as $imagem): ?>
	--><li >
		<button onclick="phpgallery.visualizacao.ativar('<?= $imagem->getImagemUrl(); ?>', '<?= $imagem->getTitulo(true, true); ?>', '<?= $imagem->getDescricao(true, true); ?>');"><i class="fa fa-arrows-alt"></i></button>
		<a href="<?= $imagem->getLink(); ?>">
			<div class="imagem-container">
				<div style="background-image: url('<?= $imagem->getMiniaturaUrl(); ?>')" class="imagem"></div>
				<div class="imagem-gradient"></div>
			</div>
			<span class="imagem-titulo">
				<?= $imagem->getTitulo(true); ?>
			</span>
		</a>
		<span class="imagem-descricao">
			<?= $imagem->getDescricao(true); ?>
		</span>
	</li><!-- 
	<?php endforeach; ?>
--></ul>
<?php else: ?>
<p class="erro">Nenhuma imagem encontrada :(.</p>
<?php endif; ?>
