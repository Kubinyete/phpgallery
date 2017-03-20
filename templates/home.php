<main>
	<h1>Adicionadas recentemente</h1>
	<p>Estas são as imagens recentemente adicionadas até o momento!</p>
	<?php if (count($imagens) >= 1) { ?>
	<ul class="imagens-lista">
		<?php foreach ($imagens as $imagem) { ?>
		<li>
			<a href="<?php $imagem->getLink(); ?>">
				<div class="imagem-container">
					<div style="background-image: url('<?php $imagem->getImagemUrl(); ?>')" class="imagem"></div>
					<div class="imagem-gradient"></div>
				</div>
				<span class="imagem-titulo">
					<?php echo $imagem->getTitulo(true); ?>
				</span>
			</a>
		</li> 
		<?php } ?>
	</ul>
	<?php } else { ?>
	<p class="erro">Nenhuma imagem encontrada no banco de dados :(.</p>
	<?php } ?>
</main>
