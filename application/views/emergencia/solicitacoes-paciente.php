<div class="content ficha_ceatox">
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>cadastros/pacientes">
            Voltar
        </a>
    </div>
    <?
    $args['paciente'] = $paciente_id;
    $perfil_id = $this->session->userdata('perfil_id');
    $internacao = $this->session->userdata('internacao');
    $imagem = $this->session->userdata('imagem');
    $consulta = $this->session->userdata('consulta');
    $especialidade = $this->session->userdata('especialidade');
    $geral = $this->session->userdata('geral');
    $faturamento = $this->session->userdata('faturamento');
    $estoque = $this->session->userdata('estoque');
    $financeiro = $this->session->userdata('financeiro');
    $marketing = $this->session->userdata('marketing');
    $laboratorio = $this->session->userdata('laboratorio');
    $ponto = $this->session->userdata('ponto');
    $calendario = $this->session->userdata('calendario');
    $credito = $this->guia->creditoempresa();
    $medicinadotrabalho = $this->session->userdata('medicinadotrabalho');
    ?>

    <fieldset>
        <legend>Solicita&ccedil;&otilde;es do Paciente</legend>
        <div>
            <table>
                <tr>
                    <? if ($imagem == 't') { ?>


                        <td width="80px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente_id ?>">Novo exame</a></div></td>
                    <? } ?>
                    <? if ($consulta == 't') { ?>


                        <td width="80px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/novoconsulta/<?= $paciente_id ?>">Nova consulta</a></div></td>
                    <? } ?>
                    <? if ($especialidade == 't') { ?>


                        <td width="80px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/novofisioterapia/<?= $paciente_id ?>">Nova Especialidade</a></div></td>
                    <? } ?>
                    <? if ($geral == 't') { ?>

                        <td width="80px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/novoatendimento/<?= $paciente_id ?>">Novo Atendimento</a></div></td>
                    <? } ?>
                    <td ><div style="width:80px; text-align: center;" class="bt_linkm botao_pequeno"><a class="botao_pequeno" href="<?= base_url() ?>ambulatorio/guia/pesquisar/<?= $args['paciente'] ?>">Guias</a></div></td>
                    <? if ($imagem != 't') { ?>
                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/acompanhamento/<?= $paciente_id ?>">Acompanhamento</a></div></td>
                    <? } ?>
                        <? if ($medicinadotrabalho == 't') { ?>
                        <td width="40px;"><div class="bt_link_new">
                                                        <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/cadastroaso/<?= $paciente_id ?>/<?= @$obj->_medico_parecer1 ?>');" >
                                                            Cadastro ASO</a></div>
                        </td>
                        <? } ?>
                </tr>
                <tr>
                    <? if ($imagem == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizar/<?= $paciente_id ?>">Autorizar exame</a></div></td>
                    <? } ?>
                    <? if ($consulta == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizarconsulta/<?= $paciente_id ?>">Autorizar consulta</a></div></td>
                    <? } ?>
                    <? if ($especialidade == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizarfisioterapia/<?= $paciente_id ?>">Autorizar Especialidade</a></div></td>
                    <? } ?>
                    <? if ($geral == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>cadastros/pacientes/procedimentoautorizaratendimento/<?= $paciente_id ?>">Autorizar Atendimento</a></div></td>
                    <? } ?>

                    <? if ($perfil_id == 1 || $perfil_id == 5) { ?>
                        <td width="100px;"><div style="width:80px; text-align: center;" class="bt_link_new"><a style="width:80px; text-align: center;" href="<?= base_url() ?>ambulatorio/exametemp/unificar/<?= $paciente_id ?>"> Unificar</a></div></td>
                    <? }
                    ?>






                </tr>
                <tr>
                    <? if ($imagem == 't') { ?>
                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/acompanhamento/<?= $paciente_id ?>">Acompanhamento</a></div></td>
                    <? } ?>
                    <? if ($consulta == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/laudo/carregarlaudohistorico/<?= $paciente_id ?>">Hist. Consulta</a></div></td>
                    <? } ?>
<!--                    <td width="250px;"><div class="bt_link_new"><a href="<?= base_url() ?>emergencia/triagem/gravarsolicitacaotriagem/<?= $paciente_id ?>">triagem</a></div></td>-->
                    <? if ($especialidade == 't') { ?>
                        <td width="250px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/exame/autorizarsessaofisioterapia/<?= $paciente_id ?>">Sessao Especialidade</a></div></td>
                    <? } ?>
                    <td width="250px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/guia/orcamento/<?= $paciente_id ?>">Or&ccedil;amento</a></div></td>

                    <? if ($perfil_id == 1) {
                        ?>
                        <td width="100px;"><div class="bt_link_new botao_pequeno"><a style="width:80px; text-align: center;" href="<?= base_url() ?>ambulatorio/exametemp/excluirpaciente/<?= $paciente_id ?>">Excluir</a></div></td>
                    <? } ?>

<!--                    <td width="250px;"><div class="bt_link"><a href="<?= base_url() ?>emergencia/filaacolhimento/gravarsolicitacao/<?= $paciente_id ?>">Acolhimento</a></div></td>
                <td width="200px;"><div class="bt_link"><a href="<?= base_url() ?>cadastros/pacientes/carregar">Ficha</a></div></td>
                <td width="200px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/novosolicitacaointernacao/<?= $paciente_id ?>">Sol. Interna&ccedil;&atilde;o</a></div></td>
                <td width="200px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/novointernacao/<?= $paciente_id ?>">Internar</a></div></td></tr>-->
                <!--<td width="200px;"><div class="bt_link"><a href="<?= base_url() ?>cadastros/pacientes/carregar">Marcar consulta</a></div></td></tr>-->
                </tr>

                <tr>
                    <? if ($imagem == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/exametemp/carregarpacientetemp/<?= $paciente_id ?>">Exames</a></div></td>
                    <? } ?>

                    <? if ($consulta == 't') { ?>


                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>ambulatorio/exametemp/carregarpacienteconsultatemp/<?= $paciente_id ?>">Consultas</a></div></td>
                    <? } ?>
                    <? if ($credito == 't' && ($perfil_id == 1 || $perfil_id == 5 || $perfil_id == 10 || $perfil_id == 11)) { ?>
                        <td width="100px;"><div class="bt_link_new"><a  href="<?= base_url() ?>ambulatorio/exametemp/listarcredito/<?= $paciente_id ?>">Credito</a></div></td>    
                    <? } ?> 



                    <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>cadastros/pacientes/cancelamento/<?= $paciente_id ?>" target="_blank">Cancelamentos</a></div></td>


                    <td width="100px;"><div class="bt_link_new"  style="width:80px; text-align: center;"><a  style="width:80px; text-align: center;" href="<?= base_url() ?>cadastros/pacientes/anexarimagem/<?= $paciente_id ?>">Arquivos</a></div></td>


                </tr>

                <tr>
                    <? if ($internacao == 't') { ?>
                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/novointernacao/<?= $paciente_id ?>">Internação</a></div></td>
                        <td width="100px;"><div class="bt_link_new"><a href="<?= base_url() ?>internacao/internacao/novosolicitacaointernacao/<?= $paciente_id ?>">Sol.Internação</a></div></td>
                    <? } ?>
                        
                </tr>
            </table>            
        </div>

    </fieldset>
    <div>
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
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
                <div>
                    <label>Nome do Pai</label>


                    <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
                </div>

                <div>
                    <legend>Foto</legend>

                    <!--            <div id="results"> A imagem capturada aparece aqui...</div>-->
                    <img src="<?= base_url() ?>upload/webcam/pacientes/<?= $paciente_id ?>.jpg" alt="" height="140" width="100"  />
                </div>
                <div>
                    <label>CNS</label>


                    <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
                </div>

            </fieldset>
            <fieldset>
                <legend>Documentos</legend>
                <div>
                    <label>CPF</label>


                    <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= $paciente['0']->cpf; ?>" readonly/>
                </div>
                <div>
                    <label>RG</label>


                    <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= $paciente['0']->rg; ?>" readonly/>
                </div>
                <div>
                    <label>Observa&ccedil;&otilde;es</label>


                    <input type  ="text" name="observacao" id="txtObservacao" class="texto10"  value ="<?= $paciente['0']->observacao; ?>" readonly/>

                </div>
                <!--                <div>
                                    <label>UF Expedidor</label>
                
                
                                    <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" value="<?= $paciente['0']->uf_rg; ?>" readonly/>
                                </div>
                                <div>
                                    <div>
                                        <label>Data Emiss&atilde;o</label>
                
                
                                        <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr($paciente['0']->data_emissao, 8, 2) . '/' . substr($paciente['0']->data_emissao, 5, 2) . '/' . substr($paciente['0']->data_emissao, 0, 4); ?>" readonly/>
                                    </div>
                
                                    <div>
                
                                        <label>T. Eleitor</label>
                
                
                                        <input type="text"   name="titulo_eleitor" id="txtTituloEleitor" class="texto02" value="<?= $paciente['0']->titulo_eleitor; ?>" readonly/>
                                    </div>-->




            </fieldset>
            <fieldset>
                <legend>Domicilio</legend>

                <div>
                    <label>Endere&ccedil;o</label>


                    <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= $paciente['0']->logradouro; ?>" readonly/>
                </div>
                <div>
                    <label>N&uacute;mero</label>


                    <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= $paciente['0']->numero; ?>" readonly/>
                </div>
                <div>
                    <label>Bairro</label>


                    <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= $paciente['0']->bairro; ?>" readonly/>
                </div>
                <div>
                    <label>Complemento</label>


                    <input type="text" id="txtComplemento" class="texto06" name="complemento" value="<?= $paciente['0']->complemento; ?>" readonly/>
                </div>

                <div>
                    <label>CEP</label>


                    <input type="text" id="txtCep" class="texto02" name="cep" alt="cep" value="<?= $paciente['0']->cep; ?>" readonly/>
                </div>


                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= $paciente['0']->telefone; ?>" readonly/>
                </div>
                <div>
                    <label>Celular</label>


                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= $paciente['0']->celular; ?>" readonly/>
                </div>
                
            </fieldset>
            <br>
    </div>
    <div class="clear"></div>
</div>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<style>
    .bt_link_new{ width: 150pt; }
    .bt_link_new a{ width: 150pt; }
    .botao_pequeno{ width:80px; text-align: center; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
<script type="text/javascript">

</script>