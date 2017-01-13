<table>
    <?
    $i = 0;
    if ($arquivo_pasta != false):
        foreach ($arquivo_pasta as $value) :
            $i++;
            
                ?>
                <tr>
                    <td><a><img  width="600px" height="500px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"></a></td>
                </tr>  
            
                <?

        endforeach;
    endif
    ?>
</table>
<h5>Fortaleza: <?= substr($laudo['0']->data_cadastro, 8, 2); ?>/<?= substr($laudo['0']->data_cadastro, 5, 2); ?>/<?= substr($laudo['0']->data_cadastro, 0, 4); ?></h5>



