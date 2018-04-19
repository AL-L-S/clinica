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
                    <dt>
                        <label>Horário Seg á Sex</label>
                    </dt>
                    <dd>
                        <input type="text" id="horario_seg_sex" class="texto05" name="horario_seg_sex" value="<?= @$obj->_horario_seg_sex; ?>" />
                    </dd>
                    <dt>
                        <label>Horário Sab</label>
                    </dt>
                    <dd>
                        <input type="text" id="horario_sab" class="texto05" name="horario_sab" value="<?= @$obj->_horario_sab; ?>" />
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
                            <label>Impressão Orçamento</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_orcamento" class="texto01" name="impressao_orcamento" value="<?= @$obj->_impressao_orcamento; ?>" />
                        </dd>
                        <dt>
                            <label>Impressão Declaração</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_declaracao" class="texto01" name="impressao_declaracao" value="<?= @$obj->_impressao_declaracao; ?>" />
                        </dd>
                        <dt>
                            <label>Endereço Externo Cadastro</label>
                        </dt>
                        <dd>
                            <input type="text" id="endereco_externo" class="texto08" name="endereco_externo" value="<?= @$obj->_endereco_externo; ?>" />
                        </dd>
                        <dt>
                            <label>Numero Empresa (Painel)</label>
                        </dt>
                        <dd>
                            <input type="text" id="numero_empresa_painel" name="numero_empresa_painel" class="texto05" value="<?= @$obj->_numero_empresa_painel; ?>" />
                        </dd>
                        <div>
                            <dt>
                                <label title="Definir os campos que serao obrigatorios no cadastro de paciente.">Campos Obrigatorios</label>
                            </dt>
                            <dd>
                                <select name="campos_obrigatorio[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                                    <option value="dt_nascimento" <?= (@$obj->_campos_obrigatorios_pac_nascimento == 't') ? 'selected' : ''; ?>>Nascimento</option>
                                    <option value="sexo" <?= (@$obj->_campos_obrigatorios_pac_sexo == 't') ? 'selected' : ''; ?>>Sexo</option>
                                    <option value="cpf" <?= (@$obj->_campos_obrigatorios_pac_cpf == 't') ? 'selected' : ''; ?>>CPF</option>
                                    <option value="telefone" <?= (@$obj->_campos_obrigatorios_pac_telefone == 't') ? 'selected' : ''; ?>>Telefone</option>
                                    <option value="municipio" <?= (@$obj->_campos_obrigatorios_pac_municipio == 't') ? 'selected' : ''; ?>>Municipio</option>
                                </select>
                            </dd>
                        </div>
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
                            <label title="Ativando essa flag, oftamologia irá aparecer na consulta.">Oftamologia</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="oftamologia" name="oftamologia" <? if (@$obj->_oftamologia == 't') echo "checked"; ?>/> 
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
                            <label title="Habilitar Internação.">Farmácia</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="internacao" name="farmacia" <? if (@$obj->_farmacia == 't') echo "checked"; ?>/> 
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
                            <label title="Habilitar o layout de calendario criado para a MED (apenas na multifunção geral).">Calendario (layout personalizado)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="calendario_layout" name="calendario_layout" <? if (@$obj->_calendario_layout == 't') echo "checked"; ?>/> 
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
                            <label title="Impressao .">Ficha Configurável</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="ficha_config" name="ficha_config" <? if (@$obj->_ficha_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Declaração Configurável</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="declaracao_config" name="declaracao_config" <? if (@$obj->_declaracao_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Impressao .">Atestado Configurável</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="atestado_config" name="atestado_config" <? if (@$obj->_atestado_config == 't') echo "checked"; ?>/> 
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
                        <dt>
                            <label title="Ativando essa flag, o manter indicação irá aparecer nas configurações.">Tornar a recomendação configuravel.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="recomendacao_configuravel" name="recomendacao_configuravel" <? if (@$obj->_recomendacao_configuravel == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, ao adcionar ou autorizar um(a) novo(a) exame/consulta o campo recomendação é obrigatorio.">Tornar a recomendação Obrigatorio.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="recomendacao_obrigatorio" name="recomendacao_obrigatorio" <? if (@$obj->_recomendacao_obrigatorio == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o manter indicação irá aparecer nas configurações.">Botão de reativar sala.</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="botao_ativar_sala" name="botao_ativar_sala" <? if (@$obj->_botao_ativar_sala == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o botão de cancelar na sala de espera irá aparecer.">Cancelar Sala de Espera</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="cancelar_sala_espera" name="cancelar_sala_espera" <? if (@$obj->_cancelar_sala_espera == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, a fila de caixa vai ser ativada.">Fila de Caixa</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="fila_caixa" name="fila_caixa" <? if (@$obj->_caixa == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o valor do promotor vai ser descontado do médico.">Tirar Valor Promotor do médico</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="promotor_medico" name="promotor_medico" <? if (@$obj->_promotor_medico == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o valor do promotor vai ser descontado do médico.">Excluir Transferência (Financeiro)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="excluir_transferencia" name="excluir_transferencia" <? if (@$obj->_excluir_transferencia == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o login será obrigatório no Sistema de Pacientes.">Login no Sistema de Paciente</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="login_paciente" name="login_paciente" <? if (@$obj->_login_paciente == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o crédito irá aparecer no sistema.">Aparecer Crédito</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="credito" name="credito" <? if (@$obj->_credito == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o valor do recibo sera o da Guia.">Valor do Recibo é o da guia</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="valor_recibo_guia" name="valor_recibo_guia" <? if (@$obj->_valor_recibo_guia == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o orçamento será configurável.">Orçamento Configurável</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="orcamento_config" name="orcamento_config" <? if (@$obj->_orcamento_config == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, valor da odontologia poderá ser alterado ao lançar.">Valor da Odontologia Alterável</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="odontologia_valor_alterar" name="odontologia_valor_alterar" <? if (@$obj->_odontologia_valor_alterar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, quando o sistema encontrar um procedimento com retorno no sistema, ele irá perguntar se a pessoa deseja associar, se sim, ele irá automáticamente selecionar o procedimento
                                   Caso isso não esteja ativado, o sistema vai tirar a seleção do procedimento.">Selecionar Retorno Automaticamente</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="selecionar_retorno" name="selecionar_retorno" <? if (@$obj->_selecionar_retorno == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o administrador TOTAL pode cancelar na sala de espera.">Administrador cancelar na sala de espera</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="administrador_cancelar" name="administrador_cancelar" <? if (@$obj->_administrador_cancelar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, a gerente de recepção consegue lançar despesas no contas a pagar">Gerente de Recepção Contas a Pagar</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="gerente_contasapagar" name="gerente_contasapagar" <? if (@$obj->_gerente_contasapagar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o cpf fica obrigatório no cadastro">CPF Obrigatório (Paciente)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="cpf_obrigatorio" name="cpf_obrigatorio" <? if (@$obj->_cpf_obrigatorio == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o preço procedimento aparece para a Recepção">Perfis da recepção Preço Procedimento</label>
                        </dt>

                        <dd>
                            <input type="checkbox" id="orcamento_recepcao" name="orcamento_recepcao" <? if (@$obj->_orcamento_recepcao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o relatório de ordem de atendimento aparece">Relatório Ordem de Atendimento</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="relatorio_ordem" name="relatorio_ordem" <? if (@$obj->_relatorio_ordem == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o relatório de produção nas telas de atendimento aparece">Relatório Produção (Nas telas do médico)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="relatorio_producao" name="relatorio_producao" <? if (@$obj->_relatorio_producao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, os relatórios aparecem para recepção e recepção agendamento">Relatórios para recepção</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="relatorios_recepcao" name="relatorios_recepcao" <? if (@$obj->_relatorios_recepcao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o financeiro tem acesso ao Fila Caixa e ao cadastro de pacientes">Financeiro Cadastro Paciente (Faturar)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="financeiro_cadastro" name="financeiro_cadastro" <? if (@$obj->_financeiro_cadastro == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o valor aparece ao autorizar procedimentos aparece">Valor aparece ao autorizar procedimentos</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="valor_autorizar" name="valor_autorizar" <? if (@$obj->_valor_autorizar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, os botões para imprimir a ficha não serão mostrados.">Retirar botões de Ficha</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="retirar_botao_ficha" name="retirar_botao_ficha" <? if (@$obj->_retirar_botao_ficha == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, as opçoes de impressao, tais como assinatura e carimbo, deixaram de aparecer na tela do médico.">Desativar personalização da impressao dos medicos</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="desativar_personalizacao_impressao" name="desativar_personalizacao_impressao" <? if (@$obj->_desativar_personalizacao_impressao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, quando encaminhar um paciente será disparado um email para o médico que recebe (Padrão Citycor).">Encaminhamento Email</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="encaminhamento_email" name="encaminhamento_email" <? if (@$obj->_encaminhamento_email == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, quando só tiver um modelo de receituario cadastrado ele será carregado automaticamente.">Carregar Modelo Receiturario Automaticamente</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="carregar_modelo_receituario" name="carregar_modelo_receituario" <? if (@$obj->_carregar_modelo_receituario == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o relatorio de caixa normal some e so fica disponivel o caixa personalizado. Além dsso os relatorios de caixa cartão irão ficar com o layout do personalizado e o rel. previsão irá sumir.">Caixa personalizado</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="caixa_personalizado" name="caixa_personalizado" <? if (@$obj->_caixa_personalizado == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, o sistema não irá mais barrar o lançamento de procedimentos do tipo Retorno.">Desabilitar trava no Retorno</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="desabilitar_trava_retorno" name="desabilitar_trava_retorno" <? if (@$obj->_desabilitar_trava_retorno == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Desativando essa flag, na tela de crédito o usuário irá informar apenas o valor do crédito (sem travar o crédito ao valor de procedimentos).">Crédito associado a procedimentos</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="associa_credito_procedimento" name="associa_credito_procedimento" <? if (@$obj->_associa_credito_procedimento == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa flag, no momento de criar a agenda, aparece uma opçao para o usuario informar quantas vezes ele ira querer repetir os horarios.">Permitir criação de horarios repetidos na agenda.</label>

                        </dt>
                        <dd>
                            <input type="checkbox" id="repetir_horarios_agenda" name="repetir_horarios_agenda" <? if (@$obj->_repetir_horarios_agenda == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                        <label title="O laudo só vai ser editado pelo nosso operador">Laudo Sigiloso</label>
                           
                        </dt>
                        <dd>
                            <input type="checkbox" id="laudo_sigiloso" name="laudo_sigiloso" <? if (@$obj->_laudo_sigiloso == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>

                             <label title="Nome do cônjuge e data de nascimento do mesmo">Nome do cônjuge</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="conjuge" name="conjuge" <? if (@$obj->_conjuge == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="O valor do laboratório é retirado antes do valor do médico no relatório de produção médica">Valor do Laboratório (Produção médica)</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="valor_laboratorio" name="valor_laboratorio" <? if (@$obj->_valor_laboratorio == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="A técnica irá poder chamar na tela de atendimento">Técnica Chamar</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="tecnica_enviar" name="tecnica_enviar" <? if (@$obj->_tecnica_enviar == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Técnica alterar o promotor">Promotor Sala de Espera</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="valor_laboratorio" name="tecnica_promotor" <? if (@$obj->_tecnica_promotor == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="O valor do laboratório é retirado antes do valor do médico no relatório de produção médica">Profissional Convênio Completo</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="profissional_completo" name="profissional_completo" <? if (@$obj->_profissional_completo == 't') echo "checked"; ?>/> 
                        </dd>
                        
                        <dt>
                            <label title="Ao ativar, irá aparecer uma tela para cadastrar subgrupos no sistema (associados aos grupos). Isso pode ser usado no relátorio de conferência.">Subgrupo de Procedimento</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="subgrupo_procedimento" name="subgrupo_procedimento" <? if (@$obj->_subgrupo_procedimento == 't') echo "checked"; ?>/> 
                        </dd>
                        
                        <dt>
                            <label title="Ao ativar, o sistema irá solicitar a senha do medico responsavel para finalizar o laudo. Do contrário, não será necessário.">Solicitar Senha ao Finalizar Laudo</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="senha_finalizar_laudo" name="senha_finalizar_laudo" <? if (@$obj->_senha_finalizar_laudo == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="No lançamento de procedimentos não aparece o valor de procedimentos não particulares.">Valor Convenio não aparecer</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="valor_convenio_nao" name="valor_convenio_nao" <? if (@$obj->_valor_convenio_nao == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa opção, as flags de medico solicitante e ocupação no painel não irão aparecer no cadastro de profissionais">Retirar flag de solicitante</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="retirar_flag_solicitante" name="retirar_flag_solicitante" <? if (@$obj->_retirar_flag_solicitante == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa opção, ao criar uma sala, o sistema irá criar vincular 10 paineis automaticamente.">Vincular paineis ao criar salas</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="cadastrar_painel_sala" name="cadastrar_painel_sala" <? if (@$obj->_cadastrar_painel_sala == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Ativando essa opção, o sistema so irá disponibilizar o botão de procedimentos multiplos.">Deixar apenas procedimentos múltiplos</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="apenas_procedimentos_multiplos" name="apenas_procedimentos_multiplos" <? if (@$obj->_apenas_procedimentos_multiplos == 't') echo "checked"; ?>/> 
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
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/chosen.css">
<!--<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/style.css">-->
<link rel="stylesheet" href="<?= base_url() ?>js/chosen/docsupport/prism.css">
<script type="text/javascript" src="<?= base_url() ?>js/chosen/chosen.jquery.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/prism.js"></script>-->
<script type="text/javascript" src="<?= base_url() ?>js/chosen/docsupport/init.js"></script>
<script type="text/javascript">
//    $('#btnVoltar').click(function () {
//        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
//    });

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
