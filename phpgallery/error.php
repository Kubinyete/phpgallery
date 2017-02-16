<?php
	define("CABECALHO_TITULO", "phpgallery : Erro interno");
	require_once "header.php";

	header("Status: 500", true, 500);

	$mensagem = "Código de erro desconhecido.";

	if (isset($_GET["cod"])) {
		switch ($_GET["cod"]) {
			case "0":
				$mensagem = "Não foi possível estabelecer uma conexão com o banco de dados.";
				break;
			case "1":
				$mensagem = "Ocorreu um erro ao realizar uma consulta no banco de dados.";
				break;
			default:
				$mensagem = "Código de erro desconhecido ('" . htmlspecialchars($_GET["cod"]) . "').";
		}
	}
?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<h1 class="texto-sessao vermelho codigohttp">500</h1>
			<h2 class="texto normal">Ocorreu um erro interno ao processar o seu pedido, tente novamente mais tarde... :(</h2>
			<p class="texto-descricao"><?php echo $mensagem; ?></p>
		</div>
	</div>
	<?php 
		include_once "footer.php"; 
	?>
	<script src="/js/phpgallery.js"></script>
</body>
</html>