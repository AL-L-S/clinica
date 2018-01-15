
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form name="form_procedimentonovolaboratorio" id="form_procedimentonovolaboratorio" action="<?= base_url() ?>ambulatorio/procedimentoplano/gravarnovolaboratorio/<?= $procedimento_percentual_laboratorio_id ?>/<?= $convenio_id ?>" method="post" onSubmit="enviardados();">

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
                        <label>Laboratório</label>
                    </dt>
                    <dd>                    
                        <select name="laboratorio" id="laboratorio" class="size4" required="true">
                            <option value="">Selecione</option>
                            <? foreach ($laboratorios as $value) : ?>
                                <option value="<?= $value->laboratorio_id; ?>"><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Valor</label>
                    </dt>
                    <dd>
                        <input type="text" name="valor" id="valor" class="texto01" required="true"/>
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
                    <?if($dados[0]->grupo == 'RM'){?>
                    <div id="revisordiv">
                        <dt>
                            <label>Revisor</label>
                        </dt>
                        <dd>
                            <select name="revisor"  id="revisor" class="size1">  
                                <option value="0"> NÃO</option>             
                                <option value="1"> SIM</option>
                            </select>
                        </dd>
                    </div>
                    <?}
                    
                    ?>
                    <dt>
                        <label>Dia Faturamento</label>
                    </dt>
                    <dd>
                        <input type="text" id="entrega" class="texto02" name="dia_recebimento" alt="99"/>
                    </dd>
                    <dt>
                        <label>Tempo para Recebimento</label>
                    </dt>
                    <dd>
                        <input type="text" id="pagamento" class="texto02" name="tempo_recebimento" alt="99"/>
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


//    $(document).ready(function () {
//        jQuery('#form_procedimentonovolaboratorio').validate({
//            rules: {
//                laboratorio: {
//                    required: true,
//                    equalTo: "#SELECIONE"
//                },
//                valor: {
//                    required: true
//                }
//
//            },
//            messages: {
//                laboratorio: {
//                    required: "*",
//                    equalTo: "*"
//                },
//                valor: {
//                    required: "*"
//                }
//            }
//        });
//    });



</script>