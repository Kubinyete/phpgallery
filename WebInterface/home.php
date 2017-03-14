<?php
/**
 * Página home
 */

namespace PHPGallery\WebInterface;

require_once "Referencias.php";

set_include_path("..");
require_once "DatabaseInterface/Conexao.php";
require_once "DatabaseInterface/DatabaseImagem.php";
require_once "DatabaseInterface/DatabaseUsuario.php";
require_once "DatabaseInterface/DatabaseComentario.php";

use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\DatabaseInterface\DatabaseALImagem;
use PHPGallery\DatabaseInterface\DatabaseALUsuario;
use PHPGallery\DatabaseInterface\DatabaseALComentario;

$conexao = new Conexao();

$dal = new DatabaseALImagem($conexao);
$imagens = $dal->obter_recentes();
$database_total_imagens = $dal->obter_contagem_imagens();

$contagem_imagens = count($imagens);

$dal = new DatabaseALUsuario($conexao);
$database_total_usuarios = $dal->obter_contagem_usuarios();

if ($contagem_imagens > 0) {
	foreach ($imagens as $imagem) {
		$imagem->autor = $dal->obter_usuario($imagem->get_usr_id());
	}
}

$dal = new DatabaseALComentario($conexao);
$database_total_comentarios = $dal->obter_contagem_comentarios();

?>
	<main>
		<div class="conteudo-divisao">
			<i class="conteudo-divisao-icone fa fa-clock-o"></i>
			<h1>Recentes</h1>
		</div>
		<div class="conteudo">
			<ul class="lista-imagens">
				<?php
					if ($contagem_imagens > 0) {
						foreach ($imagens as $imagem) {
							?>
							<script>
								phpgallery.imagens.adicionarImagem(<?php echo $imagem->get_id(); ?>, '<?php echo $imagem->obter_imagem_url(); ?>', '<?php echo $imagem->get_titulo(true) ?>');
							</script>
							<li>
								<a class="link" href="?v=imagem&id=<?php echo $imagem->get_id(); ?>">
									<div class="lista-imagem-container">
										<div class="lista-imagem-imagem" style="background-image: url(<?php echo $imagem->obter_imagem_url(); ?>)"></div>
										<div class="lista-imagem-gradient">
											<span class="lista-imagem-titulo"><?php echo $imagem->get_titulo(true); ?></span>
										</div>
									</div>
								</a>
								<div class="lista-opcoes-container">
									<a class="link" href="?v=download&id=<?php echo $imagem->get_id(); ?>">
										<button class="lista-opcoes-botao baixar">
											<i class="fa fa-download"></i>
										</button>
									</a>
									<button class="lista-opcoes-botao visualizar" onclick="phpgallery.visualizarImagem(<?php echo $imagem->get_id(); ?>);">
										<i class="fa fa-arrows-alt"></i>
									</button>
								</div>
								<span class="lista-imagem-caixa-descricao">Descrição: <?php echo $imagem->get_descricao(true); ?><br>Extensão: <span class="extensao"><?php echo $imagem->get_extensao(true); ?></span><br>Autor: <a class="link" href="?v=perfil&u=<?php echo $imagem->autor->get_nome(); ?>"><span class="autor"><?php echo $imagem->autor->get_nome(); ?></span></a></span>
							</li>
							<?php 
						}
					} else {
				?>
				<p class="lista-imagens-mensagem">Nenhuma imagem adicionada até o momento, começe agora mesmo à adicionar imagens utilizando à página de envio.</p>
				<?php } ?>
			</ul>
		</div>
		<div class="conteudo-divisao">
			<i class="conteudo-divisao-icone fa fa-database"></i>
			<h1>Status</h1>
		</div>
		<div class="conteudo">
			<p class="status"><span style="<?php if ($database_total_imagens <= 0) echo 'color: #ff0033'; ?>"><?php echo $database_total_imagens; ?></span> <?php if ($database_total_imagens == 1) { echo "Imagem adicionada..."; } else { echo "Imagens adicionadas..."; } ?></p> 
			<p class="status"><span style="<?php if ($database_total_usuarios <= 0) echo 'color: #ff0033'; ?>"><?php echo $database_total_usuarios; ?></span> <?php if ($database_total_usuarios == 1) { echo "Usuário registrado..."; } else { echo "Usuários registrados..."; } ?></p> 
			<p class="status"><span style="<?php if ($database_total_comentarios <= 0) echo 'color: #ff0033'; ?>"><?php echo $database_total_comentarios; ?></span> <?php if ($database_total_comentarios == 1) { echo "Comentário criado..."; } else { echo "Comentários criados..."; } ?></p> 
		</div>
	</main>