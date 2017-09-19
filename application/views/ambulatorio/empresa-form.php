<div class="content"> <!-- Inicio da DIV content -->
    <style>
        #accordion dl dt{
            min-width:300pt;
        }
    </style>
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Empresa</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>ambulatorio/empresa/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtempresaid" class="texto08" value="<?= @$obj->_empresa_id; ?>" />
                        <input type="text" name="txtNome" class="texto08" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto08" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social (XML)</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocialxml" id="txtrazaosocial" class="texto08" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJ" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>
                    <dt>
                        <label>CNPJ (XML)</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNPJxml" maxlength="14" alt="cnpj" class="texto03" value="<?= @$obj->_cnpj; ?>" />
                    </dd>
                    <dt>
                        <label>CNES</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCNES" maxlength="14" class="texto03" value="<?= @$obj->_cnes; ?>" />
                    </dd>
                    <dt>
                        <label>Endere&ccedil;o</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtendereco" class="texto08" name="endereco" value="<?= @$obj->_logradouro; ?>" />
                    </dd>
                    <dt>
                        <label>N&uacute;mero</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= @$obj->_numero; ?>" />
                    </dd>
                    <dt>
                        <label>Bairro</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= @$obj->_bairro; ?>" />
                    </dd>
                    <dt>
                        <label>CEP</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCEP" class="texto02" name="CEP" alt="cep" value="<?= @$obj->_cep; ?>" />
                    </dd>
                    <dt>
                        <label>Telefone</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" alt="phone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <input type="text" id="txtCelular" class="texto03" name="celular" alt="phone" value="<?= @$obj->_celular; ?>" />
                    </dd>
                    <dt>
                        <label>Email</label>
                    </dt>
                    <dd>
                        <input type="text" id="email" class="texto03" name="email" value="<?= @$obj->_email; ?>" />
                    </dd>
                    <dt>
                        <label>Município</label>
                    </dt>
                    <dd>
                        <input type="hidden" id="txtCidadeID" class="texto_id" name="municipio_id" value="<?= @$obj->_municipio_id; ?>" readonly="true" />
                        <input type="text" id="txtCidade" class="texto04" name="txtCidade" value="<?= @$obj->_municipio; ?>" />
                    </dd>

                    <? if ($this->session->userdata('operador_id') == 1) { ?>

                        <dt>
                            <label>Serviço de SMS</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="sms" name="sms" <? if (@$obj->_servicosms == 't') echo "checked"; ?>/>
                        </dd>
                        <dt>
                            <label title="Mandar email para os pacientes lembrando das consultas.">Serviço de Email</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="servicoemail" name="servicoemail" <? if (@$obj->_servicoemail == 't') echo "checked"; ?>/>
                        </dd>
                        <dt>
                            <label title="Habilitar o chat.">Serviço de Chat</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="chat" name="chat" <? if (@$obj->_chat == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label>Impressão Tipo (Impressão ficha e imagem)</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_tipo" class="texto01" name="impressao_tipo" value="<?= @$obj->_impressao_tipo; ?>" />
                        </dd>
                        <dt>
                            <label>Impressão Laudo</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_laudo" class="texto01" name="impressao_laudo" value="<?= @$obj->_impressao_laudo; ?>" />
                        </dd>
                        <dt>
                            <label>Impressão Recibo</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_recibo" class="texto01" name="impressao_recibo" value="<?= @$obj->_impressao_recibo; ?>" />
                        </dd>
                        <dt>
                            <label>Impressão Declaração</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_declaracao" class="texto01" name="impressao_declaracao" value="<?= @$obj->_impressao_declaracao; ?>" />
                        </dd>
                        <dt>
                            <label title="Habilitar Modulo de Imagem.">Imagem</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="imagem" name="imagem" <? if (@$obj->_imagem == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Modulo de Consulta.">Consulta</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="consulta" name="consulta" <? if (@$obj->_consulta == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Modulo de Especialidade.">Especialidade</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="especialidade" name="especialidade" <? if (@$obj->_especialidade == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Modulo de Odontologia.">Odontologia</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="odontologia" name="odontologia" <? if (@$obj->_odontologia == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Laboratorio.">Laboratorio</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="laboratorio" name="laboratorio" <? if (@$obj->_laboratorio == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Geral.">Geral</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="geral" name="geral" <? if (@$obj->_geral == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Faturamento.">Faturamento</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="faturamento" name="faturamento" <? if (@$obj->_faturamento == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Estoque.">Estoque</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="estoque" name="estoque" <? if (@$obj->_estoque == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Financeiro.">Financeiro</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="financeiro" name="financeiro" <? if (@$obj->_financeiro == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Marketing.">Marketing</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="marketing" name="marketing" <? if (@$obj->_marketing == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Internação.">Internação</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="internacao" name="internacao" <? if (@$obj->_internacao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Centro Cirurgico.">Centro Cirurgico</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="centro_cirurgico" name="centro_cirurgico" <? if (@$obj->_centro_cirurgico == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Ponto.">Ponto</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="ponto" name="ponto" <? if (@$obj->_ponto == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Calendario.">Calendario</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="calendario" name="calendario" <? if (@$obj->_calendario == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Calendario.">Chamar Consulta na sala de espera</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="chamar_consulta" name="chamar_consulta" <? if (@$obj->_chamar_consulta == 't') echo "checked"; ?>/> 
                        </dd>

                        <dt>
                            <label title="Aparecer o botão de faturar procedimento no cadastro.">Botão Faturar Procedimentos</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="calendario" name="botao_faturar_proc" <? if (@$obj->_botao_faturar_proc == 't') echo "checked"; ?>/> 
                        </dd>

                        <dt>
                            <label title="Aparecer  o botão de faturar guia no cadastro.">Botão Faturar Guia</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="calendario" name="botao_faturar_guia" <? if (@$obj->_botao_faturar_guia == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Procedimentos separados por empresa.">Proc. Multiempresa</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="procedimentos_multiempresa" name="procedimentos_multiempresa" <? if (@$obj->_procedimento_multiempresa == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Data manual na produção médica .">Data Manual Produção M.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="data_contaspagar" name="data_contaspagar" <? if (@$obj->_data_contaspagar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Médico pode pesquisar por outros médicos no Laudo Digitador .">Medico Laudo Digitador.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="data_contaspagar" name="medico_laudodigitador" <? if (@$obj->_medico_laudodigitador == 't') echo "checked"; ?>/> 
                        </dd>

                        <dt>
                            <label title="Impressao .">Cabeçalho Configurável.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="cabecalho_config" name="cabecalho_config" <? if (@$obj->_cabecalho_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Rodapé Configurável.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="rodape_config" name="rodape_config" <? if (@$obj->_rodape_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Laudo Configurável.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="laudo_config" name="laudo_config" <? if (@$obj->_laudo_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Recibo Configurável.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="recibo_config" name="recibo_config" <? if (@$obj->_recibo_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Ficha/Declaração/Atestado Configurável.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="ficha_config" name="ficha_config" <? if (@$obj->_ficha_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ao fechar a produção médica, os valores ja irão cair como saida no Financeiro.">Produção Médica ir direto para Saida</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="producao_medica_saida" name="producao_medica_saida" <? if (@$obj->_producao_medica_saida == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ao asssociar procedimentos aos médicos (CONFIGURAÇÕES - RECEPÇÃO - LISTAR PROFISSIONAIS - CONVÊNIO), estes serão tratados como exceção.">Cadastrar procedimentos como exceção.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="procedimento_excecao" name="procedimento_excecao" <? if (@$obj->_procedimento_excecao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ordem de chegada na sala de espera">Ordem de Chegada.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="procedimento_excecao" name="ordem_chegada" <? if (@$obj->_ordem_chegada == 't') echo "checked"; ?>/> 
                        </dd>
                    <? } ?>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(function () {
        $("#txtCidade").autocomplete({
            source: "<?= base_url() ?>index.php?c=autocomplete&m=cidade",
            minLength: 3,
            focus: function (event, ui) {
                $("#txtCidade").val(ui.item.label);
                return false;
            },
            select: function (event, ui) {
                $("#txtCidade").val(ui.item.value);
                $("#txtCidadeID").val(ui.item.id);
                return false;
            }
        });
    });

    $(document).ready(function () {
        jQuery('#form_empresa').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>
