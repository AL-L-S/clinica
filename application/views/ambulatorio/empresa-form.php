
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
                        <?
//                        if (@$obj->_telefone != '' && strlen(@$obj->_telefone) > 3) {
//
//                            if (preg_match('/\(/', @$obj->_telefone)) {
//                                $telefone = @$obj->_telefone;
//                            } else {
//                                $telefone = "(" . substr(@$obj->_telefone, 0, 2) . ")" . substr(@$obj->_telefone, 2, strlen(@$obj->_telefone) - 2);
//                            }
//                        } else {
//                            $telefone = '';
//                        }
                        ?>
                        <input type="text" id="txtTelefone" class="texto03" name="telefone" value="<?= @$obj->_telefone; ?>" />
                    </dd>
                    <dt>
                        <label>Celular</label>
                    </dt>
                    <dd>
                        <?
//                        if (@$obj->_celular != '' && strlen(@$obj->_celular) > 3) {
//                            if (preg_match('/\(/', @$obj->_celular)) {
//                                $celular = @$obj->_celular;
//                            } else {
//                                $celular = "(" . substr(@$obj->_celular, 0, 2) . ")" . substr(@$obj->_celular, 2, strlen(@$obj->_celular) - 2);
//                            }
//                        } else {
//                            $celular = '';
//                        }
                        ?>
                        <input type="text" id="txtCelular" class="texto03" name="celular" value="<?= @$obj->_celular; ?>" />
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
                        <label>Horário Seg à Sex</label>
                    </dt>
                    <dd>
                        <input type="text" id="horSegSexta_i" class="texto01" name="horSegSexta_i" alt="29:99" value="<?= @$obj->_horario_seg_sex_inicio; ?>" /> às
                        <input type="text" id="horSegSexta_f" class="texto01" name="horSegSexta_f" alt="29:99" value="<?= @$obj->_horario_seg_sex_fim; ?>" />
                    </dd>
                    <dt>
                        <label>Horário Sab</label>
                    </dt>
                    <dd>
                        <input type="text" id="horSab_i" class="texto01" name="horSab_i" alt="29:99" value="<?= @$obj->_horario_sab_inicio; ?>" /> às
                        <input type="text" id="horSab_f" class="texto01" name="horSab_f" alt="29:99" value="<?= @$obj->_horario_sab_fim; ?>" />
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
                            <label>Impressão Internação</label>
                        </dt>
                        <dd>
                            <input type="text" id="impressao_internacao" class="texto01" name="impressao_internacao" value="<?= @$obj->_impressao_internacao; ?>" />
                        </dd>
                        <dt>
                            <label title="Endereço do sistema de cadastro de pacientes">Endereço Externo Cadastro (http://192.168.25.35/cadastro)</label>
                        </dt> 
                        <dd>
                            <input title="Endereço do sistema de cadastro de pacientes" type="text" id="endereco_externo" class="texto08" name="endereco_externo" value="<?= @$obj->_endereco_externo; ?>" />
                        </dd>
                        <dt>
                            <label title="Endereço de integração com o sistema de Laboratório">Endereço Integração Lab (https://labluz.lisnet.com.br/lisnetws/APOIO/enviar)</label>
                        </dt> 
                        <dd>
                            <input title="Endereço de integração com o sistema de Laboratório" type="text" id="endereco_integracao_lab" class="texto08" name="endereco_integracao_lab" value="<?= @$obj->_endereco_integracao_lab; ?>" />
                        </dd>
                        <dt>
                            <label title="Endereço da pasta de upload do sistema. Padrão Ubuntu: /home/sisprod/projetos/clinica/upload    Padrão no CentOS: /var/www/html/NOME DA PASTA DA CLINICA/upload">Endereço Upload (Mouse em cima para mais inf.)</label>
                        </dt> 
                        <dd>
                            <input type="text"title="Endereço da pasta de upload do sistema. Padrão Ubuntu: /home/sisprod/projetos/clinica/upload | Padrão no CentOS: /var/www/html/NOME DA PASTA DA CLINICA/upload" id="endereco_externo" class="texto08" name="endereco_upload" value="<?= @$obj->_endereco_upload; ?>" />
                        </dd>
                        <dt>
                            <label>Endereço Toten EX: (http://192.168.25.47:8099)</label>
                        </dt>
                        <dd>
                            <input type="text" id="endereco_toten" class="texto08" name="endereco_toten" value="<?= @$obj->_endereco_toten; ?>" />
                        </dd>
                        <dt>
                            <label>Numero Empresa (Painel)</label>
                        </dt>
                        <dd>
                            <input type="text" id="numero_empresa_painel" name="numero_empresa_painel" class="texto05" value="<?= @$obj->_numero_empresa_painel; ?>" />
                        </dd>
                        <br>
                        <div>
                            <dt>
                                <label title="Definir os campos que serao obrigatorios no cadastro de paciente.">Campos Obrigatorios</label>
                            </dt>
                            <dd>
                                <?
                                if (@$obj->_campos_cadastro != '') {
                                    $campos_obrigatorios = json_decode(@$obj->_campos_cadastro);
                                } else {
                                    $campos_obrigatorios = array();
                                }
                                ?>
                                <select name="campos_obrigatorio[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                                    <!--<option value="nome" <?= (in_array('nome', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome</option>-->
                                    <option value="nascimento" <?= (in_array('nascimento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nascimento</option>
                                    <option value="nome_mae" <?= (in_array('nome_mae', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome da Mãe</option>
                                    <option value="nome_pai" <?= (in_array('nome_pai', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome do Pai</option>
                                    <option value="nome_conjuge" <?= (in_array('nome_conjuge', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nome do Cônjuge</option>
                                    <option value="nascimento_conjuge" <?= (in_array('nascimento_conjuge', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nascimento do Cônjuge</option>
                                    <option value="email" <?= (in_array('email', $campos_obrigatorios)) ? 'selected' : ''; ?>>Email</option>
                                    <option value="sexo" <?= (in_array('sexo', $campos_obrigatorios)) ? 'selected' : ''; ?>>Sexo</option>
                                    <option value="cpf" <?= (in_array('cpf', $campos_obrigatorios)) ? 'selected' : ''; ?>>CPF</option>
                                    <option value="rg" <?= (in_array('rg', $campos_obrigatorios)) ? 'selected' : ''; ?>>RG</option>
                                    <!--<option value="logradouro" <?= (in_array('logradouro', $campos_obrigatorios)) ? 'selected' : ''; ?>>T. logradouro</option>-->
                                    <option value="endereco" <?= (in_array('endereco', $campos_obrigatorios)) ? 'selected' : ''; ?>>Endereço</option>
                                    <option value="numero" <?= (in_array('numero', $campos_obrigatorios)) ? 'selected' : ''; ?>>Número</option>
                                    <option value="complemento" <?= (in_array('complemento', $campos_obrigatorios)) ? 'selected' : ''; ?>>Complemento</option>
                                    <option value="indicacao" <?= (in_array('indicacao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Indicacao</option>
                                    <option value="bairro" <?= (in_array('bairro', $campos_obrigatorios)) ? 'selected' : ''; ?>>Bairro</option>
                                    <option value="municipio" <?= (in_array('municipio', $campos_obrigatorios)) ? 'selected' : ''; ?>>Município</option>
                                    <option value="cep" <?= (in_array('cep', $campos_obrigatorios)) ? 'selected' : ''; ?>>CEP</option>
                                    <option value="telefone1" <?= (in_array('telefone1', $campos_obrigatorios)) ? 'selected' : ''; ?>>Telefone 1</option>
                                    <option value="telefone2" <?= (in_array('telefone2', $campos_obrigatorios)) ? 'selected' : ''; ?>>Telefone 2</option>
                                    <option value="whatsapp" <?= (in_array('whatsapp', $campos_obrigatorios)) ? 'selected' : ''; ?>>WhatsApp</option>
                                    <option value="plano_saude" <?= (in_array('plano_saude', $campos_obrigatorios)) ? 'selected' : ''; ?>>Plano de Saude</option>
                                    <option value="leito" <?= (in_array('leito', $campos_obrigatorios)) ? 'selected' : ''; ?>>Leito</option>
                                    <option value="numero_carteira" <?= (in_array('numero_carteira', $campos_obrigatorios)) ? 'selected' : ''; ?>>Número Carteira</option>
                                    <option value="vencimento_carteira" <?= (in_array('vencimento_carteira', $campos_obrigatorios)) ? 'selected' : ''; ?>>Vencimento Carteira</option>
                                    <option value="ocupacao" <?= (in_array('ocupacao', $campos_obrigatorios)) ? 'selected' : ''; ?>>Ocupação</option>
                                    <option value="nacionalidade" <?= (in_array('nacionalidade', $campos_obrigatorios)) ? 'selected' : ''; ?>>Nacionalidade</option>
                                    <option value="raca_cor" <?= (in_array('raca_cor', $campos_obrigatorios)) ? 'selected' : ''; ?>>Raça / Cor</option>
                                    <option value="estado_civil" <?= (in_array('estado_civil', $campos_obrigatorios)) ? 'selected' : ''; ?>>Estado civil</option>
                                    <option value="escolaridade" <?= (in_array('escolaridade', $campos_obrigatorios)) ? 'selected' : ''; ?>>Escolaridade</option>
                                    <option value="instagram" <?= (in_array('instagram', $campos_obrigatorios)) ? 'selected' : ''; ?>>Instagram</option>


                                </select>
                            </dd>
                        </div>
                        <br>
                        <br>
                        <div><br><br>
                            <dt>
                                <label title="Definir os campos visíveis na tela de atendimento médico">Tela de Atendimento Médico</label>
                            </dt>
                            <dd>
                                <?
                                if (@$obj->_campos_atendimentomed != '') {
                                    $opc_telatendimento = json_decode(@$obj->_campos_atendimentomed);
                                } else {
                                    $opc_telatendimento = array();
                                }
                                ?>
                                <select name="opc_telatendimento[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                                    <option value="cirurgias" <?= (in_array('cirurgias', $opc_telatendimento)) ? 'selected' : ''; ?>>Cirurgias</option>
                                    <option value="lab" <?= (in_array('lab', $opc_telatendimento)) ? 'selected' : ''; ?>>Exames Laboratoriais</option>
                                    <option value="eco" <?= (in_array('eco', $opc_telatendimento)) ? 'selected' : ''; ?>>Ecocardiograma</option>
                                    <option value="ecostress" <?= (in_array('ecostress', $opc_telatendimento)) ? 'selected' : ''; ?>>Eco Stress</option>
                                    <option value="cate" <?= (in_array('cate', $opc_telatendimento)) ? 'selected' : ''; ?>>Cateterismo Cardiaco</option>
                                    <option value="holter" <?= (in_array('holter', $opc_telatendimento)) ? 'selected' : ''; ?>>Holter 24h</option>
                                    <option value="cintil" <?= (in_array('cintil', $opc_telatendimento)) ? 'selected' : ''; ?>>Cintilografia</option>
                                    <option value="mapa" <?= (in_array('mapa', $opc_telatendimento)) ? 'selected' : ''; ?>>Mapa</option>
                                    <option value="te" <?= (in_array('te', $opc_telatendimento)) ? 'selected' : ''; ?>>Teste Ergométrico</option>
                                    <option value="receituario" <?= (in_array('receituario', $opc_telatendimento)) ? 'selected' : ''; ?>>Receituário</option>
                                    <option value="historicoimprimir" <?= (in_array('historicoimprimir', $opc_telatendimento)) ? 'selected' : ''; ?>>Imprimir Histórico</option>
                                    <option value="receituarioesp" <?= (in_array('receituarioesp', $opc_telatendimento)) ? 'selected' : ''; ?>>Receituário Especial</option>
                                    <option value="solicitar_exames" <?= (in_array('solicitar_exames', $opc_telatendimento)) ? 'selected' : ''; ?>>Solicitar Exames</option>
                                    <option value="atestado" <?= (in_array('atestado', $opc_telatendimento)) ? 'selected' : ''; ?>>Atestado</option>
                                    <option value="declaracao" <?= (in_array('declaracao', $opc_telatendimento)) ? 'selected' : ''; ?>>Declaração</option>
                                    <option value="arquivos" <?= (in_array('arquivos', $opc_telatendimento)) ? 'selected' : ''; ?>>Arquivos</option>
                                    <option value="aih" <?= (in_array('aih', $opc_telatendimento)) ? 'selected' : ''; ?>>Laudo AIH</option>
                                    <option value="consultar_procedimento" <?= (in_array('consultar_procedimento', $opc_telatendimento)) ? 'selected' : ''; ?>>Consultar Procedimento</option>
                                    <option value="sadt" <?= (in_array('sadt', $opc_telatendimento)) ? 'selected' : ''; ?>>Solicitação SADT</option>
                                    <option value="cadastro_aso" <?= (in_array('cadastro_aso', $opc_telatendimento)) ? 'selected' : ''; ?>>Cadastro ASO</option>
                                    <option value="chamar" <?= (in_array('chamar', $opc_telatendimento)) ? 'selected' : ''; ?>>Chamar</option>
                                    <option value="editar" <?= (in_array('editar', $opc_telatendimento)) ? 'selected' : ''; ?>>Editar</option>
                                    <option value="pendente" <?= (in_array('pendente', $opc_telatendimento)) ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="encaminhar" <?= (in_array('encaminhar', $opc_telatendimento)) ? 'selected' : ''; ?>>Encaminhar</option>
                                    <option value="histconsulta" <?= (in_array('histconsulta', $opc_telatendimento)) ? 'selected' : ''; ?>>Histórico Consulta</option>
                                    <option value="histantigo" <?= (in_array('histantigo', $opc_telatendimento)) ? 'selected' : ''; ?>>Histórico Antigo</option>
                                    <option value="preencherform" <?= (in_array('preencherform', $opc_telatendimento)) ? 'selected' : ''; ?>>Preencher Formulário</option>
                                    <option value="parecercirurgia" <?= (in_array('parecercirurgia', $opc_telatendimento)) ? 'selected' : ''; ?>>Parecer Cirurgia Pediátrica</option>
                                    <option value="laudoapendicite" <?= (in_array('laudoapendicite', $opc_telatendimento)) ? 'selected' : ''; ?>>Laudo Apendicite</option>
                                </select>
                            </dd>
                        </div>
                        <br>
                        <br>
                        <div><br><br>
                            <dt>
                                <label title="Definir os dados do paciente visíveis">Dados do Paciente (Atendimento)</label>
                            </dt>
                            <dd>
                                <?
                                if (@$obj->_dados_atendimentomed != '') {
                                    $opc_dadospaciente = json_decode(@$obj->_dados_atendimentomed);
                                } else {
                                    $opc_dadospaciente = array();
                                }
                                ?>
                                <select name="opc_dadospaciente[]" style="width: 47%;" class="chosen-select" data-placeholder="Selecione os campos..." multiple>
                                    <option value="paciente" <?= (in_array('paciente', $opc_dadospaciente)) ? 'selected' : ''; ?>>Nome</option>
                                    <option value="idade" <?= (in_array('idade', $opc_dadospaciente)) ? 'selected' : ''; ?>>Idade</option>
                                    <option value="sexo" <?= (in_array('sexo', $opc_dadospaciente)) ? 'selected' : ''; ?>>Sexo</option>
                                    <option value="indicacao" <?= (in_array('indicacao', $opc_dadospaciente)) ? 'selected' : ''; ?>>Indicação</option>
                                    <option value="exame" <?= (in_array('exame', $opc_dadospaciente)) ? 'selected' : ''; ?>>Exame</option>
                                    <option value="nascimento" <?= (in_array('nascimento', $opc_dadospaciente)) ? 'selected' : ''; ?>>Nascimento</option>
                                    <option value="ocupacao" <?= (in_array('ocupacao', $opc_dadospaciente)) ? 'selected' : ''; ?>>Ocupação</option>
                                    <option value="endereco" <?= (in_array('endereco', $opc_dadospaciente)) ? 'selected' : ''; ?>>Endereço</option>
                                    <option value="estadocivil" <?= (in_array('estadocivil', $opc_dadospaciente)) ? 'selected' : ''; ?>>Estado Civil</option>
                                    <option value="convenio" <?= (in_array('convenio', $opc_dadospaciente)) ? 'selected' : ''; ?>>Convênio</option>
                                    <option value="solicitante" <?= (in_array('solicitante', $opc_dadospaciente)) ? 'selected' : ''; ?>>Solicitante</option>
                                    <option value="sala" <?= (in_array('sala', $opc_dadospaciente)) ? 'selected' : ''; ?>>Sala</option>
                                    <option value="telefone" <?= (in_array('telefone', $opc_dadospaciente)) ? 'selected' : ''; ?>>Telefone</option>

                                </select>
                            </dd>
                        </div>
                        <br>
                        <br><br><br>
                        <fieldset>
                            <fieldset>
                                <legend><b><u>Configurações Gerais</u></b></legend><br>
                                <table align="center" style="width:100%">
                                    <tr>
                                        <td> <input type="checkbox" id="imagem" name="imagem" <? if (@$obj->_imagem == 't') echo "checked"; ?>/></td><td><label title="Habilitar Modulo de Imagem.">Imagem</label></td>
                                        <td> <input type="checkbox" id="consulta" name="consulta" <? if (@$obj->_consulta == 't') echo "checked"; ?>/></td><td><label title="Habilitar Modulo de Consulta.">Consulta</label></td>
                                        <td> <input type="checkbox" id="especialidade" name="especialidade" <? if (@$obj->_especialidade == 't') echo "checked"; ?>/></td><td><label title="Habilitar Modulo de Especialidade.">Especialidade</label></td>
                                        <td> <input type="checkbox" id="odontologia" name="odontologia" <? if (@$obj->_odontologia == 't') echo "checked"; ?>/></td><td><label title="Habilitar Modulo de Odontologia.">Odontologia</label></td>
                                        <td> <input type="checkbox" id="oftamologia" name="oftamologia" <? if (@$obj->_oftamologia == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, oftamologia irá aparecer na consulta.">Oftalmologia</label></td>
                                        <td> <input type="checkbox" id="laboratorio" name="laboratorio" <? if (@$obj->_laboratorio == 't') echo "checked"; ?>/></td><td><label title="Habilitar Laboratorio.">Laboratorio</label></td>
                                    </tr>
                                    <tr>                                        
                                        <td> <input type="checkbox" id="geral" name="geral" <? if (@$obj->_geral == 't') echo "checked"; ?>/></td><td><label title="Habilitar Geral.">Geral</label></td>
                                        <td><input type="checkbox" id="faturamento" name="faturamento" <? if (@$obj->_faturamento == 't') echo "checked"; ?>/></td><td><label title="Habilitar Faturamento.">Faturamento</label></td>
                                        <td><input type="checkbox" id="estoque" name="estoque" <? if (@$obj->_estoque == 't') echo "checked"; ?>/></td><td><label title="Habilitar Estoque.">Estoque</label></td>
                                        <td><input type="checkbox" id="financeiro" name="financeiro" <? if (@$obj->_financeiro == 't') echo "checked"; ?>/></td><td><label title="Habilitar Financeiro.">Financeiro</label></td>
                                        <td><input type="checkbox" id="marketing" name="marketing" <? if (@$obj->_marketing == 't') echo "checked"; ?>/></td><td><label title="Habilitar Marketing.">Marketing</label></td>
                                        <td><input type="checkbox" id="internacao" name="internacao" <? if (@$obj->_internacao == 't') echo "checked"; ?>/></td><td><label title="Habilitar Internação.">Internação</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" id="internacao" name="farmacia" <? if (@$obj->_farmacia == 't') echo "checked"; ?>/></td><td><label title="Habilitar Internação.">Farmácia</label></td>
                                        <td><input type="checkbox" id="centro_cirurgico" name="centro_cirurgico" <? if (@$obj->_centro_cirurgico == 't') echo "checked"; ?>/></td><td><label title="Habilitar Centro Cirurgico.">Centro Cirurgico</label></td>
                                        <td><input type="checkbox" id="ponto" name="ponto" <? if (@$obj->_ponto == 't') echo "checked"; ?>/></td><td><label title="Habilitar Ponto.">Ponto</label></td>                                        
                                        <td><input type="checkbox" id="botao_ativar_sala" name="botao_ativar_sala" <? if (@$obj->_botao_ativar_sala == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag o botão de reativar sala aparece.">Botão de reativar sala</label></td>
                                        <td><input type="checkbox" id="enfermagem" name="enfermagem" <? if (@$obj->_enfermagem == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag o perfil de Técnico passa a poder dar entrada e solicitar.">Enfermagem</label></td>
                                        <td><input type="checkbox" id="integracaosollis" name="integracaosollis" <? if (@$obj->_integracaosollis == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag o sistema fará integração com a API da Sollis para o receituário médico.">Sollis</label></td>
                                    </tr>                                    
                                </table>
                            </fieldset>
                            <br><br><br>
                            <fieldset>
                                <fieldset>
                                    <legend><b><u>Configurações de Impressões</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="cabecalho_config" name="cabecalho_config" <? if (@$obj->_cabecalho_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Cabeçalho Configurável</label></td>
                                            <td><input type="checkbox" id="rodape_config" name="rodape_config" <? if (@$obj->_rodape_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Rodapé Configurável</label></td>
                                            <td><input type="checkbox" id="laudo_config" name="laudo_config" <? if (@$obj->_laudo_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Laudo Configurável</label></td>
                                            <td><input type="checkbox" id="recibo_config" name="recibo_config" <? if (@$obj->_recibo_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Recibo Configurável</label></td>
                                            <td><input type="checkbox" id="ficha_config" name="ficha_config" <? if (@$obj->_ficha_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Ficha Configurável</label></td>                                        
                                            <td><input type="checkbox" id="declaracao_config" name="declaracao_config" <? if (@$obj->_declaracao_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Declaração Configurável</label></td>                                        
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="atestado_config" name="atestado_config" <? if (@$obj->_atestado_config == 't') echo "checked"; ?>/></td><td><label title="Impressao .">Atestado Configurável</label></td>
                                            <td><input type="checkbox" id="orcamento_config" name="orcamento_config" <? if (@$obj->_orcamento_config == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o orçamento será configurável.">Orçamento Configurável:</label></td>
                                            <td><input type="checkbox" id="impressao_cimetra" name="impressao_cimetra" <? if (@$obj->_impressao_cimetra == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, irá aparecer a opção de impressão para papel carta.">Impressão Papel Carta - Cimetra</label></td>
                                        </tr>
                                    </table>
                                </fieldset> <br><br><br>
                                <fieldset>
                                    <legend><b><u>Configurações Sistema Paciente</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="botao_laudo_paciente" name="botao_laudo_paciente" <? if (@$obj->_botao_laudo_paciente == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção o botão de laudo irá aparecer no sistema de pacientes">Botão Laudo no Sistema Paciente</label></td>
                                            <td><input type="checkbox" id="botao_arquivos_paciente" name="botao_arquivos_paciente" <? if (@$obj->_botao_arquivos_paciente == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção o botão de arquivos irá aparecer no sistema de pacientes">Botão Arquivos no Sistema Paciente</label></td>
                                            <td><input type="checkbox" id="botao_imagem_paciente" name="botao_imagem_paciente" <? if (@$obj->_botao_imagem_paciente == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção o botão de Imprimir Imagens aparece no sistema de pacientes">Botão Imagem no Sistema Paciente</label></td>
                                            <td><input type="checkbox" id="login_paciente" name="login_paciente" <? if (@$obj->_login_paciente == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o login será obrigatório no Sistema de Pacientes.">Login no Sistema de Paciente</label></td>                                                                                
                                        </tr>                                    
                                    </table>
                                </fieldset>
                                <br><br><br>
                                <fieldset>
                                    <legend><b><u>Configurações Padrão MED</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="calendario_layout" name="calendario_layout" <? if (@$obj->_calendario_layout == 't') echo "checked"; ?>/></td><td><label title="Habilitar o layout de calendario criado para a MED (apenas na multifunção geral).">Calendario (Layout Personalizado)</label></td>                                                                             
                                            <td><input type="checkbox" id="relatorios_clinica_med" name="relatorios_clinica_med" <? if (@$obj->_relatorios_clinica_med == 't') echo "checked"; ?>/></td><td><label title="Relatórios utilizados na Clínica MED">Relatórios Clínica MED</label></td>                                                                             
                                            <td><input type="checkbox" id="retirar_preco_procedimento" name="retirar_preco_procedimento" <? if (@$obj->_retirar_preco_procedimento == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, a tela Preço Procedimento irá sumir e irá ficar somente a tela do orçamento.">Retirar Preço Procedimento</label></td>                                                                             
                                            <td><input type="checkbox" id="ajuste_pagamento_procedimento" name="ajuste_pagamento_procedimento" <? if (@$obj->_ajuste_pagamento_procedimento == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção irá aparecer a opção de informar o ajuste no cadastro de pagamento (procedimento). Além disso, a tela de faturamento irá mudar">Ajuste no Pagamento (Procedimento)</label></td>                                                                             

                                        </tr>                                    
                                        <tr>

                                            <td><input type="checkbox" id="apenas_procedimentos_multiplos" name="apenas_procedimentos_multiplos" <? if (@$obj->_apenas_procedimentos_multiplos == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, o sistema so irá disponibilizar o botão de procedimentos multiplos.">Deixar apenas procedimentos múltiplos</label></td>                                                                             
                                            <td><input type="checkbox" id="cadastrar_painel_sala" name="cadastrar_painel_sala" <? if (@$obj->_cadastrar_painel_sala == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, ao criar uma sala, o sistema irá criar vincular 10 paineis automaticamente.">Vincular paineis ao criar salas</label></td>                                                                             
                                            <td><input type="checkbox" id="retirar_flag_solicitante" name="retirar_flag_solicitante" <? if (@$obj->_retirar_flag_solicitante == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, as flags de medico solicitante e ocupação no painel não irão aparecer no cadastro de profissionais">Retirar flag de solicitante</label></td>                                                                             
                                            <td><input type="checkbox" id="senha_finalizar_laudo" name="senha_finalizar_laudo" <? if (@$obj->_senha_finalizar_laudo == 't') echo "checked"; ?>/></td><td><label title="Ao ativar, o sistema irá solicitar a senha do medico responsavel para finalizar o laudo. Do contrário, não será necessário.">Solicitar Senha ao Finalizar Laudo</label></td>                                                                             

                                        </tr>                                    
                                        <tr>
                                            <td><input type="checkbox" id="valor_laboratorio" name="tecnica_promotor" <? if (@$obj->_tecnica_promotor == 't') echo "checked"; ?>/></td><td><label title="No momento de enviar da sala de espera, não mostrar a opção do promotor caso o usuário não possua perfil de Administrador">Promotor Sala de Espera</label></td>                                                                             
                                            <td><input type="checkbox" id="profissional_completo" name="profissional_completo" <? if (@$obj->_profissional_completo == 't') echo "checked"; ?>/></td><td><label title="O valor do laboratório é retirado antes do valor do médico no relatório de produção médica">Profissional Convênio Completo</label></td>                                                                             
                                            <td><input type="checkbox" id="caixa_personalizado" name="caixa_personalizado" <? if (@$obj->_caixa_personalizado == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o relatorio de caixa normal some e so fica disponivel o caixa personalizado. Além disso os relatorios de caixa cartão irão ficar com o layout do personalizado e o rel. previsão irá sumir.">Caixa personalizado</label></td>                                                                             
                                            <td><input type="checkbox" id="recomendacao_configuravel" name="recomendacao_configuravel" <? if (@$obj->_recomendacao_configuravel == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o manter indicação irá aparecer nas configurações.">Tornar a recomendação configuravel</label></td>                                                                             

                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="recomendacao_obrigatorio" name="recomendacao_obrigatorio" <? if (@$obj->_recomendacao_obrigatorio == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, ao adcionar ou autorizar um(a) novo(a) exame/consulta o campo recomendação é obrigatorio.">Tornar a recomendação Obrigatorio</label></td>
                                            <td><input type="checkbox" id="percentual_multiplo" name="percentual_multiplo" <? if (@$obj->_percentual_multiplo == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, a tela de cadastrar percentual irá seguir o padrão dos procedimentos multiplos.">Percentual similar ao Proc. Multiplos</label></td>
                                            <td><input type="checkbox" id="procedimentos_multiempresa" name="procedimentos_multiempresa" <? if (@$obj->_procedimento_multiempresa == 't') echo "checked"; ?>/></td><td><label title="Procedimentos separados por empresa.">Proc. Multiempresa</label></td>
                                            <td><input type="checkbox" id="procedimento_excecao" name="procedimento_excecao" <? if (@$obj->_procedimento_excecao == 't') echo "checked"; ?>/></td><td><label title="Ao asssociar procedimentos aos médicos (CONFIGURAÇÕES - RECEPÇÃO - LISTAR PROFISSIONAIS - CONVÊNIO), estes serão tratados como exceção.">Cadastrar procedimentos como exceção.</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="desabilitar_trava_retorno" name="desabilitar_trava_retorno" <? if (@$obj->_desabilitar_trava_retorno == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o sistema não irá mais barrar o lançamento de procedimentos do tipo Retorno.">Desabilitar trava no Retorno</label></td>
                                            <td><input type="checkbox" id="desativar_personalizacao_impressao" name="desativar_personalizacao_impressao" <? if (@$obj->_desativar_personalizacao_impressao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, as opçoes de impressao, tais como assinatura e carimbo, deixaram de aparecer na tela do médico.">Desativar personalização da impressao dos medicos</label></td>
                                            <td></td><td></td>
                                            <td></td><td></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <br><br><br>
                                <fieldset>
                                    <legend><b><u>Configurações Recepção</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="calendario" name="calendario" <? if (@$obj->_calendario == 't') echo "checked"; ?>/></td><td><label title="Habilitar Calendario.">Calendario</label></td>                                                                               
                                            <td><input type="checkbox" id="conjuge" name="conjuge" <? if (@$obj->_conjuge == 't') echo "checked"; ?>/></td><td><label title="Nome do cônjuge e data de nascimento do mesmo">Nome do cônjuge</label></td>                                                                               
                                            <td><input type="checkbox" id="gerente_cancelar" name="gerente_cancelar_sala" <? if (@$obj->_gerente_cancelar_sala == 't') echo "checked"; ?>/></td><td><label title="Ao ativar essa flag o gerente de recepção consegue cancelar na sala de espera independente de outra flag">Gerente Cancelar Sala de Espera</label></td>                                                                               
                                            <td><input type="checkbox" id="gerente_recepcao_top_saude" name="gerente_recepcao_top_saude" <? if (@$obj->_gerente_recepcao_top_saude == 't') echo "checked"; ?>/></td><td><label title="Ao ativar essa flag o gerente de recepção tem acesso a alguns relatórios do Financeiro a pedido da Top Saude">Gerente de Recepção Relatórios Financeiro (Top Saúde)</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="gerente_cancelar" name="autorizar_sala_espera" <? if (@$obj->_autorizar_sala_espera == 't') echo "checked"; ?>/></td><td><label title="Ao ativar essa flag o paciente passa para sala de espera ao ser autorizado">Sala de Espera</label></td>
                                            <td><input type="checkbox" id="gerente_cancelar" name="gerente_cancelar" <? if (@$obj->_gerente_cancelar == 't') echo "checked"; ?>/></td><td><label title="Ao ativar essa flag o Gerente de Recepção e perfil Recepção conseguem cancelar na recepção">Recepção Cancelar (Gerente e Recepção)</label></td>
                                            <td><input type="checkbox" id="chamar_consulta" name="chamar_consulta" <? if (@$obj->_chamar_consulta == 't') echo "checked"; ?>/></td><td><label title="Chamar Consulta.">Chamar Consulta na sala de espera</label></td>
                                            <td><input type="checkbox" id="procedimento_excecao" name="ordem_chegada" <? if (@$obj->_ordem_chegada == 't') echo "checked"; ?>/></td><td><label title="Ordem de chegada na sala de espera">Ordem de Chegada</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="cancelar_sala_espera" name="cancelar_sala_espera" <? if (@$obj->_cancelar_sala_espera == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o botão de cancelar na sala de espera irá aparecer.">Cancelar Sala de Espera</label></td>
                                            <td><input type="checkbox" id="administrador_cancelar" name="administrador_cancelar" <? if (@$obj->_administrador_cancelar == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o administrador TOTAL pode cancelar na sala de espera.">Administrador cancelar na sala de espera</label></td>
                                            <td><input type="checkbox" id="gerente_contasapagar" name="gerente_contasapagar" <? if (@$obj->_gerente_contasapagar == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a gerente de recepção consegue lançar despesas no contas a pagar">Gerente de Recepção Contas a Pagar</label></td>
                                            <td><input type="checkbox" id="orcamento_recepcao" name="orcamento_recepcao" <? if (@$obj->_orcamento_recepcao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o preço procedimento aparece para a Recepção">Perfis da recepção Preço Procedimento</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="gerente_recepcao_financeiro" name="gerente_relatorio_financeiro" <? if (@$obj->_gerente_relatorio_financeiro == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção o Gerente de Recepção irá ter acesso á alguns relatórios do financeiro e do faturamento">Gerente de Recepção Rel. Financeiro</label></td>
                                            <td><input type="checkbox" id="relatorios_recepcao" name="relatorios_recepcao" <? if (@$obj->_relatorios_recepcao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, os relatórios aparecem para recepção e recepção agendamento">Relatórios para recepção</label></td>
                                            <td><input type="checkbox" id="tecnica_enviar" name="tecnica_enviar" <? if (@$obj->_tecnica_enviar == 't') echo "checked"; ?>/></td><td><label title="A técnica irá poder chamar na tela de atendimento">Técnica Chamar</label></td>
                                            <td><input type="checkbox" id="botao_ficha_convenio" name="botao_ficha_convenio" <? if (@$obj->_botao_ficha_convenio == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção o botão de Ficha-Convenio irá aparecer na tabela de consultas marcadas">Botão Ficha-Convenio</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="recomendacao_obrigatorio" name="recomendacao_obrigatorio" <? if (@$obj->_recomendacao_obrigatorio == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, ao adcionar ou autorizar um(a) novo(a) exame/consulta o campo recomendação é obrigatorio.">Tornar a recomendação Obrigatorio.</label></td>
                                            <td><input type="checkbox" id="selecionar_retorno" name="selecionar_retorno" <? if (@$obj->_selecionar_retorno == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, quando o sistema encontrar um procedimento com retorno no sistema, ele irá perguntar se a pessoa deseja associar, se sim, ele irá automáticamente selecionar o procedimento
                                                                                                                                                                                                       Caso isso não esteja ativado, o sistema vai tirar a seleção do procedimento.">Selecionar Retorno Automaticamente</label></td>
                                            <td><input type="checkbox" id="repetir_horarios_agenda" name="repetir_horarios_agenda" <? if (@$obj->_repetir_horarios_agenda == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, no momento de criar a agenda, aparece uma opçao para o usuario informar quantas vezes ele ira querer repetir os horarios.">Permitir criação de horarios repetidos na agenda.</label></td>
                                            <td><input type="checkbox" id="laudo_sigiloso" name="laudo_sigiloso" <? if (@$obj->_laudo_sigiloso == 't') echo "checked"; ?>/></td><td><label title="O laudo só vai ser editado pelo nosso operador">Laudo Sigiloso</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="retirar_botao_ficha" name="retirar_botao_ficha" <? if (@$obj->_retirar_botao_ficha == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, os botões para imprimir a ficha não serão mostrados.">Retirar botões de Ficha</label></td>
                                            <td><input type="checkbox" id="subgrupo_procedimento" name="subgrupo_procedimento" <? if (@$obj->_subgrupo_procedimento == 't') echo "checked"; ?>/></td><td><label title="Ao ativar, irá aparecer uma tela para cadastrar subgrupos no sistema (associados aos grupos). Isso pode ser usado no relátorio de conferência.">Subgrupo de Procedimento</label></td>
                                            <td><input type="checkbox" id="encaminhamento_email" name="encaminhamento_email" <? if (@$obj->_encaminhamento_email == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, quando encaminhar um paciente será disparado um email para o médico que recebe (Padrão Citycor).">Encaminhamento Email</label></td>
                                            <td><input type="checkbox" id="relatorio_ordem" name="relatorio_ordem" <? if (@$obj->_relatorio_ordem == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o relatório de ordem de atendimento aparece">Relatório Ordem de Atendimento</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="manter_indicacao" name="manter_indicacao" <? if (@$obj->_manter_indicacao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o Manter Indicação vai ser ativado na Recepção">Manter Indicação</label></td>
                                            <td><input type="checkbox" id="fila_impressao" name="fila_impressao" <? if (@$obj->_fila_impressao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o Fila Impressão vai ser ativado na Recepção">Fila de Impressão</label></td>
                                            <td><input type="checkbox" id="medico_solicitante" name="medico_solicitante" <? if (@$obj->_medico_solicitante == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Editar Médico Solicitante vai ser ativada na Recepção">Editar Médico Solicitante</label></td>
                                            <td><input type="checkbox" id="uso_salas" name="uso_salas" <? if (@$obj->_uso_salas == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Uso de Salas vai ser ativada na Recepção">Uso de Salas</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="relatorio_operadora" name="relatorio_operadora" <? if (@$obj->_relatorio_operadora == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Relatório Operadora vai ser ativada na Recepção">Relatório Operadora</label></td>
                                            <td><input type="checkbox" id="relatorio_demandagrupo" name="relatorio_demandagrupo" <? if (@$obj->_relatorio_demandagrupo == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Relatório de Demanda Grupo vai ser ativada na Recepção">Relatório de Demanda Grupo</label></td>
                                            <td><input type="checkbox" id="relatorio_rm" name="relatorio_rm" <? if (@$obj->_relatorio_rm == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Relatório RM vai ser ativada na Recepção">Relatório RM</label></td>
                                            <td><input type="checkbox" id="relatorio_caixa" name="relatorio_caixa" <? if (@$obj->_relatorio_caixa == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a opção de Relatório Caixa vai ser ativada na Recepção">Relatório Caixa</label></td>
                                            
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="reservar_escolher_proc" name="reservar_escolher_proc" <? if (@$obj->_reservar_escolher_proc == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, você deve escolher o procedimento ao reservar um horário.">Escolher Procedimento Ao Reservar</label></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <br><br><br>
                                <fieldset>
                                    <legend><b><u>Configurações do Financeiro</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="calendario" name="botao_faturar_proc" <? if (@$obj->_botao_faturar_proc == 't') echo "checked"; ?>/></td><td><label title="Aparecer o botão de faturar procedimento no cadastro.">Botão Faturar Procedimentos</label></td>                                                                                
                                            <td><input type="checkbox" id="calendario" name="botao_faturar_guia" <? if (@$obj->_botao_faturar_guia == 't') echo "checked"; ?>/></td><td><label title="Aparecer  o botão de faturar guia no cadastro.">Botão Faturar Guia</label></td>                                                                                
                                            <td><input type="checkbox" id="producao_medica_saida" name="producao_medica_saida" <? if (@$obj->_producao_medica_saida == 't') echo "checked"; ?>/></td><td><label title="Ao fechar a produção médica, os valores ja irão cair como saida no Financeiro.">Produção Médica ir direto para Saida</label></td>                                                                                
                                            <td><input type="checkbox" id="financeiro_cadastro" name="financeiro_cadastro" <? if (@$obj->_financeiro_cadastro == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o financeiro tem acesso ao Fila Caixa e ao cadastro de pacientes">Financeiro Cadastro Paciente (Faturar)</label></td>                                                                                
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="fila_caixa" name="fila_caixa" <? if (@$obj->_caixa == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, a fila de caixa vai ser ativada.">Fila de Caixa</label></td>
                                            <td><input type="checkbox" id="excluir_transferencia" name="excluir_transferencia" <? if (@$obj->_excluir_transferencia == 't') echo "checked"; ?>/></td><td><label title="Excluir Transferência">Excluir Transferência (Financeiro)</label></td>
                                            <td><input type="checkbox" id="associa_credito_procedimento" name="associa_credito_procedimento" <? if (@$obj->_associa_credito_procedimento == 't') echo "checked"; ?>/></td><td><label title="Desativando essa flag, na tela de crédito o usuário irá informar apenas o valor do crédito (sem travar o crédito ao valor de procedimentos).">Crédito associado a procedimentos</label></td>
                                            <td><input type="checkbox" id="credito" name="credito" <? if (@$obj->_credito == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o crédito irá aparecer no sistema.">Aparecer Crédito</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="promotor_medico" name="promotor_medico" <? if (@$obj->_promotor_medico == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o valor do promotor vai ser descontado do médico.">Tirar Valor Promotor do médico</label></td>
                                            <td><input type="checkbox" id="valor_recibo_guia" name="valor_recibo_guia" <? if (@$obj->_valor_recibo_guia == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o valor do recibo sera o da Guia.">Valor do Recibo é o da guia</label></td>
                                            <td><input type="checkbox" id="odontologia_valor_alterar" name="odontologia_valor_alterar" <? if (@$obj->_odontologia_valor_alterar == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, valor da odontologia poderá ser alterado ao lançar.">Valor da Odontologia Alterável</label></td>
                                            <td><input type="checkbox" id="valor_autorizar" name="valor_autorizar" <? if (@$obj->_valor_autorizar == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o valor aparece ao autorizar procedimentos.">Valor aparece ao autorizar procedimentos</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="valor_laboratorio" name="valor_laboratorio" <? if (@$obj->_valor_laboratorio == 't') echo "checked"; ?>/></td><td><label title="O valor do laboratório é retirado antes do valor do médico no relatório de produção médica">Valor do Laboratório (Produção médica)</label></td>
                                            <td><input type="checkbox" id="valor_convenio_nao" name="valor_convenio_nao" <? if (@$obj->_valor_convenio_nao == 't') echo "checked"; ?>/></td><td><label title="No lançamento de procedimentos não aparece o valor de procedimentos não particulares.">Valor Convenio não aparecer</label></td>
                                            <td><input type="checkbox" id="desativar_taxa_administracao" name="desativar_taxa_administracao" <? if (@$obj->_desativar_taxa_administracao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção, irá sumir a taxa de administração.">Desativar Taxa Administração</label></td>
                                            <td><input type="checkbox" id="orcamento_cadastro" name="orcamento_cadastro" <? if (@$obj->_orcamento_cadastro == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção irá necessitar de cadastro e logicamente, desativando não irá necessitar">Orçamento com cadastro</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="producao_alternativo" name="producao_alternativo" <? if (@$obj->_producao_alternativo == 't') echo "checked"; ?>/> </td><td><label title="Ativando essa opção, o relatório de produção terá o visual alternativo (Ronaldo).">Relatório Produção M. Alternativo</label></td>
                                            <td><input type="checkbox" id="data_contaspagar" name="data_contaspagar" <? if (@$obj->_data_contaspagar == 't') echo "checked"; ?>/></td><td><label title="Data manual na produção médica .">Data Manual Produção M.</label></td>
                                            <td></td><td></td>
                                            <td></td><td></td>
                                        </tr>
                                    </table>
                                </fieldset>
                                <br><br><br>
                                <fieldset>
                                    <legend><b><u>Configurações Atendimento Médico</u></b></legend><br>
                                    <table align="center" style="width:100%">
                                        <tr>
                                            <td><input type="checkbox" id="data_contaspagar" name="medico_laudodigitador" <? if (@$obj->_medico_laudodigitador == 't') echo "checked"; ?>/></td><td><label title="Médico pode pesquisar por outros médicos no Laudo Digitador .">Medico Laudo Digitador.</label></td>
                                            <td><input type="checkbox" id="modelo_laudo_medico" name="modelo_laudo_medico" <? if (@$obj->_modelo_laudo_medico == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção os modelos de Laudo no atendimento serão apenas os do médico que está atendendo">Modelo Laudo Por Médico</label></td>
                                            <td><input type="checkbox" id="relatorio_producao" name="relatorio_producao" <? if (@$obj->_relatorio_producao == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, o relatório de produção nas telas de atendimento aparece">Relatório Produção (Nas telas do médico)</label></td>
                                            <td><input type="checkbox" id="carregar_modelo_receituario" name="carregar_modelo_receituario" <? if (@$obj->_carregar_modelo_receituario == 't') echo "checked"; ?>/></td><td><label title="Ativando essa flag, quando só tiver um modelo de receituario cadastrado ele será carregado automaticamente.">Carregar Modelo Receiturario Automaticamente</label></td>                                                                                                                      
                                        </tr>                                    
                                        <tr>
                                            <td><input type="checkbox" id="profissional_externo" name="profissional_externo" <? if (@$obj->_profissional_externo == 't') echo "checked"; ?>/></td><td><label title="Aparece o campo de endereço externo no profissional para integração do STG com outro STG">Endereço Externo Médico.</label></td>
                                            <td><input type="checkbox" id="profissional_agendar" name="profissional_agendar" <? if (@$obj->_profissional_agendar == 't') echo "checked"; ?>/></td><td><label title="Ativando essa opção os modelos de Laudo no atendimento serão apenas os do médico que está atendendo">Agendamento Médico (Fisioterapia)</label></td>
                                        </tr>                                    
                                    </table>
                                </fieldset>
                                <br><br><br>

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
    
    jQuery("#txtTelefone")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

    jQuery("#txtCelular")
            .mask("(99) 9999-9999?9")
            .focusout(function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

</script>
