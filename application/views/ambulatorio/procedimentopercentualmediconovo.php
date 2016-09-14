
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form name="form_procedimentonovomedico" id="form_procedimentonovomedico" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarnovomedico/<?= $procedimento_percentual_medico_id ?>" method="post" onSubmit="enviardados();">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Covênio</label>
                    </dt>
                    <dd>                        
                        <input type="text" name="covenio" id="covenio" class="texto04" value="<?= $dados[0]->convenio; ?>" readonly />                                                                                                                                                                                 
                    </dd>                                                           
                    <dt>                         
                        <label>Grupo</label>
                    </dt>                    
                    <dd>                       
                        <input type="text" name="grupo" id="grupo" class="texto04" value="<?= $dados[0]->grupo ?>" readonly />
                    </dd>
                    <dt>
                        <label>Procedimento</label>
                    </dt>
                    <dd>
                        <input type="text" name="procedimento" id="procedimento" class="texto04" value="<?= $dados[0]->procedimento ?>" readonly />

                    </dd>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>                    
                        <select name="medico" id="medico" class="size4">
                            <option>SELECIONE</option>
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
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_procedimentonovomedico').validate({
            rules: {
                medico: {
                    required: true,
                    equalTo: "#SELECIONE"
                },
                valor: {
                    required: true
                }

            },
            messages: {
                medico: {
                    required: "*",
                    equalTo: "*"
                },
                valor: {
                    required: "*"
                }
            }
        });
    });



</script>