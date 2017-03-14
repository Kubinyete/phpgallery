<?php
namespace PHPGallery\WebInterface;

header("Status: 404", true, 404);

?>
	<main class="erro-notfound">
		<div class="conteudo-erro-notfound">
			<span class="erro-titulo">:(</span>
			<br>
			<span class="erro-descricao">A página que você está procurando não existe. Aqui está um link para à <a href="?v=home" class="link link-azul">página principal</a>.</span>
			<br>
			<span class="erro-descricao">404 Not Found</span>
		</div>
	</main>