<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="bt_link" style="width: 120px;">
        <a onclick="javascript: return confirm('Deseja realmente FINALIZAR? Após esta ação não será possível editar a equipe.');" href="<?= base_url() ?>centrocirurgico/centrocirurgico/finalizarrequipe/<?= $solicitacao_id; ?>" style="width: 100px;">Finalizar Equipe</a></div>      
    <fieldset >
        <legend>Montar Equipe</legend>
        <div>
            <form name="form_cirurgia_orcamento" id="form_cirurgia_orcamento" action="<?= base_url() ?>centrocirurgico/centrocirurgico/gravarequipe" method="post">
                <div style="padding-bottom: 50px;">
                    <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="<?= @$solicitacao_id; ?>"/>
                    <div>
                        <label>Função</label>
                        <select name="funcao" id="funcao" class="texto03" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($funcoes as $value) { ?>
                                <option value="<?= $value->funcao_cirurgia_id ?>"><?= $value->nome ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div>
                        <label>Médico</label>
                        <select name="cirurgiao1" id="cirurgiao1" class="texto04" required>
                            <option value="">SELECIONE</option>
                            <? foreach ($medicos as $value) { ?>
                                <option value="<?= $value->operador_id ?>"
                                ><?= $value->nome ?></option>
                                    <? } ?>
                        </select>
                    </div>
                </div> 
                <hr/>
                <div>
                    <button type="submit" name="btnEnviar">Adicionar</button>
                </div>

            </form>
        </div>
    </fieldset>
    <?php
    if (count($equipe) > 0) {
        ?>
        <fieldset>

            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Função</th>
                        <th class="tabela_header">Médico</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo_linha = "tabela_content01";
                    foreach ($equipe as $item) {
                        ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                        ?>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->nome; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?php echo $item->medico; ?></td>
                        </tr>
                    </tbody>
                <?php }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
                            
                        </th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>
    <? }
    ?>



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
