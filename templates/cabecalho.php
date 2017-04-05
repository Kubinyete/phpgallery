<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1">
	<title><?php echo $itens["html_titulo"]; ?></title>
	<!-- Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $itens["html_descricao"]; ?>">
	<meta name="keywords" content="<?php echo $itens["html_palavras_chave"]; ?>">
	<meta name="author" content="<?php echo $itens["html_autor"]; ?>">
	<!-- Open Graph -->
	<meta property="og:url" content="<?php echo $itens["og_url"]; ?>">
	<meta property="og:type" content="<?php echo $itens["og_tipo"]; ?>">
	<meta property="og:title" content="<?php echo $itens["og_titulo"]; ?>">
	<meta property="og:description" content="<?php echo $itens["og_descricao"]; ?>">
	<meta property="og:image" content="<?php echo $itens["og_imagem"]; ?>">
	<meta property="og:site_name" content="<?php echo $itens["og_nome_site"]; ?>">
	<meta property="og:locale" content="<?php echo $itens["og_idioma"]; ?>">
	<!-- Links -->
	<link href="https://fonts.googleapis.com/css?family=Lato%7CRaleway%7CSource+Sans+Pro%7CUbuntu%7CUbuntu+Mono" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo $itens["css"]; ?>" rel="stylesheet">
	<link href="/favicon.ico" rel="shortcut icon">
	<!-- Scripts -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $itens["js"]; ?>"></script>
</head>
<body>
