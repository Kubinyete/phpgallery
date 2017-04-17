<div class="anim-processando-fundo">
    <img src="<?= $itens['recursos']; ?>carregando.gif" alt="Processando...">
    <span id="processando-string">Processando</span>
</div>
<script type="text/javascript">
    phpgallery.animProcessando.dots_ds = $('#processando-string').text();

    $('form *[type=submit]').click(
        phpgallery.animProcessando.ativar
    );
</script>
