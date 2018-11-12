<meta charset="UTF-8">
<div class="content ficha_ceatox">


<?foreach($examesGrupo as $key => $valor){?>
    <table>
        <tbody>
        
        <tr>
            <td  ><font size = -2><b><?= $paciente['0']->nome; ?></b></td>
            <td ><font size = -2></td>
        </tr>
        <tr>
            <td  ><font size = -2><?= $exames[0]->medicosolicitante; ?></td>
            <td ><font size = -2></td>
        </tr>
        </tbody>
    </table>
    <table>
        <tbody>
            <?
            $i = 0;
            foreach ($exames as $item) :
                $i++;
                if ($item->grupo == $valor->grupo) {
                    ?>
                <td ><font size = -2><?= $item->procedimento ?> / </td>
                <?
                if ($i == 2) {
                    $i = 0;
                    ?><tr>
                            <?
                        }
                    }
                endforeach;
                ?>
            </tbody>
    </table>
    <table>
        <tr>
            <!-- Como a variavel $item tá sendo definida ali no foreach, da pra usar aqui -->
            <td  ><font size = -2><?= $paciente['0']->paciente_id; ?> - </td>
            <td  ><font size = -2> <?= date("d/m/Y", strtotime($item->data)); ?></td>
        </tr>
    </table>
    <br>
    <br>
    <!-- <br> -->
<?}?>   
</div>
