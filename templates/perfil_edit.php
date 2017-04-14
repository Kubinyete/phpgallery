<main>
	<article>
		<section>
			<h1>Editar perfil</h1>
			<div class="perfil-container perfil-container-online" style="background-image: url('<?= $itens["usr_logado"]->getImagemFundoUrl(); ?>');">
				<form id="perfil-edit-form" method="POST" enctype="multipart/form-data" autocomplete="off">
					<input id="img-fundo-id" type="hidden" name="usrif" value="<?= $itens['usr_logado']->getImgFundo(); ?>">
					<div class="overlay">
						<h1 class="usuario-nome"><?= $itens["usr_logado"]->getNome(); ?></h1>
					</div>
					<div class="esquerda-container">
						<img class="imagem-perfil" src="<?= $itens["usr_logado"]->getImagemUrl(); ?>" alt="A imagem de perfil do usuário" draggable="false">
						<input name="usrim" type="file" accept="image/jpeg">
					</div>
					<div class="direita-container">
						<textarea name="usrde" maxlength="<?= $itens["usrde_maxlength"]; ?>"><?= $itens["usr_logado"]->getDescricao(true); ?></textarea>
					</div>
					<div class="cfix conteudo-centro">
						<button class="btn" type="submit">Atualizar</button>
					</div>
				</form>
			</div>
		</section>
		<section>
			<h1>Imagem de fundo</h1>
			<p>Você poderá escolher uma de suas imagens enviadas para servir como plano de fundo em seu perfil</p>
			<?php include $itens['proc_imagens_fundo_lista']; ?>
		</section>
	</article>
</main>
