<body bgcolor="#C0C0C0">
    <meta charset="UTF-8">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Faturamento Detalhe</h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/guia/gravarfaturamentodetalhe" method="post">
                <fieldset>

                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Autoriza&ccedil;&atilde;o</label>
                        </dt>
                        <dd>
                            <input type="text" name="autorizacao" id="autorizacao" class="texto01" value="<?= $exame[0]->autorizacao; ?>" />
                            <input type="hidden" name="agenda_exames_id" id="agenda_exames_id" class="texto01" value="<?= $agenda_exames_id; ?>"/>
                            <input type="hidden" name="paciente_id" id="paciente_id" class="texto01" value="<?= $exame[0]->paciente_id; ?>"/>
                            <input type="hidden" name="procedimento1" id="procedimento1" class="texto01" value="<?= $exame[0]->procedimento_tuss_id; ?>"/>
                        </dd>
                        <dt>
                            <label>Guia Convênio</label>
                        </dt>
                        <dd>
                            <input type="text" name="guiaconvenio" id="guiaconvenio" class="texto01" value="<?= $exame[0]->guiaconvenio; ?>"/>
                            <input type="hidden" name="ambulatorio_guia_id" id="ambulatorio_guia_id" class="texto01" value="<?= $exame[0]->ambulatorio_guia_id; ?>"/>
                        </dd>
                        <dt>
                            <label>Faturista</label>
                        </dt>
                        <dd>
                            <input type="text" name="faturista" id="faturista" class="texto01" value="<?= $exame[0]->atendente_fatura; ?>" readonly/>
                        </dd>
                        <dt>
                            <label>Ra&ccedil;a / Cor</label>
                        </dt>
                        <dd>
                            <select name="raca_cor" id="txtRacaCor" class="size2">

                                <option value=0  <?
                                if ($exame[0]->raca_cor == 0):echo 'selected';
                                endif;
                                ?>>Selecione</option>
                                <option value=1 <?
                                if ($exame[0]->raca_cor == 1):echo 'selected';
                                endif;
                                ?>>Branca</option>
                                <option value=2 <?
                                if ($exame[0]->raca_cor == 2):echo 'selected';
                                endif;
                                ?>>Amarela</option>
                                <option value=3 <?
                                if ($exame[0]->raca_cor == 3):echo 'selected';
                                endif;
                                ?>>Preta</option>
                                <option value=4 <?
                                if ($exame[0]->raca_cor == 4):echo 'selected';
                                endif;
                                ?>>Parda</option>
                                <option value=5 <?
                                if ($exame[0]->raca_cor == 5):echo 'selected';
                                endif;
                                ?>>Ind&iacute;gena</option>
                            </select>
                        </dd>
                        <dt>
                         
                            <label>Sala</label>
                            
                        </dt>
                        <dd>
                         
                            <select name="sala" id="sala" class="size2">
                                <option value=""></option>
                                <? foreach ($salas as $value) : ?>
                                    <option value="<?= $value->exame_sala_id; ?>" <?
                                    if ($exame[0]->agenda_exames_nome_id == $value->exame_sala_id):echo 'selected';
                                    endif;
                                    ?>><?php echo $value->nome; ?></option>
                                        <? endforeach; ?>
                            </select>
                        </dd>
                        <dt>
                            <label>Medico</label>
                        </dt>
                        <dd>
                            <select name="medico" id="medico" class="size1">
                                    <option value=""> </option>
                                    <? foreach ($medico as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>"<?
                                        if ($exame[0]->medico_agenda == $value->operador_id):echo 'selected';
                                        endif;
                                        ?>>
                                                    <?php echo $value->nome; ?>

                                        </option>
                                    <? endforeach; ?>

                                </select>
                        </dd>
                        
                        <dt>
                            <label>Medico Solicitante</label>
                        </dt>
                        <dd>
                            <select name="medico_solicitante" id="medico_solicitante" class="size1">
                                    <option value=""> </option>
                                    <? foreach ($medico as $value) : ?>
                                        <option value="<?= $value->operador_id; ?>"<?
                                        if ($exame[0]->medico_solicitante == $value->operador_id):echo 'selected';
                                        endif;
                                        ?>>
                                                    <?php echo $value->nome; ?>

                                        </option>
                                    <? endforeach; ?>

                                </select>
                        </dd>
                        
                        
                        <dt>
                            <label>Observacao</label>
                        </dt>
                        <textarea type="text" name="txtobservacao" cols="55" class="texto12"><?= $exame[0]->observacoes; ?></textarea>
                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    //    (function($){
    //        $(function(){
    //            $('input:text').setMask();
    //        });
    //    })(jQuery);


    $(document).ready(function () {

        function multiplica()
        {
            total = 0;
            valor = parseFloat(document.form_faturar.valorcadastrado.value.replace(",", "."));
            numer1 = parseFloat(document.form_faturar.valor1.value.replace(",", "."));
            total += numer1;

            resultado = total - valor;
            y = resultado.toFixed(2);
            $('#valortotal').val(y);
            $('#novovalortotal').val(y);
//            document.getElementById("valortotal").value = 10;
            //        document.form_faturar.valortotal.value = 10;
        }
        multiplica();


    });
</script>