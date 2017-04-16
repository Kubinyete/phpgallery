<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?= $itens["html_titulo"]; ?></title>
	<!-- Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= $itens["html_descricao"]; ?>">
	<meta name="keywords" content="<?= $itens["html_palavras_chave"]; ?>">
	<meta name="author" content="<?= $itens["html_autor"]; ?>">
	<!-- Open Graph -->
	<meta property="og:url" content="<?= $itens["og_url"]; ?>">
	<meta property="og:type" content="<?= $itens["og_tipo"]; ?>">
	<meta property="og:title" content="<?= $itens["og_titulo"]; ?>">
	<meta property="og:description" content="<?= $itens["og_descricao"]; ?>">
	<meta property="og:image" content="<?= $itens["og_imagem"]; ?>">
	<meta property="og:site_name" content="<?= $itens["og_nome_site"]; ?>">
	<meta property="og:locale" content="<?= $itens["og_idioma"]; ?>">
	<!-- Links -->
	<link type="text/css" href="https://fonts.googleapis.com/css?family=Lato%7CRaleway%7CSource+Sans+Pro%7CUbuntu%7CUbuntu+Mono" rel="stylesheet">
	<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link type="text/css" href="<?= $itens["css"]; ?>" rel="stylesheet">
	<link type="image/x-icon" href="<?= $itens['favicon']; ?>" rel="shortcut icon">
	<link type="image/x-icon" href="<?= $itens['favicon']; ?>" rel="icon">
	<!-- Scripts -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $itens["js"]; ?>"></script>
</head>
<body>
