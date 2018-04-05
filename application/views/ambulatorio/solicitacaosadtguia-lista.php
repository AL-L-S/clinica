
<div class="content ficha_ceatox">
    <!--    <div class="bt_link_new">
            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente['0']->paciente_id ?>');">
                Nova guia
            </a>
        </div>-->
    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $empresa_id = $this->session->userdata('empresa_id');
    $perfil_id = $this->session->userdata('perfil_id');
    $botao_faturar_guia = $this->session->userdata('botao_faturar_guia');
    $botao_faturar_proc = $this->session->userdata('botao_faturar_proc');
    $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
    ?>
    <div>
        <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarprocedimentos" method="post">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
                        if ($paciente['0']->sexo == "M"):echo 'selected';
                        endif;
                        ?>>Masculino</option>
                        <option value="F" <?
                        if ($paciente['0']->sexo == "F"):echo 'selected';
                        endif;
                        ?>>Feminino</option>
                        <option value="O" <?
                        if ($paciente['0']->sexo == "O"):echo 'selected';
                        endif;
                        ?>>Outro</option>
                    </select>
                </div>

                <div>
                    <label>Nascimento</label>
                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>
                    <label>Idade</label>
                    <?
                    if ($paciente['0']->nascimento != '') {
                        $data_atual = date('Y-m-d');
                        $data1 = new DateTime($data_atual);
                        $data2 = new DateTime($paciente[0]->nascimento);

                        $intervalo = $data1->diff($data2);
                        ?>
                        <input type="text" name="idade" id="idade" class="texto02" readonly value="<?= $intervalo->y ?> ano(s)"/>
                    <? } else { ?>
                        <input type="text" name="nascimento" id="txtNascimento" class="texto01" readonly/>
                    <? } ?>
                </div>

                <div>
                    <label>Nome da M&atilde;e</label>
                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
            </fieldset>
        </form>
        <div class="bt_link_new">
            <a href="<?= base_url() ?>ambulatorio/guia/novasolicitacaosadt/<?= $paciente['0']->paciente_id ?>">
                Nova guia
            </a>
        </div>
        <fieldset>
            <table>
                <tr>
                    <th class="tabela_header">Solicitação</th>
                    <th class="tabela_header">Convênio</th>
                    <th class="tabela_header">Solicitante</th>
                    <th class="tabela_header">Data</th>
                    <th class="tabela_header" width="70px;" colspan="3"><center>Detalhes</center></th>
                </tr>
                </thead>
                <?php
                $total = count($guia);
                if ($total > 0) {
                    ?>
                    <tbody>
                        <?php
                        $estilo_linha = "tabela_content01";
                        foreach ($guia as $item) {

                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                            ?>
                            <tr>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->solicitacao_sadt_id; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->convenio; ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= $item->solicitante ?></td>
                                <td class="<?php echo $estilo_linha; ?>"><?= date("d/m/Y H:i:s", strtotime($item->data_cadastro)); ?></td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/guia/cadastrarsolicitacaosadt/<?= $item->solicitacao_sadt_id ?>">Cadastrar</a></div>
                                </td>
                                <td class="<?php echo $estilo_linha; ?>" width="50px;"><div class="bt_link">
                                        <a href="<?= base_url() ?>ambulatorio/guia/impressaosolicitacaosadt/<?= $item->solicitacao_sadt_id ?>">Imprimir</a></div>
                                </td>



                            </tr>
                        <? } ?>


                    </tbody>
                <? } ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="8">
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </fieldset>


    </div>


    <script type="text/javascript">



        $(function () {
            $(".competencia").accordion({autoHeight: false});
            $(".accordion").accordion({autoHeight: false, active: false});
            $(".lotacao").accordion({
                active: true,
                autoheight: false,
                clearStyle: true

            });


        });
    </script>
