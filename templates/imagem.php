<main>
	<article class="imagem">
		<section>
			<div class="imagem-back">
				<h1><?php echo $itens["img_imagem"]->getTitulo(true); ?></h1>
				<img class="imagem" alt="A imagem a ser exibida" src="<?php echo $itens["img_imagem"]->getImagemUrl(); ?>">
			</div>
			<div class="info-container">
				<p class="descricao"><?php echo $itens["img_imagem"]->getDescricao(true); ?></p>
				<p class="data-criacao">Adicionado em <?php echo $itens["img_imagem"]->getDataCriacao(1); ?></p>
			</div>
			<div class="usuario-container<?php if ($itens["img_autor"]->estaOnline()) { echo " usuario-container-online"; } ?>">
				<a class="link-efeito" href="<?php echo $itens["img_autor"]->getLink(); ?>">
					<img class="usuario-imagem" alt="Imagem de perfil do autor" src="<?php echo $itens["img_autor"]->getImagemUrl(); ?>" draggable="false">
					<span class="usuario-nome"><?php echo $itens["img_autor"]->getNome(); ?></span>
				</a>
			</div>
		</section>
		<section>
			<?php if ($itens["usr_logado"] !== null) { ?>
			<div class="comentario-form-container">
				<div class="esquerda-container">
					<img src="<?php echo $itens["usr_logado"]->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
				</div>
				<div class="direita-container">
					<form method="POST" autocomplete="off">
						<textarea name="cmtcon" maxlength="300" placeholder="Escreva aqui seu comentário..."></textarea>
						<button type="submit">Enviar</button>
					</form>
				</div>
			</div>
			<?php } ?>
			<?php if (count($itens["img_comentarios"]) > 0) { ?>
			<ul class="comentario-container">
				<?php foreach ($itens["img_comentarios"] as $comentario) { ?>

				<?php } ?>
			</ul>
			<?php } else if ($itens["usr_logado"] !== null) { ?>
				<p class="erro">Esta imagem não possui comentários, seja o primeiro a comentar algo!</p>
			<?php } ?>
		</section>
	</article>
</main>
