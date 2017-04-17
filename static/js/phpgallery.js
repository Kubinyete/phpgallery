"use strict";

window.phpgallery = {
	cabecalho: {
		animAtivada: false
	},

	animProcessando: {
		crgInter: null,
		dots_c: 1,
		dots_ds: '',

		ativar: function() {
			if (phpgallery.animProcessando.crgInter != null) { return; }
			$('.anim-processando-fundo').addClass('anim-processando-fundo-ativado');
			phpgallery.animProcessando.crgInter = setInterval(
				function() {
					var dots_s = '';
					
					for (var i = 0; i < phpgallery.animProcessando.dots_c; i++) {
						dots_s += '.';
					}

					$('#processando-string').text(phpgallery.animProcessando.dots_ds + dots_s);

					if (phpgallery.animProcessando.dots_c >= 3) {
						phpgallery.animProcessando.dots_c = 1;
					} else {
						phpgallery.animProcessando.dots_c++;
					}
				}
			, 500);
		},

		desativar: function() {
			if (phpgallery.animProcessando.crgInter == null) { return; }
			$('.anim-processando-fundo').removeClass('anim-processando-fundo-ativado');
			clearInterval(phpgallery.animProcessando.crgInter);
			phpgallery.animProcessando.crgInter = null;
			phpgallery.animProcessando.dots_c = 1;
		}
	},

	perfilEdit: {
		atualizarImagemFundo: function(id, imagemUrl) {
			if (id != $('#perfil-edit-form #img-fundo-id').val()) {
				$('div.perfil-container').css('background-image', 'url('+imagemUrl+')');
				$('#perfil-edit-form #img-fundo-id').val(id);
			}
		}
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
