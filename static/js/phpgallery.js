this.phpgallery = {
	cabecalhoAnimAtivado: false,

	animarContagem: function(id, duracao) {
		var contagemFinal =  Number.parseInt($(id).text());
		var tempoPercorrido = 0;

		var intervaloContagem = setInterval(
			function() {
				if (tempoPercorrido >= duracao) {
					clearInterval(intervaloContagem);
				} else {
					// TODO

					tempoPercorrido += 10;
				}
			}
		, 10);
	}
};