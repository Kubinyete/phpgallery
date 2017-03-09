<?php
namespace PHPGallery\ApiInterface;

define("AE_DESCONHECIDO", 0);
define("AE_INVALIDO_NAO_ENCONTRADO", 1);
define("AE_USUARIO_NAO_EXISTE", 2);
define("AE_IMAGEM_NAO_EXISTE", 3);
define("AE_COMENTARIO_NAO_EXISTE", 4);

/**
 * Classe estática que contém todas as definições e respostas para determinados erros na Api
 */
class ApiErroDefinicoes {
	public static $api_erros = [
		AE_DESCONHECIDO => ["Ocorreu um erro desconhecido ao tentar processar o seu pedido.", 400],
		AE_INVALIDO_NAO_ENCONTRADO => ["O pedido efetuado está inválido, pois não se encaixou em nenhuma ação disponível.", 400],
		AE_USUARIO_NAO_EXISTE => ["O usuário que você está procurando não existe.", 404],
		AE_IMAGEM_NAO_EXISTE => ["A imagem que você está procurando não existe.", 404],
		AE_COMENTARIO_NAO_EXISTE => ["O comentário que você está procurando não existe.", 404]
	];
}

?>