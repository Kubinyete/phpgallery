<?php
/**
 * Cabeçalho de toda as páginas utilizadas pela aplicação
 * TODO: OG tags
 */

namespace PHPGallery\WebInterface;

require_once "Referencias.php";

$html_titulo = (defined("HTML_TITULO")) ? HTML_TITULO : null;
$html_descricao = (defined("HTML_DESCRICAO")) ? HTML_DESCRICAO : Referencias::$html_descricao_padrao;
$html_palavras_chave = (defined("HTML_PALAVRAS_CHAVE")) ? HTML_PALAVRAS_CHAVE : Referencias::$html_palavras_chave_padrao;
$html_autor = (defined("HTML_AUTOR")) ? HTML_AUTOR : Referencias::$html_autor_padrao;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $html_descricao; ?>">
	<meta name="keywords" content="<?php echo $html_palavras_chave; ?>">
	<meta name="author" content="<?php echo $html_autor; ?>">
	<title><?php echo Referencias::$html_site_titulo; echo ($html_titulo !== null) ? " - " . $html_titulo : ""; ?></title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato%7COpen+Sans%7CRaleway%7CSource+Sans+Pro%7CUbuntu%7CUbuntu+Mono" rel="stylesheet">
	<link href="/static/css/phpgallery.styles.css" rel="stylesheet">
	<link href="/favicon.ico" rel="shortcut icon">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="/static/js/phpgallery.js"></script>
</head>
<body>