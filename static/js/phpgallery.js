"use strict";
// phpgallery.js

window.phpgallery = {
	cabecalho: {
		animAtivada: false
	},

	usuarioMenu: {
		ativado: false,

		gerenciar: function() {
			window.phpgallery.usuarioMenu.ajustarPos();

			if (!window.phpgallery.usuarioMenu.ativado) {
				$("header #usuarioMenuBtn").addClass("ativado");
				$("#usuarioMenu").addClass("ativado");
				window.phpgallery.usuarioMenu.ativado = true;
			} else {
				$("header #usuarioMenuBtn").removeClass("ativado");
				$("#usuarioMenu").removeClass("ativado");
				window.phpgallery.usuarioMenu.ativado = false;
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
		ativar: function(url, titulo, descricao) {
			if (typeof url != "undefined" && typeof titulo != "undefined" && typeof descricao != "undefined") {
				window.phpgallery.visualizacao.mudarImagem(url, titulo, descricao);
			}

			$(".visualizacao-imagem-fundo").addClass("visualizacao-imagem-fundo-ativado");
		},

		desativar: function() {
			$(".visualizacao-imagem-fundo-ativado").removeClass("visualizacao-imagem-fundo-ativado");
		},

		mudarImagem: function(url, titulo, descricao, domobj) {
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("src", url);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-container img").attr("alt", titulo);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-titulo span").text(titulo);
			$(".visualizacao-imagem-fundo .direita-container .visualizacao-imagem-descricao span").text(descricao);
			
			$(".visualizacao-imagem-fundo .esquerda-container ul li.ativado").removeClass("ativado");

			if (typeof domobj != "undefined") {
				$(domobj).addClass("ativado");
			}
		}
	}
};
