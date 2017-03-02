<div class="content ficha_ceatox">
    <div >
        <?
        $sala = "";
        $ordenador1 = "";
        $sala_id = "";
        $medico_id = "";
        $medico = "";
        $medico_solicitante = "";
        $medico_solicitante_id = "";
        $convenio_paciente = "";
        $empresa_id = $this->session->userdata('empresa_id');
        ?>
        <h3 class="singular"><a href="#">Faturar Guia</a></h3>
        <div>
            <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentosfaturamento" method="post">
                <fieldset>
                    <legend>Dados do Paciente</legend>
                    <div>
                        <label>Nome</label>                      
                        <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                        <input type="hidden" id="txtpaciente_id" name="txtpaciente_id"  value="<?= $paciente_id; ?>"/>
                        <input type="hidden" id="txtguia_id" name="txtguia_id"  value="<?= $guia_id; ?>"/>
                    </div>
                    <div>
                        <label>Sexo</label>
                        <input type="text" id="sexo" name="sexo"  class="texto02" value="<?
                        if ($paciente['0']->sexo == "M"):echo 'Masculino';
                        endif;
                        if ($paciente['0']->sexo == "F"):echo 'Feminino';
                        endif;
                        ?>" readonly=""/>
                    </div>

                    <div>
                        <label>Nascimento</label>


                        <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                    </div>

                    <div>
                        <label>Nome da M&atilde;e</label>
                        <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                    </div>
                </fieldset>

                <fieldset>

                    <table id="table_justa">
                        <thead>

                            <tr>
                                <th class="tabela_header">Procedimento</th>
                                <th class="tabela_header">Convenio</th>
                                <th class="tabela_header">Tipo</th>
                                <th class="tabela_header">V. Unit</th>
                                <th class="tabela_header">Horario Especial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $estilo_linha = "tabela_content01";
                            $total = 0;
                            foreach ($procedimentos as $item):
                                ?>
                                <tr>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->procedimento; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->tipo; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= $item->valor_total; ?></td>
                                    <td class="<?php echo $estilo_linha; ?>"><?= ($item->horario_especial == 't') ? 'SIM' : 'NÃO'; ?></td>
                                </tr>
                                <?
                                $total += (float) $item->valor_total;
                                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            endforeach;
                            ?>

                        </tbody>
                    </table>

                    <table>
                        <thead>
                        <th class="tabela_footer" colspan="6">
                            Valor Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
                        </th>
                        <th colspan="2">
                            <div class="bt_link_new">
                                <a onclick="javascript:window.open('<?= base_url() . "ambulatorio/guia/faturaramentomanualguias/" . $guia_id; ?> ');">Faturar Guia
                                </a>
                            </div>
                        </th>
                        </thead>
                    </table> 
                </fieldset>
            </form>
        </div> 
    </div> 
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


</script>