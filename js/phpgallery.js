"use strict";
var menuAtivado = false;
var ultimaBusca = "";
var conteudoAjustado = false;

//Lógica de ativação de desativação do menu de opções
function menu() {
	if (!menuAtivado) {
		$("#usr-menu-container").addClass("ativado");
		$("#usr-menu-container").addClass("menu-ativado");
		$("#cabecalho-botao-container").addClass("cabecalho-botao-container-ativado");
		menuAtivado = true;
	} else {
		$("#usr-menu-container").removeClass("menu-ativado");
		$("#usr-menu-container").removeClass("ativado");
		$("#cabecalho-botao-container").removeClass("cabecalho-botao-container-ativado");
		menuAtivado = false; 
	}
}

//AJAX: Adiciona as imagens ao documento HTML
function adicionarImagens(conteudo, lista) {
	var imagens = conteudo["imagens"];
	
	if (imagens.length <= 0 ) {
		return;
	}

	/*
	for (var i = 0; i < imagens.length; i++) {
		var imagem = imagens[i];
		var novaImagem = $('<li class="desativado imagem-lista-item"><div class="imagem-container"><a class="link" href="javascript:visualizarImagem(\'' + imagem.imagemUrl + '\');"><img id="miniatura' + i + '"alt="' + imagem.titulo + '" title="Enviado por ' + imagem.autor + '\n' + imagem.descricao + '" src="/resources/loading.svg"></a><h2 class="imagem-titulo">' + imagem.titulo + '</h2><a href="view.php?id=' + imagem.id + '"><i class="fa fa-caret-square-o-up normal"></i></a></div></li>');
		$(lista).append(novaImagem);
		$("#miniatura" + i).attr("src", imagem.imagemUrlMiniatura);
	}

	$("#loading").addClass("desativado");
	$(".imagem-lista-item").removeClass("desativado");
	$(".imagem-lista-item").addClass("animacao-opacidade");
	*/

	$("#loading").addClass("desativado");

	for (var i = 0; i < imagens.length; i++) {
		var imagem = imagens[i];
		$(lista).append('<li class="imagem-lista-item animacao-opacidade"><div class="imagem-container"><a class="link" href="javascript:visualizarImagem(\'' + imagem.imagemUrl + '\');"><img id="miniatura' + i + '"alt="' + imagem.titulo + '" title="Enviado por ' + imagem.autor + '\n' + imagem.descricao + '" src="/resources/loading.svg"></a><h2 class="imagem-titulo">' + imagem.titulo + '</h2><a href="view.php?id=' + imagem.id + '"><i class="fa fa-caret-square-o-up normal"></i></a></div></li>');
		//Vamos atualizar a imagem de minitura depois, para que apareca o efeito de loading do loading.svg
		$("#miniatura" + i).attr("src", imagem.imagemUrlMiniatura);
	}

	//Reajustando o conteudo, caso o usuário tenha aberto o menu enquanto o html se ajustava
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
	if (!conteudoAjustado && $(window).width() <= 1026) {
		//Documento
		$(".conteudo-centro").css("width", "100%");
		$(".conteudo-centro").css("border", "0px");
		$(".cabecalho-centro-container").css("width", "100%");
		$(".conteudo-comentarios").css("width", "100%");
		$(".conteudo-comentarios").css("border", "0px");
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
		$(".download-caixa").css("padding", "2vw");

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
	} else if (conteudoAjustado && $(window).width() > 1026) {
		//Documento
		$(".conteudo-centro").css("width", "");
		$(".conteudo-centro").css("border", "");
		$(".cabecalho-centro-container").css("width", "1026px");
		$(".conteudo-comentarios").css("width", "");
		$(".conteudo-comentarios").css("border", "");
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
		$(".download-caixa").css("padding", "");

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

//Vamos atualizar nosso conteudo dinamico pois agora o HTML mudou
function reajustarConteudoCentro() {
	if (conteudoAjustado && $(window).width() <= 1026) {
		conteudoAjustado = false;
		ajustarConteudoCentro();
	}
}

//Ajusta a posição do menu em relação a direita da tela, para que no layout de desktop
//Sua posição seja correta
function ajustarPosicaoMenu() {
	if ($(window).width() <= 1026) {
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
	$(".erro-fundo .erro").addClass("erro-fechar-animacao");
	$(".erro-fundo").addClass("erro-fechar-fade");
	setTimeout(function(){$(".erro-fundo").addClass("desativado");}, 190);
}

//Ao clicar, vamos executar a ação do menu
$("#menu-botao").click(
	function() {
		menu();
		//Reajustando o conteudo, caso o usuário tenha aberto o menu enquanto o html se ajustava
		ajustarPosicaoMenu();
	}
);

//Ativando o ajustamento de página dinâmico
ajustarConteudoCentro();
ajustarPosicaoMenu();
$(window).resize(
	function() {
		ajustarConteudoCentro();
		ajustarPosicaoMenu();
	}
);