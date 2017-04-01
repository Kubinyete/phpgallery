<?php
/**
 * Classe responsável por armazenar os erros na hora de processar o envio de uma imagem de suas definições
 */

namespace App\MvcErrors;

abstract class EnviarErro {
	const NENHUMA_IMAGEM = 0;
	const IMAGEM_EXCEDE_LIMITE = 1;
	const IMAGEM_FORMATO_NAO_SUPORTADO = 2;
	const USUARIO_NAO_LOGADO = 3;
	const DESCONHECIDO = 4;

	const DEFINICOES = [
		self::NENHUMA_IMAGEM => "É preciso enviar uma imagem.",
		self::IMAGEM_EXCEDE_LIMITE => "A imagem excede o tamanho limite a ser enviado (4 megabytes).",
		self::IMAGEM_FORMATO_NAO_SUPORTADO => "O formato da imagem enviada não é suportado.",
		self::USUARIO_NAO_LOGADO => "É preciso estar logado para poder enviar imagens.",
		self::DESCONHECIDO => "Ocorreu um erro ao tentar armazenar a imagem, tente novamente mais tarde."
	];
}

?>