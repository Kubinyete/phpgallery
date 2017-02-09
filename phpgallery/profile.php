<?php
	define("CABECALHO_TITULO", "PHPGallery - Perfil");
	require_once "header.php";

	$erro = false;
	$usuario = null;
	$nome = null;
	$totalImagensEnviadas = 0;
	$mostrarForm = false;
	$mensagem = false;

	//Vamos visualizar o perfil de algum usuário
	if (isset($_GET["u"])) {
		$nome = $_GET["u"];

		$db = new Database();
		$usuario = $db->obter_usuario($nome);

		if ($usuario !== null) {
			$totalImagensEnviadas = $db->obter_numero_imagens($nome);
			if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]->nome === $usuario->nome) {
				$mostrarForm = true;
			}
		}

		$db->finalizar();

	} else {
		//Vamos visualizar o nosso próprio perfil
		$usuario = $_SESSION["usuario"];

		if ($usuario !== null) {
			$db = new Database();
			$totalImagensEnviadas = $db->obter_numero_imagens($usuario->nome);
			$db->finalizar();
			$mostrarForm = true;
		}
	}

	//Vamos modificar a imagem & descrição do usuário
	if ($_SERVER["REQUEST_METHOD"] === "POST" && $mostrarForm) {
		if (isset($_POST["descricao"])) {
			$descricao = $_POST["descricao"];

			$descricao = trim($descricao);
			if ($descricao !== $usuario->descricao) {
				$db = new Database();
				$db->atualizar_descricao($usuario->id, $descricao);
				//Vamos atualizar nosso objeto de usuário novamente
				$usuario = $db->obter_usuario($usuario->nome);
				$db->finalizar();
			}
		}

		if (isset($_FILES["imagem"]) && $_FILES["imagem"]["name"] !== "") {
			try {
				//Se o arquivo temporário não foi alocado temporáriamente
				if ($_FILES["imagem"]["tmp_name"] === "") {
					if ($_FILES["imagem"]["error"] === 1) {
						$mensagem = "A imagem excede o tamanho limite de 4 megabytes.";
					} else {
						$mensagem = "Ocorreu um erro ao processar a imagem, código: " . $_FILES["imagem"]["error"];
					}
					throw new Exception();
				}

				$informacoes = getimagesize($_FILES["imagem"]["tmp_name"]);

				if (!isset($informacoes[0]) || !isset($informacoes[1]) || !isset($informacoes[2])) {
					$mensagem = "O arquivo a ser processado não é uma imagem.";
					throw new Exception();
				}

				$largura = $informacoes[0];
				$altura = $informacoes[1];
				$tipo = $informacoes[2];

				if ($largura > 200) {
					$mensagem = "A largura da imagem ultrapassou o limite de 200x200";
					throw new Exception();
				}
				else if ($altura > 200) {
					$mensagem = "A altura da imagem ultrapassou o limite de 200x200";
					throw new Exception();
				}

				switch ($tipo) {
					case IMAGETYPE_JPEG:
						//Tudo está pronto, apenas mova o arquivo
						move_uploaded_file($_FILES["imagem"]["tmp_name"], UPLOAD_USUARIO_IMAGEM_DESTINO . $usuario->nome_md5_hash() . IMAGENS_USUARIO_EXT);
						break;
					case IMAGETYPE_PNG:
						//Vamos transformá-la em JPEG
						$imagemPng = imagecreatefrompng($_FILES["imagem"]["tmp_name"]);
						if (!imagejpeg($imagemPng, UPLOAD_USUARIO_IMAGEM_DESTINO . $usuario->nome_md5_hash() . IMAGENS_USUARIO_EXT)) {
							$mensagem = "Ocorreu um erro ao tentar converter sua imagem para JPEG.";
							throw new Exception();
						}
						break;
					default:
						$mensagem = "A imagem enviada estava em um formato inválido.";
						throw new Exception();
				}

				$mensagem = "A imagem foi atualizada com sucesso, talvez seja necessário esperar um tempo para que as mudanças tenham efeito.";

				//Caso o usuário não tem uma imagem ainda, precisamos atualizar seu objeto no banco de dados
				if (!$usuario->temImagem) {
					$db = new Database();
					$db->atualizar_usuario_tem_imagem($usuario->id, 1);
					$usuario = $db->obter_usuario($usuario->nome);
					$db->finalizar();
					echo '<script>$(".usuario-container .usuario-imagem").attr("src", "' . $usuario->imagem_url() . '");</script>';
				}

			} catch (Exception $e) {}
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
				$textoEnvios = "Recentes / " . $totalImagensEnviadas . " Imagem enviada";
			} else {
				$textoEnvios = "Recentes / " . $totalImagensEnviadas . " Imagens enviadas";
			}
			?>
			<h1 class="texto-sessao"><i class="fa fa-image azul"></i> <?php echo $textoEnvios; ?></h1>
			<div class="profile-sessao-envios">
				<ul id="profile-usuario-imagens" class="sessao-recentes-lista">
					<!-- Imagens enviadas -->
					<img id="loading" src="/resources/loading.svg" draggable="false">
				</ul>
			</div>
			<?php if ($mostrarForm) { ?>
			<h1 class="texto-sessao">Suas informações</h1>
			<div class="profile-formulario">
				<form method="POST" action="profile.php" enctype="multipart/form-data" autocomplete="off">
					<div class="profile-formulario-imagem">
						<p class="texto azul profile-formulario-texto">Imagem</p>
						<img class="usuario-imagem" draggable="false" src="<?php echo $usuario->imagem_url(); ?>">
						<br>
						<div class="input-imagem-container">
							<input class="input-imagem" type="file" name="imagem" accept="image/*">
						</div>
					</div>
					<div class="profile-formulario-descricao">
						<p class="texto azul profile-formulario-texto">Descrição</p>
						<textarea placeholder="Nenhuma descrição está disponível." name="descricao" class="texto normal texto-area"><?php echo htmlspecialchars($usuario->descricao); ?></textarea>
					</div>
					<div class="profile-formulario-botao-container">
						<button class="botao" type="submit">Atualizar</button>
					</div>
				</form>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- Visualização de imagens -->
	<div id="visualizacao-fundo" class="visualizacao-fundo">
		<a href="#/">
			<i id="visualizacao-fechar" onclick="desativarVisualizacaoImagem();" class="fa fa-times"></i>
		</a>
		<div class="visualizacao-imagem-container">
			<img id="visualizacao-imagem" src="/resources/loading.svg">
		</div>
	</div>
	<?php if ($mensagem !== false) { ?>
	<div class="erro-fundo">
		<div class="erro">
			<h1>Aviso</h1>
			<p class="normal"><?php echo $mensagem; ?></p>
			<button onclick="desativarErro();" class="botao">Ok</button>
		</div>
	</div>
	<?php } ?>
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
	<script src="/js/phpgallery.js"></script>
<?php } ?>
</body>
</html>