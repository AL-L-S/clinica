<div class="content"> <!-- Inicio da DIV content -->
    <div class="bt_link_voltar">
        <a href="<?= base_url() ?>giah/servidor/pesquisar/<?= $servidor->_nome; ?>">
            Voltar
        </a>
    </div>

    <?php $this->load->view("giah/snippets/servidor-detalhe"); ?>

    <div id="accordion">
        <h3><a href="#">Lista de suplementares</a></h3>
        <div>
            <table>
                <thead>
                    <tr>
                        <th class="tabela_header">Modelo</th>
                        <th class="tabela_header">Marca</th>
                        <th class="tabela_header">Placa</th>
                        <th class="tabela_header" width="50px;">&nbsp;</th>
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
                                <td class="<?= $classe; ?>"><?= $item->modelo; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->marca; ?></td>
                                <td class="<?= $classe; ?>"><?= substr($item->placa, 0, 3) . '-' . substr($item->placa, 3); ?></td>
                                <td class="<?= $classe; ?>" width="50px">
                                    <a onclick="javascript: return confirm('Deseja realmente excluir o veiculo de <?= $servidor->_nome; ?>');"
                                       href="<?= base_url() ?>giah/veiculo/excluir/<?= $item->servidor_id; ?>/<?= $item->veiculo_servidor_id; ?>">
                                        <img border="0" title="Excluir" alt="Excluir"
                                             src="<?= base_url() ?>img/form/page_white_delete.png" />
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
                            <th class="tabela_footer" colspan="4">Total de registros: <?= count($lista); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <h3><a href="#">Cadastro</a></h3>
            <div><!-- Início do formulário suplementar -->
                <form name="form_veiculo" id="form_veiculo" action="<?= base_url() ?>giah/veiculo/gravar" method="post">
                    <input type="hidden" name="txtServidorID" value="<?= $servidor->_servidor_id; ?>" />
                    <dl>
                        <dt>
                            <label>Modelo</label>
                        </dt>
                        <dd>
                            <input type="text" name="txtModelo" class="texto03"/>
                        </dd>
                        <dt>
                            <label>Marca</label>
                        </dt>
                        <dd>
                            <select name="txtMarca" class="size1">
                            <? foreach ($marca as $item) : ?>
                                <option value="<?= $item->marca_id; ?>"><?= $item->marca; ?></option>
                            <? endforeach; ?>
                            </select>
                        </dd>
                        <dt>
                            <label>Cor</label>
                        </dt>
                        <dd>
                            <select name="txtCor" class="size1">
                            <? foreach ($cor as $item) : ?>
                                    <option value="<?= $item->cor_id; ?>"><?= $item->cor; ?></option>
                            <? endforeach; ?>
                                </select>
                            </dd>
                            <dt>
                                <label>Placa</label>
                            </dt>
                            <dd class="dd_texto">
                                <input type="text" name="txtPlaca"id="txtPlaca" alt="ZZZ-9999" class="texto03 bestupper"/><br/>
                            </dd>
                        </dl>
                        <hr/>
                        <button type="submit" name="btnEnviar">Enviar</button>
                        <button type="reset" name="btnLimpar">Limpar</button>
                    </form>
                </div>

            </div>
        </div> <!-- Final da DIV content -->
        <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
        <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#servidor" ).accordion();
        $( "#accordion" ).accordion();
    });

     

    $(document).ready(function(){
        jQuery('#form_veiculo').validate( {
            rules:
                {
                txtPlaca:
                    {
                    required: true,
                    minlength: 7,
                    maxLength: 7
                }
            },
            messages:
                {
                txtPlaca:
                    {
                    required: "*",
                    minlength: "!",
                    maxLength: "!"
                }
            }
        });


    });

</script>