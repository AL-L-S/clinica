
<meta charset="utf-8">

<div id="conteudo"> <!-- Inicio da DIV content -->
    <form name="form_gastodesala" id="form_gastodesala" action="<?= base_url() ?>ambulatorio/exame/gravargastodesala" method="post">
        <fieldset>
            <legend>Paciente</legend>
            <div>
                <input type="hidden" name="procedimento_id" id="procedimento_id" value=""/>
                <input type="hidden" name="exame_id" value="<?= $exames_id; ?>"/>
                <input type="hidden" name="txtguia_id" value="<?= $guia_id; ?>"/>
                <input type="hidden" name="txtpaciente_id" value="<?= $paciente[0]->paciente_id; ?>"/>
                <table>
                    <tr>
                        <td><label>Nome</label></td>
                        <td><label>Sexo</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="paciente" class="input_grande" value="<?= $paciente[0]->nome; ?>" readonly /></td>
                        <td><input type="text" name="sexo" class="input_pequeno" value="<? if ($paciente[0]->sexo == 'F') {
    echo 'Feminino';
} else {
    echo 'masculino';
} ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td><label>Nascimento</label></td>
                        <td><label>Telefone</label></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="nascimento" class="input_pequeno" value="<?= str_replace('-', '/', date('d-m-Y', strtotime($paciente[0]->nascimento))); ?>" readonly /></td>
                        <td><input type="text" name="celular" class="input_pequeno" value="<?= $paciente[0]->celular; ?>" readonly /></td>
                    </tr>
                </table>

            </div>
        </fieldset>  
        <fieldset>
            <legend>Gastos de Sala</legend>
            <table>
                <tr>
                    <td> <label>Produtos</label> </td>
                    <td> <label>Quantidade</label> </td>
                    <!--<td> <label>Faturar</label> </td>-->
                </tr>
                <tr id="gastos">
                    <td> 
                        <select name="produto_id" id="produto_id" class="size4" style="width: 250px" required="true">
                            <option value="">SELECIONE</option>
<? foreach ($produtos as $value) : ?>
                            <option value="<?= $value->produto_id; ?>" onclick="procedimento_id(<?= $value->procedimento_id; ?>)"><?php echo $value->descricao; ?></option>
<? endforeach; ?>
                        </select> 
                    </td>
                    <td> <input style="width: 100px" type="number" name="txtqtde" min="1" required="true"/> </td>
                    
                </tr>
                <tr>
                    <td> <button type="submit" name="btnEnviar" >Adicionar</button> </td>
                </tr>
            </table>
        </fieldset>

    <fieldset>
<?
    if (count($produtos_gastos) > 0) {
?>
            <table id="table_agente_toxico" border="0">
                <thead>
    
                    <tr>
                        <th class="tabela_header">Produto</th>
                        <th class="tabela_header">Qtde</th>
                        <!--<th class="tabela_header">Faturado</th>-->
                        <th class="tabela_header">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
    <?
            $estilo_linha = "tabela_content01";
            foreach ($produtos_gastos as $item) {
                ($estilo_linha == "tabela_content01") ? $estilo_linha = "tabela_content02" : $estilo_linha = "tabela_content01";
    ?>

                        <tr>
                            <td class="<?php echo $estilo_linha;  ?>" width="450px;"><center><? echo $item->descricao;  ?></center></td>
                            <td class="<?php echo $estilo_linha;  ?>"><center><? echo $item->quantidade;  ?></center></td>
                            <td class="<?php echo $estilo_linha;  ?>" width="100px;">
                                <a href="<?= base_url() ?>ambulatorio/exame/excluirgastodesala/<?= $item->ambulatorio_gasto_sala_id;  ?>/<?= $exames_id; ?>" class="delete">
                                </a>
                            </td>
                        </tr>
    
                    
        <?
            }
                ?>
                </tbody>
            <?    
    }
 ?>
            <tfoot>
                <tr>
                    <th class="tabela_footer" colspan="3">
                    </th>
                </tr>
            </tfoot>
        </table> 
    </fieldset>
</form>

</div> <!-- Final da DIV content -->

<style>
    .input_grande{
        width: 400px;
    }
    .input_pequeno{
        width: 150px;
    }
    input, label{
        margin-left: 10px;
    }
    legend{
        font-size: 15px;
    }
    #conteudo{
        overflow-y: auto;
    }
</style>

<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
                                    function procedimento_id(id) {
                                        if(id != undefined){
                                            $('#procedimento_id').val(id);
                                            
                                            var verifica = $("#faturar").length;
                                            if (verifica == 0){
                                                var faturar = '<td> <input type="checkbox" name="faturar" id="faturar"/> <label>Faturar</label></td>';
                                                $('#gastos').append(faturar);
                                            }
                                        } 
                                        else{
                                            var verifica = $("#faturar").length;
                                            if (verifica == 1){
                                                $("#faturar").parent().remove();
//                                                console.log(i);
                                            }
                                        }
                                    }
</script>