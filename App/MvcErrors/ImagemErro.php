<?php
/**
 * Classe responsável por armazenar os erros na hora de processar o envio de algo a uma página de imagem
 */

namespace App\MvcErrors;

use Config\ComentarioConfig;

abstract class ImagemErro {
	const COMENTARIO_TAMANHO_INVALIDO = 0;
	const MAX_TAMANHO_COMENTARIO = 1;
	const NECESSITA_LOGAR = 2;

	const DEFINICOES = [
		self::COMENTARIO_TAMANHO_INVALIDO => "O comentário não pode estar vazio.",
		self::MAX_TAMANHO_COMENTARIO => "O comentário excede o limite de ".ComentarioConfig::MAX_TAMANHO_COMENTARIO." carácteres.",
		self::NECESSITA_LOGAR => "É preciso estar logado para poder enviar comentários."
	];
}

?>