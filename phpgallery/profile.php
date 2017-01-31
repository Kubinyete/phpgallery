<?php
	require_once "header.php";

	$erro = false;
	$usuario = null;
	$nome = null;
	$totalImagensEnviadas = 0;

	//Vamos visualizar o perfil de algum usuário
	if (isset($_GET["u"])) {
		$nome = $_GET["u"];

		$db = new Database();
		$usuario = $db->obter_usuario($nome);

		if ($usuario !== null) {
			$totalImagensEnviadas = $db->obter_numero_imagens($nome);
		}

		$db->finalizar();

	} else {
		//Vamos visualizar o nosso próprio perfil
		$usuario = $_SESSION["usuario"];

		if ($usuario !== null) {
			$db = new Database();
			$totalImagensEnviadas = $db->obter_numero_imagens($usuario->nome);
			$db->finalizar();
		}
	}
?>
<?php if ($usuario !== null) { ?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<div class="profile-usuario-container">
				<a class="link" href="profile.php?u=<?php echo $usuario->nome; ?>">
					<div class="profile-usuario-placar">
						<img class="usuario-imagem" draggable="false" src="<?php echo $usuario->imagem_url(); ?>">
						<p class="texto azul usuario-nome"><?php echo $usuario->nome; ?></p>
					</div>
				</a>
				<div class="profile-usuario-descricao">
					<p class="texto-sessao azul usuario-data"><i class="fa fa-calendar azul"></i> Membro desde <?php echo $usuario->data_registro(); ?></p>
					<p class="texto normal usuario-descricao"><?php echo $usuario->descricao_formatada(true, true); ?></p>
				</div>
			</div>
			<?php
			if ($totalImagensEnviadas < 1) {
				$textoEnvios = "Nenhuma imagem enviada";
			} else if ($totalImagensEnviadas == 1) {
				$textoEnvios = $totalImagensEnviadas . " Imagem enviada";
			} else {
				$textoEnvios = $totalImagensEnviadas . " Imagens enviadas";
			}
			?>
			<h1 class="texto-sessao"><i class="fa fa-image azul"></i> <?php echo $textoEnvios; ?></h1>
			<div class="profile-sessao-envios">
				<ul id="profile-usuario-imagens" class="sessao-recentes-lista">
					<!-- Imagens enviadas -->
					<img id="loading" src="/resources/loading.svg" draggable="false">
				</ul>
			</div>
		</div>
	</div>
	<!-- Visualização de imagens -->
	<div id="visualizacao-fundo" class="visualizacao-fundo">
		<a href="#/">
			<i id="visualizacao-fechar" onclick="desativarVisualizacaoImagem();" class="fa fa-times"></i>
		</a>
		<div class="visualizacao-imagem-container">
			<img id="visualizacao-imagem">
		</div>
	</div>
	<script src="/js/phpgallery.js"></script>
	<script>
		obterImagensUsuario("<?php echo $usuario->nome; ?>", "#profile-usuario-imagens");
	</script>
<?php } else { ?>
	<?php header("Status: 404", true, 404); ?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<h1 class="texto-sessao vermelho codigohttp">404</h1>
			<h2 class="texto normal">O usuário que você estava procurando não foi encontrado... :(</h2>
		</div>
	</div>
<?php } ?>
<script src="/js/phpgallery.js"></script>
</body>
</html>