<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Carregar Assinatura </a></h3>
        <div >
            <?= form_open_multipart(base_url() . 'seguranca/operador/importarimagem'); ?>
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
            <input type="file" name="userfile"/>
            <button type="submit" name="btnEnviar">Enviar</button>
            <input type="hidden" name="operador_id" value="<?= $operador_id; ?>" />
            <?= form_close(); ?>

        </div>

        <h3><a href="#">Vizualizar imagens </a></h3>
        <div >
            <table>
                <tr>
                    <?
                    $i = 0;
                    if ($arquivo_pasta != false):
                        ?>

                        <td width="10px"><img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/1ASSINATURAS/$operador_id.jpg" ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/1ASSINATURAS/$operador_id.jpg" ?>"><br><? echo "$operador_id.jpg" ?>
                            <br/><a onclick="javascript: return confirm('Deseja realmente excluir o arquivo <?= $operador_id; ?>.jpg');" href="<?= base_url() ?>seguranca/operador/ecluirimagem/<?= $operador_id ?>">Excluir</a></td>
                        <?
                    endif
                    ?>
            </table>
        </div> <!-- Final da DIV content -->
    </div> <!-- Final da DIV content -->
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });



</script>
