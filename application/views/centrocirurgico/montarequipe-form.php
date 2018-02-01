<div class="content ficha_ceatox"> <!-- Inicio da DIV content --> 
    <h3 class="singular"><a href="#">Montar Equipe</a></h3>
    <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarequipeoperadores" method="post">
        <fieldset>
            <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacaocirurgia_id; ?>"/>
            <div>
                <label>Médico</label>
                <select name="medico" id="medico" class="texto04" required>
                    <option value="">SELECIONE</option>
                    <? foreach ($medicos as $value) { ?>
                        <option value="<?= $value->operador_id ?>"
                                ><?= $value->nome ?></option>
                            <? } ?>
                </select>
            </div>
            <div>
                <label>Função</label>
                <select name="funcao" id="funcao" class="texto03" required>
                    <option value="">SELECIONE</option>
                    <? foreach ($grau_participacao as $value) : ?>
                        <option value="<?= $value->codigo ?>"><?= $value->grau_participacao ?></option>
                    <? endforeach; ?>
                </select>
            </div>
<!--            <div>
                <label>Valor</label>
                <input type="text" name="valor" id="valor" alt="decimal" class="texto01" required=""/>
            </div>-->
            <div style="width: 100%">
                <hr/>
                <div>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </div>
            </div>
        </fieldset>
    </form>

    <?php
    if (count($equipe_operadores) > 0) {
        ?>
        <fieldset>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Médico</th>
                        <th class="tabela_header">Função</th>
                        <th class="tabela_header" width="30px;" ><center></center></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($equipe_operadores as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->medico; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->funcao; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="30px;" style="width: 60px;">
                                <a href="<?= base_url() ?>centrocirurgico/centrocirurgico/excluiritemequipe/<?= $item->equipe_cirurgia_operadores_id; ?>/<?= @$solicitacaocirurgia_id; ?>" class="delete">
                                </a>
                            </td>

                        </tr>
                    <? } ?>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="8"></th>
                        </tr>
                    </tfoot>
                </table>
            </fieldset>
    
            <div class="bt_link_new">
                <a href="<?php echo base_url() ?>centrocirurgico/centrocirurgico/finalizarequipecirurgica/<?= @$solicitacaocirurgia_id; ?>">
                    Finalizar Equipe
                </a>
            </div>
    <? } ?>




</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.maskedinput.js"></script>
<script type="text/javascript">

    $(function () {
        $('#procedimento1').change(function () {
            if ($(this).val()) {
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/procedimentovalororcamento', {procedimento1: $(this).val(), convenio: $("#convenio_id").val()}, function (j) {
                    options = "";
                    options += j[0].valortotal;
//                    b = options.toPrecision(2);
                    document.getElementById("valor1").value = options.replace(".", ",");
                    $('.carregando').hide();
                });
            } else {
                $('#valor1').html('value=""');
            }
        });
    });


</script>
