this.phpgallery = {
	cabecalhoAnimAtivado: false,
	usuarioMenuAtivado: false,
	erroDialogoAtivado: false,

	// Abrir / fechar menu do usuário
	usuarioMenu: function() {
		phpgallery.ajustarPosUsuarioMenu();

		if (!phpgallery.usuarioMenuAtivado) {
			$("header #usuarioMenuBtn").addClass("ativado");
			$("#usuarioMenu").addClass("ativado");
			phpgallery.usuarioMenuAtivado = true;
		} else {
			$("header #usuarioMenuBtn").removeClass("ativado");
			$("#usuarioMenu").removeClass("ativado");
			phpgallery.usuarioMenuAtivado = false;
		}
	},

	ajustarPosUsuarioMenu: function() {
		$("#usuarioMenu").css({
			top: $("header").height(),
			right: $("body").width() - ($("header #usuarioMenuBtn").offset().left + 21.16)
		});
	},

	erroDialogo: function(titulo, erro) {
		if (!phpgallery.erroDialogoAtivado) {
			$("body").append(
				"<div class='erro-dialogo-fundo'><div class='erro-dialogo'><h1>"+titulo+"</h1><p>"+erro+"</p><button id='erro-dialogo-ok'>Ok</button></div></div>"
			);

			phpgallery.erroDialogoAtivado = true;
			
			$("#erro-dialogo-ok").click(
				phpgallery.desativarErroDialogo
			);
		}
	},

	desativarErroDialogo: function() {
		$("#erro-dialogo-ok").off();
		$(".erro-dialogo-fundo").remove();
		phpgallery.erroDialogoAtivado = false;
	}
};
