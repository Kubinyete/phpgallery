this.phpgallery = {
	cabecalhoAnimAtivado: false,
	usuarioMenuAtivado: false,

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
	}
};
