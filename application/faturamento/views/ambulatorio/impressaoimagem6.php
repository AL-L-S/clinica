        <table>
            <tr>
        
    <?

    $i = 0;

    if ($arquivo_pasta != false):
        foreach ($arquivo_pasta as $value) :
        


    if ($i < 2){
$i++;
            ?>
    
            <td width="30px"></td><td><img  width="410px" height="360px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value; ?>"></td>
            
            <?

    }if ($i == 2){
  $i = 0;
        ?></tr><tr>
            <?

}
        endforeach;
    endif
    ?>
</tr>
</table>
<h5>Fortaleza: <?= substr($laudo['0']->data_cadastro, 8, 2); ?>/<?= substr($laudo['0']->data_cadastro, 5, 2); ?>/<?= substr($laudo['0']->data_cadastro, 0, 4); ?></h5>



