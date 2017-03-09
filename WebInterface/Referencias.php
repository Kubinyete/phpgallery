<?php
namespace PHPGallery\WebInterface;

/**
 * Classe estática responsável por guardar referências absolutas (valores padrões, links, nomes, etc)
 */
class Referencias {
	public static $html_site_titulo = "PHPGallery";
	public static $html_descricao_padrao = "Uma aplicação web que permite o envio e a hospedagem de imagens aos usuários registrados.";
	public static $html_palavras_chave_padrao = "galeria, imagens, envio, upload, wallpaper, php, captura de tela, widescreen, papel de parede";
	public static $html_autor_padrao = "Vitor Kubinyete";

	// Caminho da imagem utilizada como logo principal no header
	public static $caminho_logo_imagem = "recursos/phpgallery/phpgallery-logo.png";

	// Nome do script que processará o pedido de procura
	// Utilizando no caso o próprio script atual (index.php) para processar o pedido, através da querystring ?v={nome_da_visualizacao}
	public static $script_procurar = "";
	// Script da página inicial
	public static $script_inicial = "";
	// Script da página de perfil
	public static $script_perfil = "";
	// Script da página de enviar imagem
	public static $script_enviar = "";

	// Nome do script que processará o pedido da Api de imagem
	public static $script_api_imagem = "api/comentario.php";
	// Nome do script que processará o pedido da Api de usuario
	public static $script_api_usuario = "api/usuario.php";
	// Nome do script que processará o pedido da Api de comentario
	public static $script_api_comentario = "api/comentario.php";
}

?>
