<main>
	<article class="imagem">
		<section>
			<h1><?php echo $imagem->getTitulo(true); ?></h1>
			<img class="imagem" alt="A imagem a ser exibida" src="<?php echo $imagem->getImagemUrl(); ?>">
			<p class="descricao"><?php echo $imagem->getDescricao(true); ?></p>
			<p class="data-criacao">Adicionado em <?php echo $imagem->getDataCriacao(1); ?></p>
			<div class="usuario-container<?php if ($autor->estaOnline()) { echo " usuario-container-online"; } ?>">
				<a class="link-efeito" href="<?php echo $autor->getLink(); ?>">
					<img class="usuario-imagem" alt="Imagem de perfil do autor" src="<?php echo $autor->getImagemUrl(); ?>" draggable="false">
					<span class="usuario-nome"><?php echo $autor->getNome(); ?></span>
				</a>
			</div>
		</section>
		<section>
			<?php if ($usuarioLogado !== null) { ?>
			<form method="POST" autocomplete="off">
				<textarea name="cmt_c"></textarea>
				<button type="submit">Enviar</button>
			</form>
			<?php } ?>
			<?php if (count($comentarios) > 0) { ?>
			<ul class="comentario-container">
				<?php foreach ($comentarios as $comentario) { ?>

				<?php } ?>
			</ul>
			<?php } else if ($usuarioLogado !== null) { ?>
				<p class="erro">Esta imagem não possui comentários, seja o primeiro a comentar algo!</p>
			<?php } ?>
		</section>
	</article>
</main>
