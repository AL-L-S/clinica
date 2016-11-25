
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">            
        <h3 class="singular"><a href="#">Arquivos XML Laudo</a></h3>
        <div>
            <table>

                <?
                $this->load->helper('directory');
                $pacientes = $this->guia->listarpacientes();

                foreach ($pacientes as $paciente) {
                    $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/laudo/$convenio/$paciente_id/");
                    if ($paciente->paciente_id == $paciente_id) {
                        if ($arquivo_pasta != false) {
                            ?>
                            <tr><th width="900px" class="tabela_header"><? echo $paciente->nome; ?></th></tr>
                            <?
                            $pacientenome = $paciente->nome;

                            foreach ($arquivo_pasta as $value) {
                                ?>

                                <td style="float: left; margin-left: 5px"> <img  width="50px" height="50px" onclick="javascript:window.open('<? base_url() . "upload/laudo/" . $convenio . "/" . $pacientenome . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<? base_url() . "upload/laudo/" . $convenio . "/" . $value ?>"><br><? echo $value ?></td>
                                <!--                                                    <td>&nbsp;</td>       -->
                                <br><?
                            }
                        }
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div> <!-- Final da DIV content -->

<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">

                                    $(function () {
                                        $("#accordion").accordion();
                                    });

</script>