<div class="content"> <!-- Inicio da DIV content -->
    <div><!-- Início do formulário suplementar -->
        <form name="form_estacionamento" id="form_estacionamento" action="<?= base_url() ?>giah/veiculo/gravarestacionamento" method="post">

            <dl>
                <dt>
                    <label>Placa</label>
                </dt>
                <dd>
                    <input type="text" name="txtPlacaLabel" alt="ZZZ9999" id="txtPlacaLabel" class="texto03 bestupper"/>
                </dd>
                <dt>
                    <label>Modelo</label>
                </dt>
                <dd>
                    <input type="hidden" id="txtVeiculoServidorID" name="txtVeiculoServidorID"  />
                    <input type="text" id="txtModelo" class="texto_id" name="txtModelo" readonly="true" />
                </dd>
                <dt>
                    <label>Nome</label>
                </dt>
                <dd>
                    <input type="hidden" id="txtServidorID" name="txtServidorID"  />
                    <input type="text" id="txtNome" class="texto07" name="txtNome" readonly="true" />
                </dd>
            </dl>
            <hr/>
            <button type="submit" name="btnEnviar" id="btnEnviar">Enviar</button>
            <button type="reset" name="btnLimpar">Limpar</button>
        </form>
    </div>

    <div>
        <a >Lista de veiculos</a>
        <div>
            <table>
                <thead>
                    <tr>
                        <th colspan="6" class="tabela_title">
                            <form name="form_busca" method="post" action="<?= base_url() ?>giah/veiculo/pesquisarestacionamento">
                                <input type="text" name="filtro" value="<?= @$filtro; ?>" />
                                <button type="submit" id="enviar">Pesquisar</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th class="tabela_header">Placa</th>
                        <th class="tabela_header">Modelo</th>
                        <th class="tabela_header">Nome</th>
                        <th class="tabela_header">Data de Entrada</th>
                        <th class="tabela_header">Entrada</th>
                        <th class="tabela_header">Saida</th>
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
                                <td class="<?= $classe; ?>"><?= substr($item->placa, 0, 3) . '-' . substr($item->placa, 3); ?></td>
                                <td class="<?= $classe; ?>"><?= $item->modelo; ?></td>
                                <td class="<?= $classe; ?>"><?= $item->nome; ?></td>
                                <td class="<?= $classe; ?>"><?= substr($item->dataentrada, 8, 10). substr($item->dataentrada, 4, 4). substr($item->dataentrada, 0, 4); ?></td>
                                <td class="<?= $classe; ?>"><?= substr($item->horaentrada, 0, 5); ?></td>
                                <td class="<?= $classe; ?>" width="50px">
                                    <a onclick="javascript: return confirm('Deseja realmente dar saida no veiculo <?= $item->modelo; ?> \n de <?= $item->nome; ?>');"
                                       href="<?= base_url() ?>giah/veiculo/saidaestacionamento/<?= $item->veiculo_estacionamento_id; ?>">
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
                            <td class="tabela_content01" colspan="6">Sem registros encontrados.</td>
                        </tr>
                    <? endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="tabela_footer" colspan="6">Total de registros: <?= count($lista); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>



        </div>
    </div> <!-- Final da DIV content -->
    <link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
    <script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
    <script type="text/javascript">

        $(function() {
            $( "#txtPlacaLabel" ).autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=estacionamento",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#txtPlacaLabel" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#txtPlacaLabel" ).val( ui.item.value );
                $( "#txtModelo" ).val( ui.item.id );
                $( "#txtNome" ).val( ui.item.nome );
                $( "#txtVeiculoServidorID" ).val( ui.item.veiculo_servidor_id );
                $( "#txtServidorID" ).val( ui.item.servidorid );
                return false;
            }
        });
    });



    $(document).ready(function(){

        $("#txtPlacaLabel").focus();

        $('#txtModelo').focus(function(){
            $("#btnEnviar").focus();
        });
        $('#txtNome').focus(function(){
            $("#txtPlacaLabel").focus();
        });


        $('#form_servidor').validate( {
            rules:
                {
                txtValor:
                    {
                    required: true,
                    minlength: 1
                }
            },
            messages:
                {
                txtValor:
                    {
                    required: "*",
                    minlength: "!"
                }
            }
        });
    });

</script>