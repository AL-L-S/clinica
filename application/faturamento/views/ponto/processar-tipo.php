<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">

        <h3><a href="#">Processar tipo</a></h3>
        <div>
<li><span class="file"><a href="<?= base_url() ?>ponto/processaponto/funcionariofixo">Processar fixo</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/processaponto/funcionariovariavel">Processar variavel</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/processaponto/funcionariosemiflexivel">Processar semiflexivel</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/processaponto/funcionarioindividual">Processar individual</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/processaponto/funcionariolivres">Processar batidas</a></span></li>
<li><span class="file"><a href="<?= base_url() ?>ponto/ocorrencia/processarocorrencia">Processar ocorrencia</a></span></li>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    

</script>
