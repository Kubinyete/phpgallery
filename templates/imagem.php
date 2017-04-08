<main>
	<article class="imagem">
		<section>
			<h1><?= $itens["img_imagem"]->getTitulo(true); ?></h1>
			<img class="imagem" alt="A imagem a ser exibida" src="<?= $itens["img_imagem"]->getImagemUrl(); ?>">
			<p class="descricao"><?= $itens["img_imagem"]->getDescricao(true); ?></p>
			<p class="data-criacao">Adicionado em <?= $itens["img_imagem"]->getDataCriacao(1); ?></p>
			<div class="usuario-container<?php if ($itens["img_autor"]->estaOnline()): echo " usuario-container-online"; endif; ?>">
				<a class="link-efeito" href="<?= $itens["img_autor"]->getLink(); ?>">
					<img class="usuario-imagem" alt="Imagem de perfil do autor" src="<?= $itens["img_autor"]->getImagemUrl(); ?>" draggable="false">
					<span class="usuario-nome"><?= $itens["img_autor"]->getNome(); ?></span>
				</a>
			</div>
		</section>
		<section>
			<?php if ($itens["usr_logado"] !== null): ?>
			<div class="comentario-form-container">
				<div class="esquerda-container">
					<img src="<?= $itens["usr_logado"]->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
				</div>
				<div class="direita-container">
					<form method="POST" autocomplete="off">
						<textarea name="cmtcon" maxlength="<?= $itens["cmtcon_maxlength"]; ?>" placeholder="Escreva aqui seu comentário..."><?= ($itens["cmt_conteudo"] !== null) ? $itens["cmt_conteudo"] : ""; ?></textarea>
						<button type="submit">Enviar</button>
					</form>
				</div>
			</div>
			<?php endif; ?>
			<?php if (count($itens["img_comentarios"]) > 0): ?>
			<ul class="comentario-container">
				<?php foreach ($itens["img_comentarios"] as $comentario): ?>
					<li>
						<div class="comentario-form-container comentario-norm-container <?= (!$comentario["autor"]->estaOnline()) ? "comentario-offline-container" : ""; ?>">
							<div class="esquerda-container">
								<a href="<?= $comentario["autor"]->getLink(); ?>">
									<img src="<?= $comentario["autor"]->getImagemUrl(); ?>" alt="<?= $comentario["autor"]->getNome(); ?>"><!--
									--><br><!--
									--><span class="usuario-nome"><?= $comentario["autor"]->getNome(); ?></span>
								</a>
							</div>
							<div class="direita-container">
								<p><?= $comentario["comentario"]->getConteudo(true); ?></p>
								<span class="data-criacao">Adicionado em <?= $comentario["comentario"]->getDataCriacao(1); ?></span>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</section>
	</article>
</main>
