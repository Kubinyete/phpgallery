<?php
	define("CABECALHO_TITULO", "PHPGallery - Imagem");
	require_once "header.php";

	$erro = false;
	$imgId = null;
	$img = null;
	$imgAutor = null;
	$comentarioErro = false;
	$conteudo = "";

	//Pedido GET com query id?
	if (isset($_GET["id"])) {
		try {
			//Meio inútil, pois intval nunca irá soltar uma Exception
			$imgId = intval($_GET["id"]);

			//Porém, se intval falhar, o valor retornado será 0, então vamos soltar uma nova Exception
			if ($imgId < 1) {
				throw new Exception();
			}
		} catch (Exception $e) {
			$erro = true;
		} finally {
			if (!$erro) {
				$db = new Database();
				$atualImg = $db->obter_imagem($imgId);

				if ($atualImg !== null) {
					$img = $atualImg;
					//Obtendo o usuário autor da imagem para que possamos mostrar sua imagem de perfil e nome
					$imgAutor = $db->obter_usuario($img->autor);
					//Vamos utilizar os metodos da API para substituir os atributos por versões filtradas
					//Poderiamos ter utilizado os métodos titulo_formatado() & descricao_formatada() tambêm
					$img->gerar_titulo_formatado();
					$img->gerar_descricao_formatada();

					//Se o usuário enviou um pedido POST, é para adicionar um comentário
					if ($_SERVER["REQUEST_METHOD"] === "POST") {
						if (isset($_POST["conteudo"])) {
							if ($_SESSION["usuario"] !== null) {
								$comentarioAutor = $_SESSION["usuario"];
								$conteudo = $_POST["conteudo"];

								$dbComentario = new Comentario($img->id, $conteudo, $comentarioAutor->nome);

								if (conteudo_comentario_valido($dbComentario->conteudo) !== false) {
									//Vamos adicionar o comentário
									$db->adicionar_comentario($dbComentario);
								} else {
									$comentarioErro = "O comentário enviado estava em um formato inválido.";
								}
							} else {
								$comentarioErro = "É preciso estar logado para poder adicionar comentários.";
							}
						}
					}
				}

				$db->finalizar();
			}
		}
	}
?>

<?php if ($img !== null) { ?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<h1 class="texto-sessao"><i class="fa fa-image azul"></i> <?php echo $img->titulo; ?></h1>
			<img id="imagem-full" class="imagem-full" src="<?php echo $img->imagem_url(); ?>">
			<p class="texto normal view-imagem-descricao"><?php echo $img->descricao; ?></p>
			<p class="texto-descricao view-imagem-data"><i class="fa fa-calendar azul"></i> Enviado em <?php echo $img->data_criacao(); ?></p>
			<a class="link" href="download.php?id=<?php echo $img->id; ?>">
			<div class="download-caixa">
				<p class="texto descricao"><i class="fa fa-download azul"></i> Download</p>
			</div>
			</a>
			<div class="view-usuario-container">
				<a href="profile.php?u=<?php echo $imgAutor->nome; ?>">
					<img draggable="false" class="usuario-imagem" src="<?php echo $imgAutor->imagem_url(); ?>">
					<p class="usuario-nome"><?php echo $imgAutor->nome; ?></p>
				</a>
			</div>
		</div>
		<br>
		<div class="conteudo-comentarios">
			<h1 id="comentarios-texto-sessao" class="texto texto-sessao">Comentários <button id="botao-atualiza-comentarios" class="botao" onclick="atualizarComentarios(<?php echo $img->id; ?>)">Atualizar</button></h1>
			<ul id="comentarios-lista" class="comentarios-lista">
				<!-- Comentários -->
				<img id="loading" src="/resources/loading.svg" draggable="false">
			</ul>
			<h1 class="texto texto-sessao">Adicionar comentário</h1>
			<div class="comentario-form-container">
				<form method="POST" action="view.php?id=<?php echo $img->id; ?>" autocomplete="off">
					<span class="texto descricao" id="chars-restantes-comentario"></span>
					<textarea placeholder="Escreva algo aqui..." id="comentario-conteudo" maxlength="150" class="texto normal texto-area" name="conteudo"></textarea>
					<br>
					<button class="botao" type="submit">Enviar</button>
				</form>
			</div>
		</div>
	</div>
	<?php if ($comentarioErro !== false) { ?>
	<div class="erro-fundo">
		<div class="erro">
			<h1>Erro</h1>
			<p class="normal"><?php echo $comentarioErro; ?></p>
			<button onclick="desativarErro();" class="botao">Ok</button>
		</div>
	</div>
	<?php } ?>
<?php } else { ?>
	<?php header("Status: 404", true, 404); ?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<h1 class="texto-sessao vermelho codigohttp">404</h1>
			<h2 class="texto normal">A imagem que você estava procurando não foi encontrada... :(</h2>
		</div>
	</div>
<?php } ?>
<script src="/js/phpgallery.js"></script>
<?php if ($img !== null) { ?>
<script>
	//Animação cabeçalho
	$("#cabecalho-fundo").css("background-image", "url(" + $("#imagem-full").attr("src") + ")");
	$("#cabecalho-fundo").addClass("blur-x2");
	$("#cabecalho-fundo").addClass("meia-opacidade");

	//Comentários
	atualizarComentarios("<?php echo $img->id; ?>");

	//Formulário
	adicionarContadorCaracteres("#comentario-conteudo", "#chars-restantes-comentario");
</script>
<?php } ?>
</body>
</html>