<?php if ($itens["erro_dialogo"] !== null && strlen($itens["erro_dialogo"]) > 0): ?>
<div class='erro-dialogo-fundo'>
	<div class='erro-dialogo'>
		<h1>Erro</h1>
		<p><?= $itens["erro_dialogo"]; ?></p>
		<button onclick="phpgallery.erroDialogo.desativar();">Ok</button>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(
		phpgallery.erroDialogo.ativar
	);
</script>
<?php endif; ?>
