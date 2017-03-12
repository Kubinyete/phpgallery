<?php
namespace PHPGallery\WebInterface;

require_once "Referencias.php";

header("Status: 404", true, 404);

?>
	<main class="erro">
		<div class="conteudo-erro">
			<span class="erro-titulo">:(</span>
			<br>
			<span class="erro-descricao">A página que você está procurando não existe. Aqui está um link para à <a href="<?php echo Referencias::$script_inicial; ?>" class="link link-azul">página principal</a>.</span>
		</div>
	</main>