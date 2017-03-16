<?php
namespace PHPGallery;

require_once "WebInterface/Resposta.php";
require_once "WebInterface/Pedido.php";
require_once "DatabaseInterface/DatabaseErroDefinicoes.php";

use PHPGallery\WebInterface\Resposta;
use PHPGallery\WebInterface\Pedido;
use PHPGallery\DatabaseInterface\DatabaseErroDefinicoes;

Resposta::status(500);

$codigo = intval(Pedido::obter("err", "GET"));
$codigo_desconhecido = false;

if (isset(DatabaseErroDefinicoes::$database_erros[$codigo])) {
	$mensagem = DatabaseErroDefinicoes::$database_erros[$codigo];
} else {
	$mensagem = DatabaseErroDefinicoes::$database_erros[DE_DESCONHECIDO];
	$codigo_desconhecido = true;
}

require_once "WebInterface/cabecalho.php";
require_once "WebInterface/cabecalho_sessao.php";
require_once "WebInterface/online_status.php";
require_once "WebInterface/cabecalho_corpo.php";

/**
 * TODO: Fazer o design completo da página de erro de banco de dados
 * PST: Receberá um argumento GET ?err=int, dependendo do código de erro
 * mostre sua definição utilizando a classe DatabaseErroDefinicoes
 */

/**
 * Ainda utilizando a classe de erro-notfound para poder utilizar o design da "tela azul"!
 */

?>
	<main class="erro-notfound">
		<div class="conteudo-erro-notfound">
			<span class="erro-titulo">:(</span>
			<br>
			<span class="erro-descricao">Algo parece ter dado muito errado por aqui, por favor contate o administrador ou responsável pela aplicação. Aqui está um link para à <a href="/" class="link link-azul">página principal</a>.</span>
			<br>
			<span class="erro-descricao">Código de erro <?php echo (!$codigo_desconhecido) ? $codigo . ", " : "desconhecido(0), "; echo $mensagem; ?></span>
			<br>
			<span class="erro-descricao">500 Internal Server Error (DE_ERRO)</span>
		</div>
	</main>
<?php
require_once "WebInterface/rodape.php";
?>
