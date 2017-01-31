"use strict";
var ultimaBusca = "";
var conteudoAjustado = false;

//AJAX: Adiciona as imagens ao documento HTML
function adicionarImagens(conteudo, lista) {
	try{
		var imagens = conteudo["imagens"];
		
		if (imagens.length <= 0 ) {
			return;
		}

		$("#loading").addClass("desativado");

		for (var i = 0; i < imagens.length; i++) {
			var imagem = imagens[i];
			var novaImagem = $('<li><div class="imagem-container"><a class="link" href="javascript:visualizarImagem(\'' + imagem.imagemUrl + '\');"><img src="' + imagem.imagemUrl + '"></a><h2 class="imagem-titulo">' + imagem.titulo + '</h2><a href="view.php?id=' + imagem.id + '"><i class="fa fa-external-link azul"></i></a></div></li>');
			$(lista).append(novaImagem);
		}
	}
	catch (Exception) { }
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

	//Vamos atualizar nosso conteudo dinamico pois agora o HTML mudou
	if (conteudoAjustado && $(window).width() <= 1024) {
		conteudoAjustado = false;
		ajustarConteudoCentro();
	}
}

//Atualiza as imagens recentes
function atualizarRecentes() {
	$("#loading").removeClass("desativado");
	$("#sessao-recentes-lista").html('<img id="loading" src="/resources/loading.svg" draggable="false">');
	$.post("api/getrecents.php", function(data) { adicionarImagens(data, "#sessao-recentes-lista"); });
}

//Atualiza os comentários da pagina de uma imagem
function atualizarComentarios(imagemid) {
	$("#loading").removeClass("desativado");
	$("#comentarios-lista").html('<img id="loading" src="/resources/loading.svg" draggable="false">');
	$.get("api/getcomments.php?id=" + imagemid, function(data) { adicionarComentarios(data, "#comentarios-lista"); });
}

//Realiza a pesquisa de imagens consultando a api
function pesquisar(pesquisa) {
	$("#loading").removeClass("desativado");
	$("#sessao-recentes-lista").html('<img id="loading" src="/resources/loading.svg" draggable="false">');
	$.get("api/search.php?s=" + pesquisa, function(data) { adicionarImagens(data, "#sessao-recentes-lista"); });
}

//Ativa o visualizador de imagens
function visualizarImagem(url) {
	$("#visualizacao-imagem").attr("src", url);
	$("#visualizacao-fundo").addClass("visualizacao-fundo-ativado");
	$("div.cabecalho-container").addClass("blur");
	$("div.conteudo").addClass("blur");
	$("div.usr-menu-container").addClass("blur");
}

//Desativa o visualizador de imagens
function desativarVisualizacaoImagem() {
	$("#visualizacao-fundo").removeClass("visualizacao-fundo-ativado");
	$("div.cabecalho-container").removeClass("blur");
	$("div.conteudo").removeClass("blur");
	$("div.usr-menu-container").removeClass("blur");
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
	$(lista).html('<img id="loading" src="/resources/loading.svg" draggable="false">');
	$.get("api/getuserimages.php?u=" + usuario, function(data) { adicionarImagens(data, lista); });
}

//Ajusta o conteudo-centro para ajustar-se a tela
function ajustarConteudoCentro() {
	if (!conteudoAjustado && $(window).width() <= 1024) {
		//Documento
		$(".conteudo-centro").css("width", "95vw");
		$(".conteudo-comentarios").css("width", "95vw");

		//Geral
		$(".texto-sessao").css("font-size", "4vw");

		//View
		$(".view-imagem-data").css("font-size", "2.2vw");
		$(".view-imagem-descricao").css("font-size", "2.6vw");
		$("#botao-atualiza-comentarios").css("font-size", "2.6vw");
		$("#botao-atualiza-comentarios").css("bottom", "20%");

		//Perfil
		$(".profile-usuario-placar .usuario-nome").css("font-size", "2vw");
		$(".profile-usuario-descricao p").css("font-size", "2.4vw");

		//Comentários
		$(".comentario-usuario-nome").css("font-size", "2vw");
		$(".comentario-usuario-conteudo").css("font-size", "3vw");
		$(".comentario-data").css("font-size", "3vw");
		
		conteudoAjustado = true;
	} else if (conteudoAjustado && $(window).width() > 1024) {
		//Documento
		$(".conteudo-centro").css("width", "");
		$(".conteudo-comentarios").css("width", "");

		//Geral
		$(".texto-sessao").css("font-size", "");

		//View
		$(".view-imagem-data").css("font-size", "");
		$(".view-imagem-descricao").css("font-size", "");
		$("#botao-atualiza-comentarios").css("font-size", "");
		$("#botao-atualiza-comentarios").css("bottom", "");

		//Perfil
		$(".profile-usuario-placar .usuario-nome").css("font-size", "");
		$(".profile-usuario-descricao p").css("font-size", "");

		//Comentários
		$(".comentario-usuario-nome").css("font-size", "");
		$(".comentario-usuario-conteudo").css("font-size", "");
		$(".comentario-data").css("font-size", "");
		
		conteudoAjustado = false;
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
$(window).resize(ajustarConteudoCentro);