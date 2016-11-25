<div class="content ficha_ceatox">
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/sala/gravar" method="post">
        <input type="hidden" name="txtpaciente_id" value="<?= $paciente_id; ?>" />
        <input type="hidden" name="txtguia_id" value="<?= $ambulatorio_guia_id; ?>" />
        <table id="table_procedimento" border="0">
            <thead>
                <tr>
                    <td>Procedimento</td>
                    <td>&nbsp;</td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <div class="bt_link_new mini_bt">
                            <a href="#" id="plusprocedimento">Adicionar Ítem</a>
                        </div>
                    </td>
                </tr>
            </tfoot>

            <tbody>
                <tr class="linha1">
                    <td>
                        <select  name="procedimento[1]" class="size2" >
                            <option value="-1">Selecione</option>
                            <? foreach ($procedimento as $item) : ?>
                                <option value="<?= $item->procedimento_tuss_id; ?>"><?= $item->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <a href="#" class="delete">Excluir</a>
                    </td>
                </tr>
            </tbody>
        </table>  
        <hr/>
        <button type="submit" name="btnEnviar">Enviar</button>
        <button type="reset" name="btnLimpar">Limpar</button>
        <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
    </form>


</div> <!-- Final da DIV content -->

<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

    
    var idlinha =2;
    var classe = 2;

    $(document).ready(function(){
        $('#plusprocedimento').click(function(){
            var linha = "<tr class='linha"+classe+"'>";
            linha += "<td>";
            linha += "<select  name='procedimento["+idlinha+"]' class='size2'>";
            linha += "<option value='-1'>Selecione</option>";
<?
foreach ($procedimento as $item) {
    echo 'linha += "<option value=\'' . $item->procedimento_tuss_id . '\'>' . $item->nome . '</option>";';
}
?>
linha += "</select>";
linha += "</td>";
linha += "<td>";
linha += "<a href='#' class='delete'>Excluir</a>";
linha += "</td>";
linha += "</tr>";

idlinha++;
classe = (classe == 1) ? 2 : 1;
$('#table_procedimento').append(linha);
addRemove();
return false;
});
});


</script>