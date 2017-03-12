<?php
namespace PHPGallery\WebInterface;

/**
 * Classe estática responsável por guardar referências absolutas (valores padrões, links, nomes, etc)
 */
class Referencias {
	// Versão da aplicação
	public static $phpgallery_versao = "2.0.0";

	public static $html_site_titulo = "PHPGallery";
	public static $html_descricao_padrao = "Uma aplicação web que permite o envio e a hospedagem de imagens aos usuários registrados.";
	public static $html_palavras_chave_padrao = "galeria, imagens, envio, upload, wallpaper, php, captura de tela, widescreen, papel de parede";
	public static $html_autor_padrao = "Vitor Kubinyete";

	// Nome do script que processará o pedido de procura
	// Utilizando no caso o próprio script atual (index.php) para processar o pedido, através da querystring ?v={nome_da_visualizacao}
	public static $script_procurar = "/procurar";
	// Script da página inicial
	public static $script_inicial = "/home";
	// Script da página de perfil
	public static $script_perfil = "/perfil";
	// Script da página de enviar imagem
	public static $script_enviar = "/enviar";
	// Script da página de imagem
	public static $script_imagem = "/imagem";
	// Script de download de imagens
	public static $script_download = "/download";

	// Nome do script que processará o pedido da Api de imagem
	public static $script_api_imagem = "/api/comentario.php";
	// Nome do script que processará o pedido da Api de usuario
	public static $script_api_usuario = "/api/usuario.php";
	// Nome do script que processará o pedido da Api de comentario
	public static $script_api_comentario = "/api/comentario.php";
}

?>
