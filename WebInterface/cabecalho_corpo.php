<?php
/**
 * Corpo do cabeçalho em body (header)
 */

namespace PHPGallery\WebInterface;

// Se não incluimos a sessão ainda, inclua agora, pois será necessário para obter informações do usuário
// logado atualmente
require_once "cabecalho_sessao.php";
require_once "Referencias.php";

$usuario_logado = Sessao::get_usuario();
$usuario_esta_online = false;
if ($usuario_logado !== null) {
	$usuario_esta_online = $usuario_logado->esta_online();
}
/**
 * v -> Visualização da página atual
 * Ex: ?v=usuario, ?v=procurar_imagem, ?v=sobre
 * s -> Primeiro argumento a ser passado, no caso de uma busca esta string seria necessária no pedido GET
 * Ex: ?v=procurar_usuario&s=vitor
 */

?>
	<header class="cabecalho">
		<a href="?v=home" class="link">
			<img id="cabecalho-logo" draggable="false" src="/static/recursos/phpgallery/phpgallery-logo.png" alt="Logo da aplicação">
		</a>
		<!-- Navegação principal -->
		<nav class="cabecalho-nav">
			<ul class="cabecalho-links-lista">
				<li>
					<a href="?v=home" class="link">Home</a>
				</li>
				<li>
					<a href="?v=perfil" class="link">Perfil</a>
				</li>
				<li>
					<a href="?v=enviar" class="link">Enviar</a>
				</li>
			</ul>
		</nav>
		<!-- Pesquisa de imagens -->
		<form id="cabecalho-pesquisa" method="GET" autocomplete="off">
			<input type="hidden" name="v" value="procurar">
			<input type="text" name="s" placeholder="Pesquisar">
			<i class="fa fa-search"></i>
		</form>
		<?php if ($usuario_logado !== null) { ?>

		<!-- Usuário Container -->
		<div class="cabecalho-usuario-container">
			<!-- Imagem de perfil do usuário logado -->
			<a href="?v=perfil" class="link">
				<img class="imagem-perfil" draggable="false" src="<?php echo $usuario_logado->obter_imagem_url(); ?>" alt="Sua imagem de perfil">
				<div class="cabecalho-usuario-nome-container">
					<!-- Nome do usuário logado -->
					<span><?php echo $usuario_logado->get_nome(); ?></span>
				</div>
			</a>
			<a href="#/" class="link" onclick="phpgallery.menuUsuario();">
				<div class="cabecalho-usuario-btnopcoes-container">
					<!-- Botão para abrir o menu de opções do usuário -->
					<i class="fa fa-arrow-down"></i>
				</div>
			</a>
		</div>

		<?php } else { ?>

		<!-- Link para a página de login -->
		<a class="link link-pagina-login" href="?v=login">Efetue login ou registre-se</a>

		<?php } ?>
	</header>
	<?php if ($usuario_logado !== null) { ?>
	<div class="usuario-menu">
		<ul>
			<a class="link" href="?v=login&amp;l=1">
				<li><i class="fa fa-sign-out"></i> Sair</li>
			</a>
		</ul>
	</div>
	<?php } ?>
	<!-- Segundo header físico -->
	<div class="imagem-showcase">
		<div class="imagem-showcase-container">
			<div class="imagem-showcase-imagem"></div>
			<span id="imagem-showcase-titulo"><span class="azul-negrito">PHP</span>Gallery<span class="azul-negrito versao">v<?php echo Referencias::$phpgallery_versao; ?></span></span>
		</div>
		<div class="imagem-showcase-gradient"></div>
	</div>