<main>
	<article class="imagem">
		<section>
			<h1><?= $itens["img_imagem"]->getTitulo(true); ?></h1>
			<img class="imagem" alt="A imagem a ser exibida" src="<?= $itens["img_imagem"]->getImagemUrl(); ?>">
			<p class="descricao"><?= $itens["img_imagem"]->getDescricao(true); ?></p>
			<p class="data-criacao info-detalhada">Formato <?= strtoupper($itens["img_imagem"]->getExtensao()); ?> - Dimensões: <?= $itens["img_imagem"]->getLargura(); ?>x<?= $itens["img_imagem"]->getAltura(); ?></p>
			<p class="data-criacao">Adicionado em <?= $itens["img_imagem"]->getDataCriacao(1); ?></p>
			<div class="usuario-container<?php if ($itens["img_autor"]->estaOnline()): echo " usuario-container-online"; endif; ?>" style="background-image: url('<?= $itens["img_autor"]->getImagemFundoUrl(); ?>');">
				<div class="btns-container">
					<div class="btn-container">
						<a class="btn" href="<?= $itens["img_imagem"]->getDownloadLink(); ?>"><i class="fa fa-download"></i></a>
						<span class="tooltip">Efetuar o download da imagem</span>
					</div>
					<?php if ($itens["usr_logado"] !== null && ($itens["usr_logado"]->getNome() === $itens["img_autor"]->getNome() || $itens["usr_logado"]->getAdmin())): ?>
					<div class="btn-container">
						<a class="btn" href="<?= $itens["img_imagem"]->getEditarLink(); ?>"><i class="fa fa-edit"></i></a>
						<span class="tooltip">Editar as informações dessa imagem</span>
					</div>
					<?php endif; ?>
				</div>
				<?php if ($itens["img_autor"]->getAdmin()): ?>
				<img class="admin-icon" draggable="false" src="<?= $itens["recursos"]; ?>admin-icon.png">
				<?php endif; ?>
				<div class="overflow-wrapper">
					<div class="usuario-fundo">
						<a class="link-efeito" href="<?= $itens["img_autor"]->getLink(); ?>">
							<img class="usuario-imagem" alt="Imagem de perfil do autor" src="<?= $itens["img_autor"]->getImagemUrl(); ?>" draggable="false">
							<span class="usuario-nome"><?= $itens["img_autor"]->getNome(); ?></span>
						</a>
						<div class="cfix"></div>
					</div>
				</div>
			</div>
		</section>
		<section>
			<?php if ($itens["usr_logado"] !== null): ?>
			<div class="comentario-form-container">
				<div class="esquerda-container">
					<img class="cmt-usuario-imagem" src="<?= $itens["usr_logado"]->getImagemUrl(); ?>" alt="Sua imagem de perfil" draggable="false">
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
								<?php if ($comentario["autor"]->getAdmin()): ?>
								<img class="admin-icone" src="<?= $itens["recursos"]; ?>admin-icon.png" draggable="false" alt="<?= $comentario["autor"]->getNome(); ?> é um administrador.">
								<?php endif; ?>
								<a href="<?= $comentario["autor"]->getLink(); ?>">
									<img class="cmt-usuario-imagem" src="<?= $comentario["autor"]->getImagemUrl(); ?>" alt="<?= $comentario["autor"]->getNome(); ?>"><!--
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
