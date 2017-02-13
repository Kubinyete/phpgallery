"use strict";
var ultimaBusca = "";
var conteudoAjustado = false;

//AJAX: Adiciona as imagens ao documento HTML
function adicionarImagens(conteudo, lista) {
	var imagens = conteudo["imagens"];
	
	if (imagens.length <= 0 ) {
		return;
	}

	$("#loading").addClass("desativado");

	for (var i = 0; i < imagens.length; i++) {
		var imagem = imagens[i];
		var novaImagem = $('<li><div class="imagem-container"><a class="link" href="javascript:visualizarImagem(\'' + imagem.imagemUrl + '\');"><img alt="' + imagem.titulo + '" title="Enviado por ' + imagem.autor + '\n' + imagem.descricao + '" src="' + imagem.imagemUrlMiniatura + '"></a><h2 class="imagem-titulo">' + imagem.titulo + '</h2><a href="view.php?id=' + imagem.id + '"><i class="fa fa-caret-square-o-up normal"></i></a></div></li>');
		$(lista).append(novaImagem);
	}

	reajustarConteudoCentro();
}

//AJAX: Adiciona comentários ao documento HTML
function adicionarComentarios(conteudo, lista) {
	var comentarios = conteudo["comentarios"];

	$("#loading").addClass("desativado");

	if (comentarios.length <= 0) {
		$(lista).append("<p class=\"texto-descricao\">Nenhum comentário, seja o primeiro a comentar algo!</p>");
		return;
	}

	for (var i = 0; i < comentarios.length; i++) {
		var comentario = comentarios[i];
		var novoComentarioDOM = $('<li><div class="comentario-container"><a class="link" href="profile.php?u=' + comentario.autor.nome + '"><div class="comentario-usuario-container"><img class="usuario-imagem" draggable="false" src="' + comentario.autor.imagemUrl + '"><p class="comentario-usuario-nome">' + comentario.autor.nome + '</div></a><div class="comentario-conteudo-container"><p class="texto-descricao comentario-data"><i class="fa fa-calendar azul"></i> Enviado em ' + comentario.dataCriacao + '</p><p class="texto normal comentario-usuario-conteudo">' + comentario.conteudo + '</p></div></div></li>');

		$(lista).append(novoComentarioDOM);
	}

	reajustarConteudoCentro();
}

//Atualiza as imagens recentes
function atualizarRecentes() {
	$("#loading").removeClass("desativado");
	$("#sessao-recentes-lista").html('<img id="loading" alt="Ícone de carregamento" src="/resources/loading.svg" draggable="false">');
	$.get("api/recents.php", function(data) { adicionarImagens(data, "#sessao-recentes-lista"); });
}

//Atualiza os comentários da pagina de uma imagem
function atualizarComentarios(imagemid) {
	$("#loading").removeClass("desativado");
	$("#comentarios-lista").html('<img id="loading" alt="Ícone de carregamento" src="/resources/loading.svg" draggable="false">');
	$.get("api/comments.php?id=" + imagemid, function(data) { adicionarComentarios(data, "#comentarios-lista"); });
}

//Realiza a pesquisa de imagens consultando a api
function pesquisar(pesquisa) {
	$("#loading").removeClass("desativado");
	$("#sessao-recentes-lista").html('<img id="loading" alt="Ícone de carregamento" src="/resources/loading.svg" draggable="false">');
	$.get("api/search.php?s=" + pesquisa, function(data) { adicionarImagens(data, "#sessao-recentes-lista"); });
}

//Ativa o visualizador de imagens
function visualizarImagem(url) {
	$("#visualizacao-imagem").attr("src", url);
	$("#visualizacao-fundo").addClass("visualizacao-fundo-ativado");
	$("div.cabecalho-container").addClass("blur");
	$("div.conteudo").addClass("blur");
	$("div.usr-menu-container").addClass("blur");
	$("div.conteudo-piso").addClass("blur");
}

//Desativa o visualizador de imagens
function desativarVisualizacaoImagem() {
	$("#visualizacao-imagem").attr("src", "/resources/loading.svg");
	$("#visualizacao-fundo").removeClass("visualizacao-fundo-ativado");
	$("div.cabecalho-container").removeClass("blur");
	$("div.conteudo").removeClass("blur");
	$("div.usr-menu-container").removeClass("blur");
	$("div.conteudo-piso").removeClass("blur");
}

//Filtra o spam ao pressionar o botão e não inserir uma busca diferente
function pesquisarBotao() {
	if ($("#pesquisa").val() != ultimaBusca) {
		pesquisar($("#pesquisa").val());
		ultimaBusca = $("#pesquisa").val();
	}
}

//Obtem todas as imagens de um usuário através de um método post
function obterImagensUsuario(usuario, lista) {
	$("#loading").removeClass("desativado");
	$(lista).html('<img id="loading" alt="Ícone de carregamento" src="/resources/loading.svg" draggable="false">');
	$.get("api/images.php?u=" + usuario, function(data) { adicionarImagens(data, lista); });
}

//Ajusta o conteudo-centro para ajustar-se a tela
function ajustarConteudoCentro() {
	if (!conteudoAjustado && $(window).width() <= 1024) {
		//Documento
		$(".conteudo-centro").css("width", "95vw");
		$(".cabecalho-centro-container").css("width", "100%");
		$(".conteudo-comentarios").css("width", "95vw");
		$(".usuario-container").css("display", "none");

		//Menu
		$("#usr-menu-container").css("width", "100%");
		$("#usr-menu-container i").css("float", "left");

		//Geral
		$(".texto-sessao").css("font-size", "4vw");

		//Miniaturas
		$(".imagem-titulo").css("font-size", "2vw");
		$(".imagem-container i").css("bottom", "0px");
		$(".imagem-container i").css("top", "inherit");
		$(".imagem-container i").css("border-top-left-radius", "2.5px");
		$(".imagem-container i").css("border-bottom-left-radius", "0px");
		$(".imagem-container img").css("max-width", "35vw");
		$(".imagem-container img").css("max-height", "35vw");

		//View
		$(".view-imagem-data").css("font-size", "2.2vw");
		$(".view-imagem-descricao").css("font-size", "2.6vw");
		$("#botao-atualiza-comentarios").css("font-size", "2.6vw");
		$("#botao-atualiza-comentarios").css("bottom", "20%");

		//Perfil
		$(".profile-usuario-placar .usuario-nome").css("font-size", "2vw");
		$(".profile-usuario-descricao p").css("font-size", "2.4vw");
		$(".profile-formulario-texto").css("font-size", "2.6vw");
		$(".input-imagem-container .input-imagem").css("font-size", "1vw");
		$(".profile-formulario .botao").css("font-size", "2vw");

		//Comentários
		$(".comentario-usuario-nome").css("font-size", "2vw");
		$(".comentario-usuario-conteudo").css("font-size", "3vw");
		$(".comentario-data").css("font-size", "3vw");
		
		conteudoAjustado = true;
	} else if (conteudoAjustado && $(window).width() > 1024) {
		//Documento
		$(".conteudo-centro").css("width", "");
		$(".cabecalho-centro-container").css("width", "1024px");
		$(".conteudo-comentarios").css("width", "");
		$(".usuario-container").css("display", "");

		//Menu
		$("#usr-menu-container").css("width", "256px");
		$("#usr-menu-container i").css("float", "");

		//Geral
		$(".texto-sessao").css("font-size", "");

		//Miniaturas
		$(".imagem-titulo").css("font-size", "");
		$(".imagem-container i").css("bottom", "");
		$(".imagem-container i").css("top", "");
		$(".imagem-container i").css("border-top-left-radius", "");
		$(".imagem-container i").css("border-bottom-left-radius", "");
		$(".imagem-container img").css("max-width", "");
		$(".imagem-container img").css("max-height", "");

		//View
		$(".view-imagem-data").css("font-size", "");
		$(".view-imagem-descricao").css("font-size", "");
		$("#botao-atualiza-comentarios").css("font-size", "");
		$("#botao-atualiza-comentarios").css("bottom", "");

		//Perfil
		$(".profile-usuario-placar .usuario-nome").css("font-size", "");
		$(".profile-usuario-descricao p").css("font-size", "");
		$(".profile-formulario-texto").css("font-size", "");
		$(".input-imagem-container .input-imagem").css("font-size", "");
		$(".profile-formulario .botao").css("font-size", "");

		//Comentários
		$(".comentario-usuario-nome").css("font-size", "");
		$(".comentario-usuario-conteudo").css("font-size", "");
		$(".comentario-data").css("font-size", "");
		
		conteudoAjustado = false;
	}
}

function reajustarConteudoCentro() {
	//Vamos atualizar nosso conteudo dinamico pois agora o HTML mudou
	if (conteudoAjustado && $(window).width() <= 1024) {
		conteudoAjustado = false;
		ajustarConteudoCentro();
	}
}

function ajustarPosicaoMenu() {
	if ($(window).width() <= 1024) {
		$("#usr-menu-container").css("right", "0px");
	} else {
		$("#usr-menu-container").css("right", $(window).width() - ( $("#cabecalho-botao-container").offset().left + $("#cabecalho-botao-container").width() ));
	}
}

//Atualiza um contador de carácteres restantes
function adicionarContadorCaracteres(elementoTexto, alvoAtualizar) {
	$(elementoTexto).keyup(
		function() {
			var numeroCaracteres = $(elementoTexto).val().length;
			$(alvoAtualizar).text($(elementoTexto).attr("maxlength") - numeroCaracteres + " carácteres restantes");
		}
	);
}

//Desativa nossa caixa de diálogo que contêm o erro atual
function desativarErro() {
	$(".erro-fundo").addClass("desativado");
}

//Ativando o ajustamento de página dinâmico
ajustarConteudoCentro();
ajustarPosicaoMenu();
$(window).resize(
	function() {
		ajustarConteudoCentro();
		ajustarPosicaoMenu();
	}
);