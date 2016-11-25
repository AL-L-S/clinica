<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Lista de compet&ecirc;ncias ativas</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Compet&ecirc;ncia</th>
                        <th class="tabela_header">Data abertura</th>
                        <th class="tabela_header">Data fechamento</th>
                        <th class="tabela_header">Situa&ccedil;&atilde;o</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
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
                        <td class="<?=$classe;?>"><?=  substr($item->competencia, 0, 4) .
                                            "/" . substr($item->competencia, 4);?></td>
                        <td class="<?=$classe;?>"><?= date_format(new DateTime($item->data_abertura), "d/m/Y");?></td>
                        <td class="<?=$classe;?>"><?
                                    if (isset ($item->data_fechamento)) {
                                        echo date_format (new DateTime($item->data_fechamento), "d/m/Y" );
                                    }
        ?></td>
                        <td class="<?=$classe;?>"><?=$item->situacao;?></td>
                        <td class="<?=$classe;?>">
        <? if ($item->situacao == 'aberto') : ?>
                            <a onclick="javascript: return confirm('Deseja realmente fechar essa compet&ecirc;cia?');"
                               href="<?=  base_url()?>ponto/competencia/fechar/<?=$item->competencia?>">
                                <img border="0" title="Fechar compet&ecirc;ncia" 
                                     alt="Fechar compet&ecirc;ncia"
                                     src="<?=  base_url()?>img/form/page_white_wrench.png" />
                            </a>
                                    <?
                                    else:
                                        echo "&nbsp;";
                                    endif;
        ?>
                        </td>
                    </tr>
                            <?
                            $i++;
                        endforeach;
                    else :
    ?>
                    <tr>
                        <td class="tabela_content01" colspan="5">Sem registros encontrados.</td>
                    </tr>
<? endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="5">Total de registros: <?=  count($lista); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <h3><a href="#">Cadastro de compet&ecirc;ncia</a></h3>
        <div>
            <form name="form_competencia" id="form_competencia" action="<?=base_url() ?>ponto/competencia/gravar" method="post">
                <dl>
                    <dt>
                        <label>Compet&ecirc;ncia</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtCompetencia" alt="compet" class="texto03" />
                    </dd>
                    <dt>
                        <label>D. abertura</label>
                    </dt>
                    <dd>
                        <input type="text" id="data_abertura" name="txtDataAbertura" class="texto03"/><br/>
                    </dd>
                    <dt>
                        <label>D. fechamento</label>
                    </dt>
                    <dd>
                        <input type="text" id="data_fechamento" name="txtDatafechamento" class="texto03"/><br/>
                    </dd>
                </dl>
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
            </form>
        </div>
    </div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url()?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    $(function() {
        $( "#data_abertura" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?=  base_url()?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });
    $(function() {
        $( "#data_fechamento" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?=  base_url()?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(document).ready(function(){
        jQuery('#form_competencia').validate( {
            rules: {
                txtCompetencia: {
                    required: true,
                    minlength: 6
                },
                txtDataAbertura: {
                    required: true
                },
                txtDatafechamento: {
                    required: true
                }
            },
            messages: {
                txtCompetencia: {
                    required: "*",
                    minlength: "!"
                },
                txtDataAbertura: {
                    required: "*"
                },
                txtDatafechamento: {
                    required: "*"
                }
            }
        });
    });

</script>