<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar Logomarca </a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'ambulatorio/empresa/gravarlogomarca'); ?>
            <div>
                <label>Informe o arquivo para importa&ccedil;&atilde;o(.jpg)</label><br>
                <input type="file" name="userfile"/>
            </div>
            <br>
            <div>
                <input type="checkbox" name="mostrarLogo" id="mostrarLogo" <? if (@$obj->_mostrar_logo_clinica == 't') echo "checked"; ?>/>
                <label for="mostrarLogo">Mostrar Logomarca na tela principal</label>
                <input type="hidden" name="empresa_id" value="<?= $empresa_id; ?>" />
            </div>            
            <br>
            <div>            
                <button type="submit" name="btnEnviar">Enviar</button>
            </div>            
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar imagens</a></h3>
        <div >
            <table>
                <tr>
                    <?
                    $i = 0;
                    if ($arquivo_pasta != false): ?>
                        <td width="10px">
                            <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "/upload/logomarca/{$empresa_id}/{$arquivo_pasta[0]}" ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "/upload/logomarca/{$empresa_id}/{$arquivo_pasta[0]}" ?>">
                            <br><?= $arquivo_pasta[0] ?><br>
                            <a onclick="javascript: return confirm('Deseja realmente excluir o arquivo <?= $arquivo_pasta[0]; ?>');" href="<?= base_url() ?>ambulatorio/empresa/excluirlogomarca/<?= $empresa_id ?>">Excluir</a>
                        </td>
                    <? endif ?>
            </table>
        </div> <!-- Final da DIV content -->
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });



</script>
