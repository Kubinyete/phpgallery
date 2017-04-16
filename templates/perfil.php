<main>
	<article>
		<section>
			<div class="perfil-container <?php if ($itens["usr_usuario"]->estaOnline()): echo " perfil-container-online"; endif; ?>" style="background-image: url('<?= $itens["usr_usuario"]->getImagemFundoUrl(); ?>');">
				<div class="overlay">
					<?php if ($itens["usr_logado"] !== null && $itens["usr_logado"]->getNome() === $itens["usr_usuario"]->getNome()): ?>
					<a class="edit-btn" href="<?= $itens['href_editar_perfil']; ?>">Editar perfil</a>
					<?php endif; ?>
					<h1 class="usuario-nome"><?= $itens["usr_usuario"]->getNome(); ?></h1>
				</div>
				<div class="imagem-perfil-container">
					<?php if ($itens["usr_usuario"]->getAdmin()): ?>
					<img class="admin-icon" draggable="false" src="<?= $itens["recursos"]; ?>admin-icon.png">
					<?php endif; ?>
					<img class="imagem-perfil" src="<?= $itens["usr_usuario"]->getImagemUrl(); ?>" alt="A imagem de perfil do usuário" draggable="false">
					<p class="status-perfil"><?= ($itens["usr_usuario"]->estaOnline()) ? "Online" : "Offline"; ?></p>
				</div>
				<div class="overlay">
					<p class="descricao"><?= $itens["usr_usuario"]->getDescricao(true); ?></p>
					<p class="descricao"><?php echo ($itens["usr_usuario"]->getAdmin()) ? "Administrador" : "Usuário"; ?> - <?= $itens["usr_usuario"]->getRep(); ?> REP</p>
				</div>
			</div>
		</section>
		<section>
			<h1>Imagens enviadas</h1>
			<p>Estas são as ultimas imagens adicionadas por <?= $itens["usr_usuario"]->getNome(); ?></p> 
			<?php ( file_exists($itens["proc_imagens_lista"]) ) ? : include $itens["proc_imagens_lista"]; ?>
		</section>
	</article>
</main>
