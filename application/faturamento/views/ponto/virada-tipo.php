<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">

        <h3><a href="#">Virar horario</a></h3>
        <div>
<li><span class="file"><a href="<?= base_url() ?>ponto/horariostipo/viradahorariofixo">Virada fixo</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/horariostipo/viradahorariovariavel">Virada variavel</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/horariostipo/viradahorariosemiflexivel">Virada Semiflexivel</a></span></li>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    

</script>
