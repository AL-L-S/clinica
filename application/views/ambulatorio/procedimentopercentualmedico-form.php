
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form name="form_procedimentohonorario" id="form_procedimentohonorario" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarpercentualmedico" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Covênio</label>
                    </dt>
                    <dd>
                        <select name="covenio" id="covenio" class="size4">
                            <option>SELECIONE</option>
                            <? foreach ($convenio as $value) : ?>
                                <option  value="<?= $value->convenio_id; ?>"><?php echo $value->nome; ?></option>                            
                            <? endforeach; ?>                                                                                             
                        </select>               

                    </dd>                                                           
                    <dt>                         
                        <label>Grupo</label>
                    </dt>                    
                    <dd>                       
                        <select name="grupo" id="grupo" class="size4">
                            <option>SELECIONE</option>
                            <option>TODOS</option>                           
                            <? foreach ($grupo as $value) : ?>
                                <option value="<?= $value->nome; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; /* $value->ambulatorio_grupo_id; */ ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
                        <select  name="procedimento" id="procedimento" class="size4" >
                            <option value="">SELECIONE</option>
                        </select>

                    </dd>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>                    
                        <select name="medico" id="medico" class="size4">
                            <option>SELECIONE</option>
                            <option>TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" id="valor" class="texto01" />
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <select name="percentual"  id="percentual" class="size1">                            
                            <option value="1"> SIM</option>
                            <option value="0"> NÃO</option>                                   
                        </select>
                    </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>

        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $('#covenio').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentoporconvenio', {covenio: $(this).val(), ajax: true}, function (j) {
                    options = '<option value="">TODOS</option>';
                    for (var c = 0; c < j.length; c++) {
                        options += '<option value="' + j[c].procedimento_convenio_id + '">' + j[c].procedimento + ' - ' + j[c].codigo + '</option>';
                    }
                    $('#procedimento').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#procedimento').html('<option value="">SELECIONE</option>');
            }
        });
    });


</script>