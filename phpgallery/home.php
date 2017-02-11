<?php
	define("CABECALHO_TITULO", "PHPGallery - Início");
	require_once "header.php";
?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<div class="sessao-recentes">
				<h1 id="texto-sessao-recentes" class="texto-sessao"><i class="fa fa-image azul"></i> Adicionados recentemente</h1>
				<div class="fundo-preto pesquisa">
					<input id="pesquisa" class="pesquisa" type="search" placeholder="Pesquisar">
					<button id="pesquisa-botao" class="pesquisa-botao" onclick="pesquisarBotao();"><i class="fa fa-paper-plane azul"></i></button>
				</div>
				<ul id="sessao-recentes-lista" class="sessao-recentes-lista">
					<!-- Resultados -->
					<img id="loading" alt="Ícone de carregamento" src="/resources/loading.svg" draggable="false">
				</ul>
			</div>
			<h1 class="texto-sessao"><i class="fa fa-database azul"></i> <?php
			$db = new Database();
			$numeroImagens = $db->obter_numero_imagens();
			$db->finalizar();

			if ($numeroImagens > 1) {
				echo($numeroImagens . " Imagens armazenadas até o momento...");
			} else if ($numeroImagens == 1){
				echo($numeroImagens . " Imagem armazenada até o momento...");
			} else {
				echo("Nenhuma imagem armazenada até o momento...");
			}?></h1>
		</div>
	</div>
	<?php include_once "template/preview.html"; ?>
	<script src="/js/phpgallery.js"></script>
	<script>
	//Ao apertar Enter(13), faça a pesquisa
	$("#pesquisa").keypress(
		function(e) {
			if (e.keyCode == 13 && $("#pesquisa").val() != ultimaBusca) {
				pesquisar($("#pesquisa").val());
				ultimaBusca = $("#pesquisa").val();
			}
		}
	);

	//Inicialização da página, é necessário consultar nossa API, pedindo as imagens recentes
	atualizarRecentes();
	</script>
</body>
</html>