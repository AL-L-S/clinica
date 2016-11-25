<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">

        <h3><a href="#">Carregar pontos </a></h3>
        <div>

            <?= form_open_multipart(base_url() . 'ponto/importarponto/importar'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br/>
            <input type="file" name="userfile" />
            <button type="submit" name="btnEnviar">Enviar</button>
            <?= form_close(); ?>
            <div style="width: 400px; margin: 0">
                <?
                if (isset($erros)) :
                    echo $erros;
                endif;
                ?>

            </div>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    

</script>
