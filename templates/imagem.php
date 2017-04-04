<main>
	<article class="imagem">
		<section>
			<h1><?php echo $itens["img_imagem"]->getTitulo(true); ?></h1>
			<img class="imagem" alt="A imagem a ser exibida" src="<?php echo $itens["img_imagem"]->getImagemUrl(); ?>">
			<p class="descricao"><?php echo $itens["img_imagem"]->getDescricao(true); ?></p>
			<p class="data-criacao">Adicionado em <?php echo $itens["img_imagem"]->getDataCriacao(1); ?></p>
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
						<textarea name="cmtcon" maxlength="300" placeholder="Escreva aqui seu comentário..."><?php echo ($itens["cmt_conteudo"] !== null) ? $itens["cmt_conteudo"] : ""; ?></textarea>
						<button type="submit">Enviar</button>
					</form>
				</div>
			</div>
			<?php } ?>
			<?php if (strlen($itens["cmt_erro_mensagem"])) { ?>
			<script>
				phpgallery.erroDialogo('Erro', '<?php echo $itens["cmt_erro_mensagem"]; ?>');
			</script>
			<?php } ?>
			<?php if (count($itens["img_comentarios"]) > 0) { ?>
			<ul class="comentario-container">
				<?php foreach ($itens["img_comentarios"] as $comentario) { ?>
					<li>
						<div class="comentario-form-container comentario-norm-container <?php echo (!$comentario["autor"]->estaOnline()) ? "comentario-offline-container" : ""; ?>">
							<div class="esquerda-container">
								<a href="<?php echo $comentario["autor"]->getLink(); ?>">
									<img src="<?php echo $comentario["autor"]->getImagemUrl(); ?>" alt="<?php echo $comentario["autor"]->getNome(); ?>"><!--
									--><br><!--
									--><span class="usuario-nome"><?php echo $comentario["autor"]->getNome(); ?></span>
								</a>
							</div>
							<div class="direita-container">
								<p><?php echo $comentario["comentario"]->getConteudo(true); ?></p>
								<span class="data-criacao">Adicionado em <?php echo $comentario["comentario"]->getDataCriacao(1); ?></span>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</section>
	</article>
</main>
