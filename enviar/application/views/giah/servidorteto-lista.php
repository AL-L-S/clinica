<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor/pesquisar/<?= $servidor->_nome; ?>">
            Voltar
        </a>
    </div>
    <?php $this->load->view("giah/snippets/servidor-detalhe"); ?>
    <div id="accordion">
        <h3><a href="#">Lista de tetos</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->
                <thead>
                    <tr>
                        <th class="tabela_header">Matricula SAM</th>
                        <th class="tabela_header">Banco</th>
                        <th class="tabela_header">Agencia / DV</th>
                        <th class="tabela_header">Conta / DV</th>
                        <th class="tabela_header">Salario</th>
                        <th class="tabela_header">Situa&ccedil;&atilde;o</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i = 0;
                        foreach ($lista as $item) :
                            if ($i % 2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                    ?>
                            <tr>
                                <td class="<?= $classe; ?>"><?= $item->matricula_sam; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->banco; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->agencia; ?> / <?= $item->agencia_dv; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->conta; ?> / <?= $item->conta_dv; ?></td>
                                <td class="<?= $classe; ?>"><?= number_format($item->salario_base, 2, ",", "."); ?></td>
                                <td class="<?= $classe; ?>"><? if (($item->situacao) == 't'): ?><a>ativo</a><? else: ?><a>inativo</a>

                            <? endif; ?></td>
                                <td class="<?= $classe; ?>">
                                    <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                                       href="<?= base_url() ?>giah/servidor/excluirteto/<?= $item->teto_id ?>/<?= $servidor->_servidor_id; ?>">
                                        <img border="0" title="Excluir" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_delete.png" />
                                    </a>
                                    <a  href="<?= base_url() ?>giah/servidor/instaciarteto/<?= $item->teto_id ?>/<?= $servidor->_servidor_id; ?>">
                                        <img border="0" title="Detalhes" alt="Detalhes"
                                             src="<?= base_url() ?>img/form/page_white_edit.png" />
                                    </a>        
                                </td>
                            </tr>
                    <?
                                    $i++;
                                endforeach;
                            else :
                    ?>
                                <tr>
                                    <td class="tabela_content01" colspan="7">Sem registros encontrados.</td>
                                </tr>
                    <? endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="tabela_footer" colspan="7">Total de registros: <?= count($lista); ?></th>
                                </tr>
                            </tfoot>
                        </table><!-- Fim da lista de pensionistas -->
                    </div>
        <? if (count($lista) < 2) : ?>
                                    <h3><a href="#">Cadastro</a></h3>
                                    <div><!-- Início do formulário pensionistas -->
                                        <form name="form_teto" id="form_teto" action="<?php echo base_url() ?>giah/servidor/gravarteto" method="post">
                                            <input type="hidden" name="txtServidorID" value="<?= @$servidor->_servidor_id; ?>" />
                                            <input type="hidden" name="txtTetoID" value="0" />
                                            <dl class="dl_cadastro_teto">
                                                <dt>
                                                    <label>Matricula SAM</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="txtMatricula" class="texto02" />
                                                </dd>
                                                <dt>
                                                    <label>Banco</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="txtBanco" class="texto02" />
                                                </dd>
                                                <dt>
                                                    <label>Ag&ecirc;ncia / DV</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="txtAgencia" class="texto03"  /> / <input type="text" class="texto02" name="txtAgenciaDV" />
                                                </dd>
                                                <dt>
                                                    <label>Conta Corrente / DV</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="txtConta" class="texto03"  /> / <input type="text" class="texto02" name="txtContaDV"  />
                                                </dd>
                                                <dt>
                                                    <label>Sal&aacute;rio base</label>
                                                </dt>
                                                <dd>
                                                    <input type="text" name="txtSalarioBase" class="texto03" alt="decimal"  />
                                                </dd>
                                            </dl>
                                            <hr/>
                                            <button type="submit" name="btnEnviar">Enviar</button>
                                            <button type="reset" name="btnLimpar">Limpar</button>
                                        </form>
                                    </div><!-- Fim do formulário pensionistas -->
                                </div>
    <? endif; ?>
                                </div> <!-- Final da DIV content -->
                                <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
                                <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        $('#form_teto').validate( {
            rules: {

                txtMatricula: {
                    required: true,
                    minlength: 3,
                    maxlength: 10
                },
                txtBanco: {
                    required: true,
                    minlength: 3,
                    maxlength: 5
                },
                txtAgencia: {
                    required: true,
                    minlength: 3,
                    maxlength: 5
                },
                txtAgenciaDV: {
                    required: true,
                    minlength: 1,
                    maxlength: 1
                },
                txtConta: {
                    required: true,
                    minlength: 3,
                    maxlength: 12
                },
                txtContaDV: {
                    required: true,
                    minlength: 1,
                    maxlength: 1
                },
                txtSalarioBase: {
                    required: true,
                    minlength: 3
                }

            },
            messages: {

                txtMatricula: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 10 digitos"
                },
                txtBanco: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 5 digitos"
                },
                txtAgencia: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 5 digitos"
                },
                txtAgenciaDV: {
                    required: "*",
                    minlength: "Minimo 1 digitos",
                    maxlength: "Maximo 1 digitos"
                },
                txtConta: {
                    required: "*",
                    minlength: "Minimo 3 digitos",
                    maxlength: "Maximo 12 digitos"
                },
                txtContaDV: {
                    required: "*",
                    minlength: "Minimo 1 digitos",
                    maxlength: "Maximo 1 digitos"
                },
                txtSalarioBase: {
                    required: "*",
                    minlength: "Minimo 1 digitos"
                }
            }
        });
    });

</script>