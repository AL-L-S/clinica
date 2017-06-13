<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_menuitens" id="form_menuitens" action="<?= base_url() ?>ambulatorio/empresa/gravaripservidor/<?= @$obj->_empresa_id; ?>" method="post">
        <fieldset>
            <legend>Acesso Externo Servidores Multiempresa</legend>
            <div>
                <label>Nome</label>
                <input type="hidden" name="txtoperador_id" value="<?= @$obj->_empresa_id; ?>" />
                <input type="text" name="txtNome" class="texto10 bestupper" value="<?= @$obj->_nome; ?>"  readonly />
            </div>

        </fieldset>
        <fieldset>
            <legend>Cadastrar IP de Acesso aos servidores</legend>

            <div>
                <label>Endereço de rede do Servidor</label>
                <input type="text" name="ipservidor" class="texto04"  value="" required/>
            </div>
            <div>
                <label>Nome da Clinica</label>
                <input type="text" name="nome_clinica" class="texto04"  value="" required/>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div>
        </fieldset>
    </form>


    <fieldset>
        <?
        $contador = count($servidores);
        if ($contador > 0) {
            ?>
            <table id="table_agente_toxico" border="0">
                <thead>

                    <tr>
                        <th class="tabela_header">Nome Clinica</th>
                        <th class="tabela_header">Endereço de Rede</th>
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <?
                $estilo_linha = "tabela_content01";
                foreach ($servidores as $item) {
                    ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
                    ?>
                    <tbody>
                        <tr>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->nome_clinica; ?></td>
                            <td class="<?php echo $estilo_linha; ?>"><?= $item->ip_externo; ?></td>
                            <td class="<?php echo $estilo_linha; ?>" width="100px;"><div class="bt_link">
                                    <a href="<?= base_url() ?>ambulatorio/empresa/excluiripservidor/<?= $item->empresas_acesso_externo_id; ?>/<?= $empresa_id; ?>">Excluir
                                    </a></div>

                            </td>
                        </tr>

                    </tbody>
                    <?
                }
            }
            ?>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="4">
                    </th>
                </tr>
            </tfoot>
        </table> 

    </fieldset>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">






    //$(function(){     
    //    $('#exame').change(function(){
    //        exame = $(this).val();
    //        if ( exame === '')
    //            return false;
    //        $.getJSON( <?= base_url() ?>autocomplete/horariosambulatorio, exame, function (data){
    //            var option = new Array();
    //            $.each(data, function(i, obj){
    //                console.log(obl);
    //                option[i] = document.createElement('option');
    //                $( option[i] ).attr( {value : obj.id} );
    //                $( option[i] ).append( obj.nome );
    //                $("select[name='horarios']").append( option[i] );
    //            });
    //        });
    //    });
    //});





    $(function () {
        $("#accordion").accordion();
    });


    $(document).ready(function () {
        jQuery('#form_exametemp').validate({
            rules: {
                txtNome: {
                    required: true,
                    minlength: 3
                },
                nascimento: {
                    required: true
                },
                idade: {
                    required: true
                }
            },
            messages: {
                txtNome: {
                    required: "*",
                    minlength: "!"
                },
                nascimento: {
                    required: "*"
                },
                idade: {
                    required: "*"
                }
            }
        });
    });

</script>