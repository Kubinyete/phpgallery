<?php
	require_once "database/objects.php";
	require_once "database/database.php";

	//Inicio de uma página que necessita de sessão (o objeto do usuário)

	session_start();

	$usuario = null;

	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];

		//Verificando se o usuário ainda está válido

		$db = new Database();
		$novoUsuario = $db->obter_usuario($usuario->nome);

		$invalido = false;
		if ($novoUsuario !== null) {
			//Vamos ver se as credenciais da nossa sessão e do banco de dados ainda batem
			if (!$usuario->senha === $novoUsuario->senha) {
				$invalido = true;
			} else {
				//Vamos atualizar nosso objeto de usuário na sessão, para previnir qualquer mudança
				$_SESSION["usuario"] = $novoUsuario;
				//Vamos atualizar nosso usuário local para a correta visualização deste header
				$usuario = $_SESSION["usuario"];
			}
		} else {
			//O usuário nem está no banco de dados, volte a página de login e destrua a sessão antiga
			$invalido = true;
		}

		if ($invalido) {
			$_SESSION["usuario"] = null;
			header("Refresh: 0; url=login.php", true);
		}
	} else {
		$_SESSION["usuario"] = null;
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHPGallery</title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed|Ubuntu+Mono" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/phpgallery.styles.css" rel="stylesheet">
	<script src="/js/jquery-3.1.1.min.js"></script>
</head>
<body>
	<div class="cabecalho-container">
		<div class="cabecalho-centro-container">
			<div class="cabecalho-centro-logo">
				<a class="link" href="home.php">
					<img src="/resources/phpgallery-logo.png" draggable="false">
				</a>
			</div>
			<!-- Menu -->
			<div id="cabecalho-botao-container" class="cabecalho-botao-container">
				<a id="menu-botao" class="link" href="#/"><i class="fa fa-bars"></i></a>
			</div>
			<?php if ($usuario !== null) { ?>
			<!-- Informações do usuário -->
			<div class="usuario-container">
				<a class="link" href="profile.php">
				<p class="usuario-nome"><?php echo $usuario->nome; ?></p>
				<img class="usuario-imagem" src="<?php echo $usuario->imagem_url(); ?>" draggable="false">
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php if ($usuario === null) { ?>
	<!-- Menu anônimo -->
	<div id="usr-menu-container" class="usr-menu-container">
		<ul class="usr-menu-lista">
			<li class="usr-menu-item">
				<a class="link" href="login.php"><p class="usr-menu-item-texto">Login</p></a>
			</li>
		</ul>
	</div>
	<?php } else { ?>
	<!-- Menu logado -->
	<div id="usr-menu-container" class="usr-menu-container">
		<ul class="usr-menu-lista">
			<li class="usr-menu-item">
				<a class="link" href="upload.php"><p class="usr-menu-item-texto">Enviar</p></a>
			</li>
			<li class="usr-menu-item">
				<a class="link" href="profile.php"><p class="usr-menu-item-texto">Perfil</p></a>
			</li>
			<li class="usr-menu-item">
				<a class="link" href="logoff.php"><p class="usr-menu-item-texto">Sair</p></a>
			</li>
		</ul>
	</div>
	<?php } ?>
	<script>
		//Lógica de ativação de desativação do menu de opções
		var menuAtivado = false; 

		function menu() {
			if (!menuAtivado) {
				$("#usr-menu-container").addClass("ativado");
				$("#usr-menu-container").addClass("menu-ativado");
				$("#cabecalho-botao-container").addClass("cabecalho-botao-container-ativado");
				menuAtivado = true;
			} else {
				$("#usr-menu-container").removeClass("menu-ativado");
				$("#usr-menu-container").removeClass("ativado");
				$("#cabecalho-botao-container").removeClass("cabecalho-botao-container-ativado");
				menuAtivado = false; 
			}
		}

		//Ao clicar, vamos executar a ação do menu
		$("#menu-botao").click(menu);
	</script>