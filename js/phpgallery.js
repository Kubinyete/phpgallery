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

//Atualiza as imagens recentes
function atualizarRecentes() {
	$("#loading").removeClass("desativado");
	$("#sessao-recentes-lista").html('<img id="loading" src="/resources/loading.svg" draggable="false">');
	$.post("api/getrecents.php", function(data) { adicionarImagens(data, "#sessao-recentes-lista"); });
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
		$(".conteudo-centro").css("width", "95vw");
		$(".texto-sessao").css("font-size", "4vw");
		$(".profile-usuario-placar .usuario-nome").css("font-size", "2.4vw");
		$(".profile-usuario-descricao p").css("font-size", "2.4vw");
		conteudoAjustado = true;
	} else if (conteudoAjustado && $(window).width() > 1024) {
		$(".conteudo-centro").css("width", "");
		$(".texto-sessao").css("font-size", "");
		$(".profile-usuario-placar .usuario-nome").css("font-size", "");
		$(".profile-usuario-descricao p").css("font-size", "");
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