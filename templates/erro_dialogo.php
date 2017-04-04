<?php if ($itens["erro_dialogo"] !== null && strlen($itens["erro_dialogo"]) > 0) { ?>
<div class='erro-dialogo-fundo'>
	<div class='erro-dialogo'>
		<h1>Erro</h1>
		<p><?php echo $itens["erro_dialogo"]; ?></p>
		<button onclick="phpgallery.desativarErroDialogo();">Ok</button>
	</div>
</div>
<script>
	$(document).ready(
		phpgallery.erroDialogo
	);
</script>
<?php } ?>
