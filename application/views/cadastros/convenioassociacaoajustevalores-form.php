<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/convenio">
            Voltar
        </a>

    </div>
    <div id="accordion">
        <h3 class="singular"><a href="#">Ajuste Valor Convenio</a></h3>
        <div>
            <form name="form_desconto" id="form_desconto" action="<?= base_url() ?>cadastros/convenio/gravarvaloresassociacao" method="post">
                <input type="hidden" name="convenio_secundario_id" value="<?php echo $convenio_id; ?>"/>
                <table>
                    <tr>
                        <td style="font-weight: bold">GRUPO</td>
                        <td style="font-weight: bold">CONVENIO</td>
                        <td style="font-weight: bold">VALOR (%)</td>
                    </tr>
                    <? 
                    $i = 0;
                    foreach($grupos as $value){ 
                        $cv = '';
                        $vl = '';
                        $c_id = '';
                        foreach ($associacoes as $assoc) {
                            if($value->nome == $assoc->grupo) {
                                $cv = $assoc->convenio_primario_id;
                                $vl = $assoc->valor_percentual;
                                $c_id = $assoc->convenio_secudario_associacao_id;
                                break;   
                            }
                            
                        } ?>
                        <tr>
                            <td>
                                <input type="text" name="grupo[<?= $i; ?>]" value="<?php echo $value->nome; ?>" readonly="" style="width: 250pt"/>
                                <input type="hidden" name="convenio_associacao_id[<?= $i; ?>]" value="<?= $c_id; ?>"/>
                            </td>
                            <td>
                                <select name="convenio[<?= $i; ?>]">
                                    <option value="">Selecione</option>
                                    <? foreach($convenios as $item){ 
                                        if($item->convenio_id == $convenio_id) continue; ?>
                                        <option value="<?= $item->convenio_id; ?>" <?= $item->convenio_id == @$cv ? "selected" : ""?>>
                                            <?php echo $item->nome; ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </td>
                            <td><input type="number" name="valor[<?= $i; ?>]" id="valor" step="0.01" value="<?= @$vl?>"/></td>
                        </tr>
                        <? 
                        $i++;
                    } ?>
                </table> 

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
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

//                            $(document).ready(function () {
//
//                                function multiplica()
//                                {
//                                    total = 0;
//                                    numer2 = document.form_desconto.valorch.value;
//                                    numer4 = document.form_desconto.valorfilme.value;
//                                    numer6 = document.form_desconto.valoruco.value;
//                                    numer8 = document.form_desconto.valorporte.value;
//                                    total += soma2 + soma4 + soma6 + soma8;
////                                    y = total.toFixed(2);
////                                    $('#valortotal').val(y);
//                                    document.form_desconto.valortotal.value = total;
//                                }
//                                multiplica();
//
//
//                            });

</script>