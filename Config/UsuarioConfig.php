<?php
/**
 * Classe responsável por guardar propriedades estáticas de configuração
 * como caminhos absolutos, etc de um objeto Usuario
 */

namespace Config;

abstract class UsuarioConfig {
	// Descrição padrão de um usuário caso não tenha escrito nada
	const DESCRICAO_PADRAO = "Nenhuma descrição está disponível para este usuário.";
	// Algoritimo utilizado para salvar senhas
	const HASH_ALGORITIMO = "sha256";
	// Algoritimo utilizado para encriptografar o nome da imagem
	// utilizar o número de id puro ficaria estranho
	const HASH_NOME_IMAGEM_PERFIL = "md5";
	// Período limite em segundos que um usuário será constado como online
	const PERIODO_ONLINE = 60;

	// O caminho padrão para as imagens de perfil
	const CAMINHO_IMAGENS_PERFIL = "static/resources/profile/";
	// A extensão padrão dessas imagens
	const IMAGEM_EXTENSAO_PADRAO = "jpg";
	// A imagem de perfil padrão caso o usuário ainda não enviou nenhuma imagem de perfil
	const IMAGEM_PERFIL_PADRAO = "default";

	// O caminho completo para a imagem de perfil padrão
	const CAMINHO_IMAGEM_PERFIL_PADRAO = self::CAMINHO_IMAGENS_PERFIL.self::IMAGEM_PERFIL_PADRAO.".".self::IMAGEM_EXTENSAO_PADRAO;

	// O link para acessar a página de um usuário
	const LINK_USUARIO = "/?v=perfil&u=%";
}

?>