<div class="content ficha_ceatox">
    <div >
        <fieldset>
            <legend>A&ccedil;&otilde;es da Interna&ccedil;&atilde;o</legend>
            <div>
                <table BORDER="1">

                    <tr><td width="1000px;"><a href="<?= base_url() ?>cadastros/pacientes/carregar/<?= $paciente_id ?>">Editar paciente</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>internacao/internacao/movimentacao/<?= $paciente_id ?>">Movimenta&ccedil;&atilde;o</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>cadastros/pacientes/carregar">Abrir Ficha</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>internacao/internacao/novosolicitacaointernacao/<?= $paciente_id ?>">Solicitar Interna&ccedil;&atilde;o</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>internacao/internacao/novointernacao/<?= $paciente_id ?>">Internar</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>cadastros/pacientes/carregar">Marcar consulta</a></td></tr>
                    <tr><td width="200px;" ><a href="<?= base_url() ?>cadastros/pacientes/carregar">Solicitar exame de imagem</a></td></tr>
                    <tr><td width="200px;"><a href="<?= base_url() ?>cadastros/pacientes/carregar">Solicitar exame de laboratorial</a></td></tr>                                       

                </table>

            </div>
        </fieldset>
    </div>
    <div>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
            <fieldset>
                <legend>Dados do Pacienete</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <? if ($paciente['0']->sexo == "M"):echo 'selected';
endif;
?>>Masculino</option>
                        <option value="F" <? if ($paciente['0']->sexo == "F"):echo 'selected';
                                endif;
?>>Feminino</option>
                    </select>
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>

                <div>

                    <label>Idade</label>
                    <input type="text" name="idade" id="txtIdade" class="texto01" alt="numeromask" value="<?= $paciente['0']->idade; ?>" readonly />

                </div>

                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
                <div>
                    <label>Nome do Pai</label>


                    <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
                </div>
                <div>
                    <label>CNS</label>


                    <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
                </div>

            </fieldset>
            <fieldset>
                <legend>Dados da Interna&ccedil;&atilde;o</legend>
                <div>
                    <label>Data da interna&ccedil;&atilde;o</label>                      
                    <input type="text" id="txtdata_internacao" name="data_internacao"  class="texto06" value="<?= $internacao['0']->data_internacao; ?>" readonly/>
                </div>
                <div>
                    <label>Medico</label>
                    <input type="text" name="medico" id="txtmedico" class="texto08" value="<?= $internacao['0']->medico; ?>" readonly/>
                </div>
                <div>
                    <label>Procedimento solicitado</label>
                    <input type="text" name="procedimeto" id="txtprocedimeto" class="texto12" value="<?= $internacao['0']->procedimentosolicitado . "-" . $internacao['0']->descricao; ?>" readonly />
                </div>
                <div>
                    <label>CID solicitaddo</label>
                    <input type="text" name="cid" id="txtcid" class="texto10" value="<?= $internacao['0']->codcid . "-" . $internacao['0']->nomecid; ?>" readonly/>
                </div>
                <div>
                    <label>Estado do paciente</label>
                    <input type="text" name="cid" id="txtcid" class="texto10" value="<?= $internacao['0']->estado ?>" readonly/>
                </div>
            </fieldset>
            <fieldset>
                <legend>Movimentacao do paciente</legend>
                <div>
                    <?
                    $i = 1;
                    $p = count($leitos);

                    foreach ($leitos as $item):
                        ?>
                        <table>
                            <?
                            if ($i == 1):
                                ?>       <tr><td width="1000px;">Em <?= "<b>" . substr($item->data_cadastro, 8, 2) . "-" . substr($item->data_cadastro, 5, 2) . "-" . substr($item->data_cadastro, 0, 4) . " " . substr($item->data_cadastro, 11, 8) . "</b>" . " Internado no leito: <b>" . $item->leito . " ( " . $item->enfermaria . " - " . $item->unidade . " ) " . "OPERADOR: " . $item->operador . "</b>" ?></td></tr>
                                <?
                            endif;
                            if ($i <= $p && $i != 1):
                                ?>
                                <tr><td width="1000px;">Em <?= "<b>" . substr($item->data_cadastro, 8, 2) . "-" . substr($item->data_cadastro, 5, 2) . "-" . substr($item->data_cadastro, 0, 4) . " " . substr($item->data_cadastro, 11, 8) . "</b>" . " Transferido para o leito: <b>" . $item->leito . " ( " . $item->enfermaria . " - " . $item->unidade . " ) " . "OPERADOR: " . $item->operador . "</b>" ?></td></tr>                        
                            <?
                            endif;
                            $i++;
                            ?>
                        </table>
<? endforeach; ?>
                </div>
            </fieldset>
    </div>
    <div>
        <br>
    </div>

</div>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script type="text/javascript">

</script>