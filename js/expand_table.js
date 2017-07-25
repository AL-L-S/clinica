var idlinha=2;

$(document).ready(function(){

    $('#plusAgente').click(function(){
        //


        <tr>
        <td><select  name="agenteToxico[1][]">
        <option value="-1">Selecione</option>
        <option value="<?= $item->gruporesposta_id; ?>"><?= $item->descricao; ?></option>
        <? endforeach; ?>
        </select>
        </td>
        <td><input type="text"  name="nomeComercial[1][]" /></td>
        <td><input type="radio" name="dose[1][]" /></td>
        <td><input type="radio" name="classificacao[1][]" /></td>
        <td>
        <input type="radio" name="clandestino[1][]" value="1" />Sim
        <input type="radio" name="clandestino[1][]" value="2" />Não
        </td>
        <td>
        <a href="#" class="delete">Excluir</a>
        </td>
        </tr>



        var linha =  '<tr>';
        linha += 	'<td><input type="text" name="produto['+idlinha+'][]" title="Campo Obrigatório" class="required"  value=""></td>';
        linha += 	'<td><input type="text" name="qtdProd['+idlinha+'][]" title="Campo Obrigatório" class="required"  value=""></td>';
        linha += 	'<td><input type="radio" name="resfProd['+idlinha+'][]" title="Campo Obrigatório" class="required"  value="sim"  ></td>';
        linha += 	'<td><input type="radio" name="resfProd['+idlinha+'][]" title="Campo Obrigatório" class="required"  value="nao"  >';
        linha += 	'<td><input type="radio" name="org['+idlinha+'][]" title="escolha uma opção" class="required"  value="1" ></td>';
        linha += 	'<td><input type="radio" name="org['+idlinha+'][]" title="escolha uma opção" class="required"  value="2"></td>';
        linha += 	'<td><input type="radio" name="org['+idlinha+'][]" title="escolha uma opção" class="required" value="3"></td>';
        linha +=    '<td><a href="#" class="delete">Excluir</a></td>';
        linha += '</tr>';
        alert(linha);
        idlinha++;
        $('#produtos').append(linha);
        addRemove();
        return false;
    });

    function addRemove() {
        $('.delete').click(function(){
            $(this).parent().parent().remove();
            return false;
        });

    }
});