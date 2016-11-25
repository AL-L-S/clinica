<div class="content"> <!-- Inicio da DIV content -->

    <div class="bt_link_voltar">
        <a href="<?=  base_url()?>sca/ambulancia/">
            Voltar
        </a>
    </div>
    <div id="accordion">
        <h3><a href="#">Lista de Vigilantes</a></h3>
        <div>
            <table><!-- Início da lista de pensionistas -->
                <thead>
                    <tr>

                        <th class="tabela_header">Nome</th>

                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?php
                    $url      = $this->utilitario->build_query_params(current_url(), $_GET);
                    $consulta = $this->vigilante_m->listarVigilantes($_GET);
                    $total    = $consulta->count_all_results();
                    $limit    = 10;
                    isset ($_GET['per_page']) ? $pagina = $_GET['per_page'] : $pagina = 0;

                    if ($total > 0) {
                ?>
                <tbody>
                     <?php
                        $lista = $this->vigilante_m->listarVigilantes($_GET)->limit($limit, $pagina)->get()->result();
                        $estilo_linha = "tabela_content01";
                        foreach ($lista as $item) {
                            ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tr>
                        <td class="<?php echo $estilo_linha; ?>"><?=$item->nome;?></td>

                        <td class="<?php echo $estilo_linha; ?>">
                            <a onclick="javascript: return confirm('Deseja realmente exlcuir esse registro?');"
                               href="<?=  base_url()?>sca/vigilante/excluir/<?=$item->vigilante_id?>">
                                <img border="0" title="Excluir" alt="Detalhes"
                                     src="<?=  base_url()?>img/form/page_white_delete.png" />
                            </a>
                        </td>
                    </tr>

                </tbody>
                <?php
                        }
                    }
                ?>
                <tfoot>
                    <tr>
                        <th class="tabela_footer" colspan="4">
                            <?php $this->utilitario->paginacao($url, $total, $pagina, $limit); ?>
                            Total de registros: <?php echo $total; ?>
                        </th>
                    </tr>
                </tfoot>
            </table><!-- Fim da lista de pensionistas -->
        </div>

        <h3><a href="#">Cadastro</a></h3>
        <div><!-- Início do formulário pensionistas -->
            <form name="form_vigilante" id="form_vigilante" action="<?php echo base_url() ?>sca/vigilante/gravar" method="post">
                <input type="hidden" name="txtServidorID" value="<?=@$servidor->_servidor_id;?>" />

                <dl class="add_vigilante">
                    <dt>
                        <label>Nome</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtNome" id="txtNome" class="texto10" />
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
        jQuery('#form_vigilante').validate( {
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
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