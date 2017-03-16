"use strict";

this.phpgallery = {
	visualizacaoImagemSelecionada: 0,
	usuarioMenuAtivado: false,
	IE: window.navigator.userAgent.indexOf(".NET") != -1,
	FIREFOX: window.navigator.userAgent.indexOf("Firefox") != -1,

	imagens: {
		// Das imagens mais recentes até as mais antigas
		// id -> decrescente
		lista: [],

		adicionarImagem: function(id, url, titulo) {
			this.lista.push({id: id, url: url, titulo: titulo});
		},

		obterImagem: function(id) {
			/*
			for (var i = 0; i < this.lista.length; i++) {
				if (this.lista[i].id == id) {
					return this.lista[i];
					break;
				}
			}

			return;
			*/

			var inicio = 0;
			var fim = this.lista.length - 1;
			var imagem = null;

			/**
			 * [ 5 , 4 , 3 , 2 , 1 , 0]
			 */

			while (inicio <= fim) {
				var i = Math.round((inicio + fim) / 2);

				if (this.lista[i].id == id) {
					imagem = this.lista[i];
					break;
				} else {
					if (inicio >= fim) {
						break;
					} else {
						if (this.lista[i].id < id) {
							fim = Math.round((inicio + fim) / 2) - 1;
						} else {
							inicio = Math.round((inicio + fim) / 2) + 1;
						}
					}
				}
			}

			return imagem;
		}
	},

	visualizarImagem: function(id) {
		$(".visualizacao-imagem-container img").attr("src", "/static/recursos/phpgallery/carregando.svg");
		$(".visualizacao-fundo").addClass("visualizacao-fundo-ativado");

		var imagem = this.imagens.obterImagem(id);

		if (!imagem) { return; }

		$(".visualizacao-galeria-container #" + this.visualizacaoImagemSelecionada).removeClass("visualizacao-galeria-imagem-selecionado");
		$(".visualizacao-galeria-container #" + id).addClass("visualizacao-galeria-imagem-selecionado");

		this.visualizacaoImagemSelecionada = id;

		$(".visualizacao-imagem-container img").attr("src", imagem.url);
	},

	desativarVisualizacaoImagem: function() {
		$(".visualizacao-fundo").removeClass("visualizacao-fundo-ativado");
	},

	menuUsuario: function() {
		if (!this.usuarioMenuAtivado) {
			$(".usuario-menu").addClass("usuario-menu-ativado");
			$(".cabecalho-usuario-btnopcoes-container").addClass("cabecalho-usuario-btnopcoes-container-ativado");
			this.usuarioMenuAtivado = true;
		} else {
			$(".usuario-menu").removeClass("usuario-menu-ativado");
			$(".cabecalho-usuario-btnopcoes-container").removeClass("cabecalho-usuario-btnopcoes-container-ativado");
			this.usuarioMenuAtivado = false;
		}
	},

	irPara: function(elemento, offset, animar=true, delay=1000) {
		if ($(document).scrollTop() >= $(elemento).offset().top) {
			return;
		}

		if (!animar) {
			$(document).scrollTop($(elemento).offset().top + offset);
		} else {
			if (this.IE || this.FIREFOX) {
				$("html").animate(
					{
						scrollTop: $(elemento).offset().top + offset
					}, delay
				);
			} else {
				$("body").animate(
					{
						scrollTop: $(elemento).offset().top + offset
					}, delay
				);
			}
		}
	}
};
