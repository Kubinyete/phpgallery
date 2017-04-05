<main>
	<article>
		<section>
			<div class="perfil-container <?php if ($itens["usr_usuario"]->estaOnline()) { echo " perfil-container-online"; } ?>">
				<h1 class="usuario-nome"><?php echo $itens["usr_usuario"]->getNome(); ?></h1>
				<img class="imagem-perfil" src="<?php echo $itens["usr_usuario"]->getImagemUrl(); ?>" alt="A imagem de perfil do usuário" draggable="false">
				<p class="status-perfil"><?php echo ($itens["usr_usuario"]->estaOnline()) ? "Online" : "Offline"; ?></p>
				<p class="descricao"><?php echo $itens["usr_usuario"]->getDescricao(true); ?></p>
			</div>
		</section>
		<section>
			<h1>Imagens enviadas</h1>
			<p>Estas são as ultimas imagens adicionadas por <?php echo $itens["usr_usuario"]->getNome(); ?></p> 
			<?php include $itens["proc_imagens_lista"]; ?>
		</section>
	</article>
</main>
