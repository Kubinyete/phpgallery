<div class="visualizacao-imagem-fundo">
	<div class="esquerda-container">
		<ul>
			<?php foreach ($itens["imagens"] as $imagem): ?>
			<li style="background-image: url(<?= $imagem->getMiniaturaUrl(); ?>);" onclick="phpgallery.visualizacao.mudarImagem('<?= $imagem->getImagemUrl(); ?>', '<?= $imagem->getTitulo(true, true); ?>', '<?= $imagem->getDescricao(true, true); ?>', this);">
				<div class="metade-container">
					<span><?= $imagem->getTitulo(true); ?></span>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="direita-container">
		<button onclick="phpgallery.visualizacao.desativar();"><i class="fa fa-close"></i></button>
		<div class="visualizacao-imagem-titulo">
			<span>Carregando...</span>
		</div>
		<div class="visualizacao-imagem-container">
			<img src="<?= $itens["recursos"]; ?>carregando.gif" alt="Carregando...">
		</div>
		<div class="visualizacao-imagem-descricao">
			<span>Carregando...</span>
		</div>
	</div>
</div>
