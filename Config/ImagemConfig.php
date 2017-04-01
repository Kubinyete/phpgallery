<?php
/**
 * Classe responsável por guardar configurações utilizadas pelos objetos do tipo Imagem
 */

namespace Config;

abstract class ImagemConfig {
	// Caminho para o local aonde as imagens são armazenadas pela nossa aplicação
	const CAMINHO_IMAGENS = "static/resources/image/";
	// Título padrão, caso o usuário não informe nada
	const TITULO_PADRAO = "Nenhum título está disponível.";
	// Descrição padrão, caso o usuário não informe nada
	const DESCRICAO_PADRAO = "Nenhuma descrição está disponível.";
	// O algoritmo para encriptografar o nome da imagem na hora de armazenar
	const HASH_NOME_IMAGEM = "md5";
	// O do link para visualizar a imagem
	const LINK_IMAGEM = "/?v=imagem&id=%";
	// O arquivo que processará as miniaturas
	const PROCESSADOR_MINIATURAS = "/proc/thumbnail.php?id=%";
}

?>