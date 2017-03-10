<?php
/**
 * Página home
 */

namespace PHPGallery\WebInterface;

set_include_path("..");
require_once "DatabaseInterface/Conexao.php";
require_once "DatabaseInterface/DatabaseImagem.php";
require_once "DatabaseInterface/DatabaseUsuario.php";

use PHPGallery\DatabaseInterface\Conexao;
use PHPGallery\DatabaseInterface\DatabaseALImagem;
use PHPGallery\DatabaseInterface\DatabaseALUsuario;

$conexao = new Conexao();

$dal = new DatabaseALImagem($conexao);
$imagens = $dal->obter_recentes();

$contagem_imagens = count($imagens);

if ($contagem_imagens > 0) {
	$dal = new DatabaseALUsuario($conexao);
	foreach ($imagens as $imagem) {
		$imagem->nome_autor = $dal->obter_usuario($imagem->get_usr_id());
	}
}

?>
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
							<li>
								<div class="lista-imagem-container">
									<div class="lista-imagem-imagem" style="background-image: url(<?php echo $imagem->obter_imagem_url(); ?>)"></div>
								</div>
								<div class="lista-opcoes-container">
									<button class="lista-opcoes-botao baixar">
										<i class="fa fa-download"></i>
									</button>
									<button class="lista-opcoes-botao visualizar">
										<i class="fa fa-arrows-alt"></i>
									</button>
								</div>
							</li>
							<?php 
						}
					} else {
				?>
				<p>Nenhuma imagem adicionada até o momento, começe agora mesmo à adicionar imagens utilizando à página de envio.</p>
				<?php } ?>
			</ul>
		</div>
