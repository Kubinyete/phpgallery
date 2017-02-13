<?php
	require_once "database/database.php";

	//Inicio de uma página que necessita de sessão (o objeto do usuário)

	session_start();

	$usuario = null;
	$titulo = "phpgallery";

	if (defined("CABECALHO_TITULO")) {
		$titulo = CABECALHO_TITULO;
	}

	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];

		//Verificando se o usuário ainda está válido

		$db = new Database();
		$novoUsuario = $db->obter_usuario($usuario->nome);
		$db->finalizar();

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
			exit();
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
	<title><?php echo $titulo; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed|Ubuntu+Mono" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/phpgallery.styles.css" rel="stylesheet">
	<script src="/js/jquery-3.1.1.min.js"></script>
</head>
<body>
	<header>
		<div class="cabecalho-container">
			<div id="cabecalho-fundo" class="cabecalho-fundo">
			</div>
			<div class="cabecalho-centro-container">
				<div class="cabecalho-centro-logo">
					<a class="link" href="home.php">
						<img alt="PHPGallery" title="PHPGallery" src="/resources/phpgallery-logo.png" draggable="false">
					</a>
				</div>
				<!-- Menu -->
				<div id="cabecalho-botao-container" class="cabecalho-botao-container">
					<a id="menu-botao" class="link" href="#/"><i class="fa fa-bars"></i></a>
				</div>
				<?php if ($usuario !== null) { ?>
				<!-- Informações do usuário -->
				<a class="link" href="profile.php">
				<div class="usuario-container">
					<p class="usuario-nome"><?php echo $usuario->nome; ?></p>
					<img alt="Imagem de perfil do usuário" class="usuario-imagem" src="<?php echo $usuario->imagem_url(); ?>" draggable="false">
				</div>
				</a>
				<?php } ?>
			</div>
		</div>
		<nav>
			<?php if ($usuario === null) { ?>
			<!-- Menu anônimo -->
			<div id="usr-menu-container" class="usr-menu-container">
				<ul class="usr-menu-lista">
					<li class="usr-menu-item">
						<a class="link" href="login.php"><p class="usr-menu-item-texto"><i class="fa fa-sign-in azul"></i> Login</p></a>
					</li>
				</ul>
			</div>
			<?php } else { ?>
			<!-- Menu logado -->
			<div id="usr-menu-container" class="usr-menu-container">
				<ul class="usr-menu-lista">
					<li class="usr-menu-item">
						<a class="link" href="upload.php"><p class="usr-menu-item-texto"><i class="fa fa-upload azul"></i> Enviar</p></a>
					</li>
					<li class="usr-menu-item">
						<a class="link" href="profile.php"><p class="usr-menu-item-texto"><i class="fa fa-user azul"></i> Perfil</p></a>
					</li>
					<li class="usr-menu-item">
						<a class="link" href="logoff.php"><p class="usr-menu-item-texto"><i class="fa fa-sign-out azul"></i> Sair</p></a>
					</li>
				</ul>
			</div>
			<?php } ?>
		</nav>
	</header>