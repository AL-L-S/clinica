<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar imagem individual </a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'ambulatorio/guia/importarimagem'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" name="userfile"/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="guia_id" value="<?= $guia_id; ?>" />
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar imagens </a></h3>
        <div >
            <table>
                <tr>
                    <?
                    $i = 0;
                    if ($arquivo_pasta != false):
                        foreach ($arquivo_pasta as $value) :
                            $i++;
                            ?>

                            <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/guia/" . $guia_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/guia/" . $guia_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a href="<?= base_url() ?>ambulatorio/guia/excluirimagem/<?= $guia_id ?>/<?= $value ?>">Excluir</a></td>
                            <?
                            if ($i == 8) {
                                ?>
                            </tr><tr>
                                <?
                            }
                        endforeach;
                    endif
                    ?>
            </table>
        </div> <!-- Final da DIV content -->
       
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

                                $(function() {
                                    $("#accordion").accordion();
                                });



</script>
