<main>
	<article>
		<h1>Enviar imagem</h1>
		<p>Envie uma imagem para ser armazenada no servidor</p>
		<br>
		<form id="enviarForm" class="aut-formulario dashed-container" method="POST" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="a" value="r">
			<input type="file" accept="image/*" name="img">
			<br>
			<br>
			<label for="imgti">Título</label>
			<input id="imgti" type="text" name="imgti" maxlength="<?= $itens["imgti_maxlength"]; ?>" placeholder="O título da imagem...">
			<br>
			<br>
			<label for="imgde">Descrição</label>
			<br>
			<textarea id="imgde" name="imgde" maxlength="<?= $itens["imgde_maxlength"]; ?>" placeholder="Informações adicionais..."></textarea>
			<br>
			<input id="imgpr" type="checkbox" name="imgpr" value="1">
			<label for="imgpr">Imagem privada</label>
			<br>
			<button type="submit">Enviar</button>
		</form>
	</article>
</main>
