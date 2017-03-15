"use strict";

this.phpgallery = {
	visualizacaoImagemSelecionada: 0,
	usuarioMenuAtivado: false,

	imagens: {
		lista: [],

		adicionarImagem: function(aid, aurl, atitulo) {
			this.lista.push({id: aid, url: aurl, titulo: atitulo});
		},

		obterImagem: function(id) {
			for (var i = 0; i < this.lista.length; i++) {
				if (this.lista[i].id == id) {
					return this.lista[i];
					break;
				}
			}

			return;
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
	}
};
