<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <div id="accordion">
            <form name="form_importacao" id="form_importacao" action="<?= base_url() ?>ambulatorio/exame/ordenarimagens/<?= $exame_id ?>/<?= $sala_id ?>" method="post">
                <div class="bt_link">
                    <a href="<?= base_url() ?>ambulatorio/exame/moverimagensmedico/<?= $exame_id ?>/<?= $sala_id ?>">Carregar</a>
                </div>

                <div >
                    <fieldset style="overflow: hidden">
                        <div class="bt_link_new">
                            <a href="#" onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/limparnomes/" . $exame_id; ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=400,height=200');">
                                <font size="-1">Limpar Nomes</font>
                            </a>
                        </div>
                        <br>
                        <ul style="height: 300px"  id="sortable">
                            <legend>Vizualizar imagens</legend>

                            <?
                            if ($arquivo_pasta != false):
                                foreach ($arquivo_pasta as $value) :
                                    ?>
                                    <li class="" style="height: 115px"><input type="hidden"  value="<?= $value ?>" name="teste[]" class="size2" />
                                        <a href="#" onclick="javascript:window.open('<?= base_url() . "ambulatorio/laudo/alterarnomeimagem/" . $exame_id . "/" . $value ?> ', '_blank', 'toolbar=no,Location=no,menubar=no,width=900,height=800');">
                                            Nome
                                        </a>
                                        <img  width="100px" height="100px" src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>">
                                        <a href="<?= base_url() ?>ambulatorio/exame/excluirimagemmedico/<?= $exame_id ?>/<?= $value ?>/<?= $sala_id ?>">Excluir
                                        </a>

                                    </li>
                                    <?
                                endforeach;
                            endif
                            ?>
                        </ul>
                    </fieldset>
                    <button type="submit" name="btnEnviar">Ordenar</button>
                </div> <!-- Final da DIV content -->
                <!--                <br>
                                <br>
                                <div >
                <?= form_open_multipart(base_url() . 'ambulatorio/exame/importarimagem'); ?>
                                    <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br>
                                    <input type="file" name="userfile"/>
                                    <button type="submit" name="btnEnviar">Enviar</button>
                                    <input type="hidden" name="exame_id" value="<?= $exame_id; ?>" />
                                    <input type="hidden" name="sala_id" value="<?= $sala_id; ?>" />
                <?= form_close(); ?>
                
                                </div>-->
            </form>

            <div >
                <fieldset>
                    <ul id="sortable">
                        <legend>Imagens excluidas</legend>
                        <table>
                            <?
                            if ($arquivos_deletados != false):
                                foreach ($arquivos_deletados as $item) :
                                    ?>
                                    <td><br><center><img  width="100px" height="100px"src="<?= base_url() . "uploadopm/" . $exame_id . "/" . $item ?>"><br><a href="<?= base_url() ?>ambulatorio/exame/restaurarimagemmedico/<?= $exame_id ?>/<?= $item ?>/<?= $sala_id ?>">restaurar</center></a></td>
                                    <?
                                endforeach;
                            endif
                            ?>
                        </table>
                    </ul>
                </fieldset>
            </div> <!-- Final da DIV content -->
        </div> <!-- Final da DIV content -->
    </div> <!-- Final da DIV content -->
</body>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 800px; overflow-x: auto; overflow-y: auto;}
    #sortable li { margin: 3px 3px 10px 0; padding: 10px; float: left; width: 100px; height: 90px; font-size: 1em; text-align: center; }
</style>
<!--        <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
                                            $(document).ready(function () {
                                                $('#sortable').sortable();
                                            });



</script>
