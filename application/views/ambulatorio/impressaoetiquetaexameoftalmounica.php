<meta charset="UTF-8">
<div class="content ficha_ceatox">
    <table>
        <tbody>
        
        <tr>
            <td  ><font size = -2><b><?= $paciente['0']->nome; ?></b></td>
            <td ><font size = -2></td>
        </tr>
        <tr>
            <td  ><font size = -2><?= $exame[0]->medicosolicitante; ?></td>
            <td ><font size = -2></td>
        </tr>
        <tr>
            <td  ><font size = -2><?= $exame[0]->procedimento; ?></td>
            <td ><font size = -2></td>
        </tr>
   
  
        <tr>

            <td  ><font size = -2><?= $paciente['0']->paciente_id; ?> - <?= date("d/m/Y", strtotime($exame[0]->data)); ?></td>
            <td  ><font size = -2> </td>
        </tr>
        </tbody>
    </table>
    <br>
    <br>
    <!-- <br> -->
  
</div>
