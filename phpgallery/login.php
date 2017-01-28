<?php
	require_once "database/database.php";
	require_once "database/objects.php";
	include_once "header.php";

	//Retorna se o campo informado é valido para efetuar login / registrar-se
	function campo_valido($string) {
		$retorno = true;

		for ($i = 0; $i < strlen($string); $i++) {
			if (ord($string[$i]) <= 47 || ord($string[$i]) >= 58 && ord($string[$i]) <= 64 || ord($string[$i]) >= 91 && ord($string[$i]) <= 96 || ord($string[$i]) >= 123) {
				$retorno = false;
			}
		}

		return $retorno;
	}

	//Se o usuário já está registrado, volte ele para a página principal
	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];

		if ($usuario !== null) {
			header("Refresh: 0; url=home.php", true);
		}
	}

	$erro = false;
	$nome = "";
	$senha = "";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$nome;
		$senha;

		if (!isset($_POST["nome"]) || !isset($_POST["senha"])) {
			$erro = "É preciso informar o nome e a senha do usuário.";
		} else {
			if (isset($_POST["login"]) && $_POST["login"] === "1") {
				//Vamos logar
				$nome = $_POST["nome"];
				$senha = $_POST["senha"];

				if (!campo_valido($nome) || !campo_valido($senha)) {
					$erro = "O nome de usuário ou senha contêm um caráctere inválido, é permitido apenas [0-9, a-z, A-Z].";
				} else {
					if (strlen($nome) < 6) {
						$erro = "O nome de usuário deve ter pelomenos 6 carácteres.";
					} else if (strlen($senha) < 6) {
						$erro = "A senha deve ter pelomenos 6 carácteres.";
					} else if (strlen($nome) > 16) {
						$erro = "O nome de usuário excede o máximo de 16 carácteres permitidos.";
					} else if (strlen($senha) > 32) {
						$erro = "A senha excede o máximo de 32 carácteres permitidos.";
					} else {
						$loginUsuario = new Usuario($nome, $senha);
						$db = new Database();
						$dbUsuario = $db->obter_usuario($loginUsuario->nome);
						$db->finalizar();

						if ($dbUsuario === null) {
							$erro = "O usuário informado não existe.";
						} else if ($dbUsuario->senha !== $loginUsuario->senha_md5_hash()) {
							$erro = "A senha informada está incorreta.";
						} else {
							$_SESSION["usuario"] = $dbUsuario;
							header("Refresh: 0; url=home.php", true);
						}
					}
				}
			} else if (isset($_POST["registrar"]) && $_POST["registrar"] === "1") {
				//Vamos registrar
				$nome = $_POST["nome"];
				$senha = $_POST["senha"];

				if (!campo_valido($nome) || !campo_valido($senha)) {
					$erro = "O nome de usuário ou senha contêm um caráctere inválido, é permitido apenas [0-9, a-z, A-Z].";
				} else {
					if (strlen($nome) < 6) {
						$erro = "O nome de usuário deve ter pelomenos 6 carácteres.";
					} else if (strlen($senha) < 6) {
						$erro = "A senha deve ter pelomenos 6 carácteres.";
					} else if (strlen($nome) > 16) {
						$erro = "O nome de usuário excede o máximo de 16 carácteres permitidos.";
					} else if (strlen($senha) > 32) {
						$erro = "A senha excede o máximo de 32 carácteres permitidos.";
					} else {
						$novoUsuario = new Usuario($nome, $senha);
						$db = new Database();
						$dbUsuario = $db->obter_usuario($novoUsuario->nome);

						if ($dbUsuario !== null) {
							$erro = "O usuário informado já existe.";
						} else {
							$novoUsuario->senha = $novoUsuario->senha_md5_hash();
							$db->registrar_usuario($novoUsuario);
							$dbUsuario = $db->obter_usuario($novoUsuario->nome);

							if ($dbUsuario !== null) {
								$_SESSION["usuario"] = $dbUsuario;
								header("Refresh: 0; url=home.php", true);
							} else {
								$erro = "Ocorreu um erro ao tentar registrar o usuário.";
							}
						}

						$db->finalizar();
					}
				}

			} else {
				//Parece que o usuário nem está utilizando o formulário direito, envie um erro
				$erro = "Ocorreu um erro ao tentar realizar o seu pedido.";
			}
		}
	}
?>
	<div class="conteudo">
		<div class="conteudo-centro">
			<h1 class="texto-sessao">Faça login ou registre-se</h1>
			<div class="login-container">
				<form method="POST" action="login.php" autocomplete="off">
					<label class="azul">Nome</label>
					<input class="campo" type="text" maxlength="16" name="nome" value="<?php echo htmlspecialchars($nome); ?>" placeholder="Nome">
					<br>
					<label class="azul">Senha</label>
					<input class="campo" type="password" maxlength="32" name="senha" value="<?php echo htmlspecialchars($senha); ?>" placeholder="Senha">
					<br>
					<button class="botao" type="submit" name="login" value="1">Login</button>
					<button class="botao" type="submit" name="registrar" value="1">Registrar</button>
				</form>
			</div>
		</div>
	</div>
	<?php if ($erro !== false) { ?>
	<?php header("Status: 400", true, 400); ?>
	<div class="erro-fundo">
		<div class="erro">
			<h1>Erro</h1>
			<p class="normal"><?php echo $erro; ?></p>
			<button onclick="desativarErro();" class="botao">Ok</button>
		</div>
	</div>
	<?php } ?>
<script src="/js/phpgallery.js"></script>
</body>
</html>