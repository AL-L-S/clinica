<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>giah/servidor/pesquisar/<?=$servidor->_nome; ?>">
            Voltar
        </a>
    </div>
    <?php $this->load->view("giah/snippets/servidor-detalhe"); ?>
    <div id="accordion">
        <h3><a href="#">Lista de pensionistas</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->
                <thead>
                    <tr>

                        <th class="tabela_header">Pensionista</th>
                        <th class="tabela_header">CPF</th>
                        <th class="tabela_header">Percentual</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    if (count($lista) > 0) :
                        $i=0;
                        foreach ($lista as $item) :
                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                            ?>
                    <tr>
                        <td class="<?=$classe;?>"><?=$item->nome;?></td>
                        <td class="<?=$classe;?>"><?=$item->cpf;?></td>
                        <td class="<?=$classe;?>"><?=$item->percentual;?></td>
                        <td class="<?=$classe;?>">
                            <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                               href="<?=  base_url()?>giah/pensionista/excluir/<?=$servidor->_servidor_id?>/<?=$item->pensionista_id?>">
                                <img border="0" title="Excluir" alt="Detalhes"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
                    else :
                        ?>
                    <tr>
                        <td class="tabela_content01" colspan="4">Sem registros encontrados.</td>
                    </tr>
                    <? endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">Total de registros: <?=count($lista); ?></th>
                    </tr>
                </tfoot>
            </table><!-- Fim da lista de pensionistas -->
        </div>

        <h3><a href="#">Cadastro</a></h3>
        <div><!-- Início do formulário pensionistas -->
            <form name="form_pensionista" id="form_pensionista" action="<?php echo base_url() ?>giah/pensionista/gravar" method="post">
                <input type="hidden" name="txtServidorID" value="<?=@$servidor->_servidor_id;?>" />

                <dl class="add_pensionista">
                    <dt>
                        <label>Pensionista</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" id="txtNome" class="texto10" />
                    </dd>
                    <dt>
                        <label>CPF</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCPF" class="texto03" alt="cpf"/>
                    </dd>
                    <dt>
                        <label>Banco</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtBanco" id="txtBanco" class="texto01" />
                    </dd>
                    <dt>
                        <label>Ag&ecirc;ncia/DV</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtAgencia" id="txtAgencia"  class="texto02"/> /
                        <input type="text" name="txtAgenciaDV" id="txtAgenciaDV"  class="texto01"/>
                    </dd>
                    <dt>
                        <label class="dt_longo">Conta Corrente/DV</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtConta" id="txtConta" class="texto02" /> /
                        <input type="text" name="txtContaDV" id="txtContaDV" class="texto01" />
                    </dd>
                    <dt>
                        <label>Percentual</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtPercentual" id="txtPercentual" alt="decimal-us" class="texto01" />
                    </dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div><!-- Fim do formulário pensionistas -->
    </div>

</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url()?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

    $(document).ready(function(){
        jQuery('#form_pensionista').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 10
                },
                txtCPF: {
                    required: true,
                    verificaCPF: true
                },
                txtBanco: {
                    required: true,
                    minlength: 2,
                    maxLength: 5
                },
                txtAgencia: {
                    required: true,
                    minlength: 2,
                    maxLength: 5
                },
                txtPercentual:
                    {
                    required: true,
                    minlength: 1,
                    max: 100
                },
                txtConta: {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                txtCPF: {
                    required: "*",
                    verificaCPF: "CPF inválido"
                },
                txtBanco: {
                    required: "*",
                    minlength: "!",
                    maxLength: "!"
                },
                txtPercentual:
                    {
                    required: "*",
                    minlength: "!",
                    max: "Por favor, indique um valor inferior ou igual a 100."

                },
                txtAgencia: {
                    required: "*",
                    minlength: "!",
                    maxLength: "!"
                },
                txtConta: {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>