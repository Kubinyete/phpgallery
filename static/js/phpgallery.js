this.phpgallery = {
	cabecalho: {
		animAtivada: false,
	},

	usuarioMenu: {
		ativado: false,

		gerenciar: function() {
			phpgallery.usuarioMenu.ajustarPos();

			if (!phpgallery.usuarioMenu.ativado) {
				$("header #usuarioMenuBtn").addClass("ativado");
				$("#usuarioMenu").addClass("ativado");
				phpgallery.usuarioMenu.ativado = true;
			} else {
				$("header #usuarioMenuBtn").removeClass("ativado");
				$("#usuarioMenu").removeClass("ativado");
				phpgallery.usuarioMenu.ativado = false;
			}
		},

		ajustarPos: function() {
			$("#usuarioMenu").css({
				top: $("header").height(),
				right: $("body").width() - ($("header #usuarioMenuBtn").offset().left + 21.16)
			});
		}
	},

	erroDialogo: {
		ativar: function() {
			$(".erro-dialogo-fundo").addClass("erro-dialogo-fundo-ativado");
		},

		desativar: function() {
			$(".erro-dialogo-fundo-ativado").removeClass("erro-dialogo-fundo-ativado");
		}
	},

	visualizacao: {
		iconeCarregando: "",

		ativar: function(url=null, titulo=null, descricao=null) {
			if (url != null) {
				phpgallery.visualizacao.mudarImagem(url, titulo, descricao);
			}

			$(".visualizacao-imagem-fundo").addClass("visualizacao-imagem-fundo-ativado");
		},

		desativar: function() {
			$(".visualizacao-imagem-fundo-ativado").removeClass("visualizacao-imagem-fundo-ativado");
		},

		mudarImagem: function(url, titulo, descricao, domobj=null) {
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("src", phpgallery.visualizacao.iconeCarregando);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("src", url);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("alt", titulo);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-titulo span").text(titulo);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-descricao span").text(descricao);
			
			if (domobj != null) {
				$(".visualizacao-imagem-fundo .esquerda-container ul li.ativado").removeClass("ativado");
				$(domobj).addClass("ativado");
			}
		}
	}
};
