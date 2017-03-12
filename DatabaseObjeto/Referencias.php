<?php
namespace PHPGallery\DatabaseObjeto;

/**
 * Classe estática responsável pro conter caminhos absolutos em nosso sistema
 */
class Referencias {
	// Caminho aonde todas as imagens enviadas ficarão
	public static $caminho_imagens = "/static/recursos/phpgallery/imagem/";
	// Caminho aonde todas as imagens de perfil dos usuários ficarão
	public static $caminho_imagens_perfil = "/static/recursos/phpgallery/perfil/";
	// Retorna a imagem padrão de perfil
	// utilizado quando o usuário ainda não enviou uma imagem de perfil
	public static $caminho_imagem_perfil_padrao = "/static/recursos/phpgallery/perfil/perfil-padrao.jpg";
}

?>
