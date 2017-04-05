<div class="visualizacao-imagem-fundo">
	<div class="esquerda-container">
		<ul>
			<?php foreach ($itens["imagens"] as $imagem) { ?>
			<li style="background-image: url(<?php echo $imagem->getMiniaturaUrl(); ?>);" onclick="phpgallery.visualizacao.mudarImagem('<?php echo $imagem->getImagemUrl(); ?>', '<?php echo $imagem->getTitulo(true, true); ?>', '<?php echo $imagem->getDescricao(true, true); ?>', this);">
				<div class="metade-container">
					<span><?php echo $imagem->getTitulo(true); ?></span>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="direita-container">
		<button onclick="phpgallery.visualizacao.desativar();"><i class="fa fa-close"></i></button>
		<div class="visualizacao-imagem-titulo">
			<span>Carregando...</span>
		</div>
		<div class="visualizacao-imagem-container">
			<img src="<?php echo $itens["recursos"]; ?>carregando.svg" alt="Carregando...">
			<script>
				phpgallery.visualizacao.iconeCarregando = $(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("src");
			</script>
		</div>
		<div class="visualizacao-imagem-descricao">
			<span>Carregando...</span>
		</div>
	</div>
</div>
