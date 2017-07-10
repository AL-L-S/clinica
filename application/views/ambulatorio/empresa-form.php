<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Empresa</a></h3>
        <div>
            <form name="form_empresa" id="form_empresa" action="<?= base_url() ?>ambulatorio/empresa/gravar" method="post">

                <dl class="dl_desconto_lista">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="hidden" name="txtempresaid" class="texto10" value="<?= @$obj->_empresa_id; ?>" />
                        <input type="text" name="txtNome" class="texto10" value="<?= @$obj->_nome; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocial" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
                    </dd>
                    <dt>
                        <label>Raz&atilde;o social (XML)</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtrazaosocialxml" id="txtrazaosocial" class="texto10" value="<?= @$obj->_razao_social; ?>" />
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
                        <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= @$obj->_logradouro; ?>" />
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
                            <label title="Habilitar a Imagem.">Imagem</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="imagem" name="imagem" <? if (@$obj->_imagem == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar a Consulta.">Consulta</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="consulta" name="consulta" <? if (@$obj->_consulta == 't') echo "checked"; ?>/> 
                        </dd>
                        <dt>
                            <label title="Habilitar Especialidade chat.">Especialidade</label>
                        </dt>
                        <dd>
                            <input type="checkbox" id="especialidade" name="especialidade" <? if (@$obj->_especialidade == 't') echo "checked"; ?>/> 
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