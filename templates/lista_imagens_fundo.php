<?php if (count($itens["imagens"]) >= 1): ?>
<ul id="imagens-fundo-lista" class="imagens-lista"><!--
	<?php foreach ($itens["imagens"] as $imagem): ?>
	--><li >
		<button onclick="window.phpgallery.perfilEdit.atualizarImagemFundo(<?= $imagem->getId(); ?>, '<?= $imagem->getImagemUrl(); ?>');">Selecionar</button>
		<div class="imagem-container">
			<div style="background-image: url('<?= $imagem->getMiniaturaUrl(); ?>')" class="imagem"></div>
			<div class="imagem-gradient"></div>
		</div>
		<span class="imagem-titulo">
			<?= $imagem->getTitulo(true); ?>
		</span>
		<span class="imagem-descricao">
			<b>
			<?= $imagem->getExtensao(true); ?>
			<br>
			<?= $imagem->getLargura(); ?>x<?= $imagem->getAltura(); ?>
			</b>
			<br>
			<?= $imagem->getDescricao(true); ?>
		</span>
	</li><!-- 
	<?php endforeach; ?>
--></ul>
<?php else: ?>
<p class="erro">Nenhuma imagem encontrada :(.</p>
<?php endif; ?>
