<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar imagem total</a></h3>
        <div >
            <a href="<?= base_url() ?>ambulatorio/exame/moverimagens/<?= $exame_id ?>/<?= $sala_id ?>">Carregar</a>
        </div>
        <h3><a href="#">Carregar imagem individual </a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'ambulatorio/exame/importarimagem'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" multiple="" name="arquivos[]"/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="exame_id" value="<?= $exame_id; ?>" />
            <input type="hidden" name="sala_id" value="<?= $sala_id; ?>" />
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar imagens </a></h3>
        <div >
            <table>
                <?
                if ($arquivo_pasta != false):
                    foreach ($arquivo_pasta as $value) :
                        ?>
                        <td><center><img  width="100px" height="100px" onclick="javascript:window.open('<?= base_url() . "upload/" . $exame_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>"><br><a href="<?= base_url() ?>ambulatorio/exame/excluirimagem/<?= $exame_id ?>/<?= $value ?>/<?= $sala_id ?>">Excluir</center></a></td>
                        <?
                    endforeach;
                endif
                ?>
            </table>
        </div> <!-- Final da DIV content -->

        <h3><a href="#">Imagens excluidas </a></h3>
        <div >
            <table>
                <?
                if ($arquivos_deletados != false):
                    foreach ($arquivos_deletados as $item) :
                        ?>
                        <td><br><center><img  width="100px" height="100px"src="<?= base_url() . "uploadopm/" . $exame_id . "/" . $item ?>"><br><a href="<?= base_url() ?>ambulatorio/exame/restaurarimagem/<?= $exame_id ?>/<?= $item ?>/<?= $sala_id ?>">restaurar</center></a></td>
                        <?
                    endforeach;
                endif
                ?>
            </table>
        </div> <!-- Final da DIV content -->

        <h3><a href="#">Gastos de Sala</a></h3>
        <div >
            <div class="bt_link">
                <a style="cursor: pointer;" onclick="javascript:window.open('<?= base_url() . "ambulatorio/exame/gastosdesala/$exame_id/$convenio_id/$sala_id" ?>', '_blank', 'toolbar=no,Location=no,menubar=no,scrollbars=yes,width=1000,height=600');">
                    Inserir
                </a>
            </div>
        </div>
        <h3><a href="#">Anexar Arquivos</a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'ambulatorio/exame/importararquivopdf'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" multiple="" name="arquivos[]"/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="exame_id" value="<?= $exame_id; ?>" />
            <input type="hidden" name="ambulatorio_laudo_id" value="<?= $ambulatorio_laudo_id ?>" />
            <input type="hidden" name="sala_id" value="<?= $sala_id; ?>" />
            <?= form_close(); ?>
        </div>
        <h3><a href="#">Arquivos</a></h3>
        <div >
            <table>
                <tr>
                    <?
                    $i = 0;
                    if ($arquivo_pasta_pdf != false):
                        foreach ($arquivo_pasta_pdf as $value) :
                            $i++;
                            ?>

                            <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/consulta/" . $ambulatorio_laudo_id . "/" . $value ?>"><br><? echo substr($value, 0, 10) ?><br><a href="<?= base_url() ?>ambulatorio/laudo/excluirimagem/<?= $ambulatorio_laudo_id ?>/<?= $value ?>">Excluir</a></td>
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
        </div>
        <!-- Final da DIV content -->
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });



</script>
