<main>
	<article>
		<section>
			<div class="perfil-container <?php if ($usuario->estaOnline()) { echo " perfil-container-online"; } ?>">
				<h1 class="usuario-nome"><?php echo $usuario->getNome(); ?></h1>
				<img class="imagem-perfil" src="<?php echo $usuario->getImagemUrl(); ?>" alt="A imagem de perfil do usuário" draggable="false">
				<p class="status-perfil"><?php echo ($usuario->estaOnline()) ? "Online" : "Offline"; ?></p>
				<p class="descricao"><?php echo $usuario->getDescricao(true); ?></p>
			</div>
		</section>
		<section>
			<h1>Imagens enviadas</h1>
			<?php include $processadorListagemImagens; ?>
		</section>
	</article>
</main>