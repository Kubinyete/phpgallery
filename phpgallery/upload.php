<?php
	include_once "database/database.php";
	include_once "database/objects.php";
	include_once "header.php";

	define("IMAGENS_DESTINO", "?");

	$erro = false;
	$loginErro = false;
	$imagem = null;
	$imagemTitulo = "";
	$imagemDescricao = "";
	$imagemPrivado = false;
	$imagemExt = null;

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		//Primeiro vamos obter nosso autor
		$usuario = $_SESSION["usuario"];

		if ($usuario !== null) {
			//Vamos tentar obter a imagem
			//O usuário está usando um form que contêm imagem
			if (!isset($_FILES["imagem"])) {
				$erro = "É preciso enviar uma imagem.";
			} else {
				//Mesmo que um erro aconteça, quero re-exibir a página com as informações preenchidas anteriormente
				if (isset($_POST["titulo"])) {
					$imagemTitulo = $_POST["titulo"];
				}
				if (isset($_POST["descricao"])) {
					$imagemDescricao = $_POST["descricao"];
				}
				if (isset($_POST["privado"])) {
					$imagemPrivado = ($_POST["privado"] === "on") ? : $_POST["privado"];
				}

				//Filtrando a imagem
				try {
					//Se o arquivo temporário foi recebido
					if ($_FILES["imagem"]["tmp_name"] === "") {
						if ($_FILES["imagem"]["name"] === "") {
							$erro = "É preciso enviar uma imagem.";
						} else if ($_FILES["imagem"]["error"] === 1){
							$erro = "A imagem excede o tamanho limite de 4 megabytes.";
						} else {
							$erro = "Ocorreu um erro ao processar a imagem, código: " . $_FILES["imagem"]["error"];
						}
						throw new Exception();
					}

					//Obtendo informações
					$informacoes = getimagesize($_FILES["imagem"]["tmp_name"]);

					if (!isset($informacoes[2])) {
						$erro = "O arquivo processado não é uma imagem.";
						throw new Exception();
					}

					//Vamos verificar agora o formato
					switch ($informacoes[2]) {
						case IMAGETYPE_GIF:
							$imagemExt = ".gif";
							break;
						case IMAGETYPE_JPEG:
							$imagemExt = ".jpg";
							break;
						case IMAGETYPE_PNG:
							$imagemExt = ".png";
							break;
						default:
							$erro = "A imagem não estava em um formato esperado, [GIF, JPG ou PNG].";
							throw new Exception();
					}

					$novaImagem = new Imagem($imagemTitulo, $imagemDescricao, $imagemPrivado, $imagemExt, $usuario->nome);

					$db = new Database();
					$dbImagem = $db->adicionar_imagem($novaImagem);
					$db->finalizar();

					if ($dbImagem !== null) {
						$ok = move_uploaded_file($_FILES["imagem"]["tmp_name"], IMAGENS_DESTINO . $dbImagem->id_md5_hash() . $dbImagem->ext);
						if ($ok) {
							header("Refresh: 0; url=view.php?id=" . $dbImagem->id, true);
						} else {
							$erro = "Não foi possível armazenar a imagem em disco.";
						}
					} else {
						$erro = "Ocorreu um erro interno ao tentar adicionar a imagem ao banco de dados.";
					}
				} catch (Exception $e) { }
			}
		} else {
			$erro = "É preciso estar logado para poder enviar imagens...";
			$loginErro = true;
		}
	}
?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<?php if (!$loginErro) { ?>
			<h1 class="texto-sessao">Enviar uma imagem</h1>
			<div class="upload-sessao-container">
				<form method="POST" action="upload.php" enctype="multipart/form-data" autocomplete="off">
					<div class="input-imagem-container">
						<input class="texto normal input-imagem" type="file" accept="image/*" name="imagem">
					</div>
					<br>
					<label class="texto azul">Título</label>
					<input id="titulo" class="texto normal campo" type="text" maxlength="64" name="titulo" value="<?php echo htmlspecialchars($imagemTitulo); ?>">
					<span id="titulo-chars-restantes" class="texto normal"></span>
					<br>
					<br>
					<label class="texto azul">Descrição</label>
					<span id="chars-restantes" class="texto normal"></span>
					<br>
					<textarea id="descricao" class="texto normal" maxlength="150" name="descricao"><?php echo htmlspecialchars($imagemDescricao); ?></textarea>
					<br>
					<input type="checkbox" <?php echo ($imagemPrivado) ? "checked" : ""; ?> name="privado">
					<label class="texto normal">Imagem privada</label>
					<div class="texto-centro">
						<button type="submit" class="botao">Enviar</button>
					</div>
				</form>
			</div>
			<?php if ($erro !== false) { ?>
			<div class="erro-fundo">
				<div class="erro">
					<h1>Erro</h1>
					<p class="normal"><?php echo $erro; ?></p>
					<button onclick="desativarErro();" class="botao">Ok</button>
				</div>
			</div>
			<?php } ?>
			<?php } else { ?>
			<?php header("Status: 401", true, 401); ?>
			<h1 class="texto-sessao vermelho codigohttp">401</h1>
			<h2 class="texto normal"><?php echo $erro; ?></p>
			<?php } ?>
		</div>
	</div>
<script src="/js/phpgallery.js"></script>
<script>
	//Ativando nossos contadores de carácteres
	adicionarContadorCaracteres("#titulo", "#titulo-chars-restantes");
	adicionarContadorCaracteres("#descricao", "#chars-restantes");
</script>
</body>
</html>
