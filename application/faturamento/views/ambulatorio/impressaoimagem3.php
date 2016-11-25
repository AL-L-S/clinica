        <table>
            
        <tr>
    <?
        $c=0;
    
    foreach ($arquivo_pasta as $value) :
           $c++; 
    endforeach;
    $i = 0;
    $b = 0;
$y=0;
$z=0;
    if ($arquivo_pasta != false):
        foreach ($arquivo_pasta as $value) :
        $i++;
        $b++;
        $y++;
        $z++;
    if ($i <=2){
            ?>
    
            <td width="30px"></td><td><a><img  width="410px" height="410px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></td>
            
            <?
    }
    if ($i ==3){
        $i=0;
        ?>
        </tr>
        <tr>
        
        <td width="30px"></td><td colspan="3"><a><center><img  width="410px" height="410px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></center></a></td>
            </tr>
            <tr>
            <?
    }
        if ($b==3){
        $i=0;
        ?>

            <?
    }

        endforeach;
    endif
    ?>
</table>
<h5>Fortaleza: <?= substr($laudo['0']->data_cadastro, 8, 2); ?>/<?= substr($laudo['0']->data_cadastro, 5, 2); ?>/<?= substr($laudo['0']->data_cadastro, 0, 4); ?></h5>



