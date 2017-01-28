<?php
	include_once "header.php";
	include_once "database/database.php";

	$erro = false;
	$imgId = null;
	$img = null;
	$imgAutor = null;

	//Pedido GET com query id?
	if (isset($_GET["id"])) {
		try {
			$imgId = intval($_GET["id"]);

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
			<img class="imagem-full" src="<?php echo $img->imagem_url(); ?>">
			<p class="texto normal"><?php echo $img->descricao; ?></p>
			<div class="view-usuario-container">
				<a href="profile.php?u=<?php echo $imgAutor->nome; ?>">
					<img draggable="false" class="usuario-imagem" src="<?php echo $imgAutor->imagem_url(); ?>">
					<p class="usuario-nome"><?php echo $imgAutor->nome; ?></p>
				</a>
			</div>
		</div>
	</div>
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
</body>
</html>