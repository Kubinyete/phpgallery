<?php
$cstmImagem = false;
$cstmImagemUrl = "";

if (isset($itens["img_imagem"])) {
	$cstmImagem = true;
	$cstmImagemUrl = $itens["img_imagem"]->getImagemUrl();
} else if (isset($itens["imagens"]) && count($itens["imagens"]) > 0) {
	$cstmImagem = true;
	$cstmImagemUrl = $itens["imagens"][random_int(0, count($itens["imagens"]) - 1)]->getImagemUrl();
}

?>
<div class="logo-showcase">
<div class="logo-showcase-container">
		<div class="logo-showcase-imagem" style="<?php if ($cstmImagem) { echo "background-image: url(".$cstmImagemUrl.")"; } ?>"></div>
		<span id="logo-showcase-titulo"><span class="azul-negrito">PHP</span>Gallery<span class="azul-negrito versao">v<?php echo $itens["versao"]; ?></span></span>
	</div>
	<div class="logo-showcase-gradient"></div>
</div>
