
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Faturamento XML Laudo</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $convenios = $this->convenio->listarconvenionaodinheiro();
            $medicos = $this->operador_m->listarmedicos();
            $pacientes = $this->guia->listarpacientes();
            $paciente_nome = "";
            $paciente_id = "";
            $classificacao = $this->guia->listarclassificacao();
            $empresa = $this->guia->listarempresas();
            $guia = "";
            ?>
            <form method="post" action="<?= base_url() ?>ambulatorio/laudo/gerarxml">
                <dl>
                    <dt>
                        <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datainicio" alt="date" name="datainicio" class="size1" />
                    </dd>
                    <dt>
                        <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text"  id="datafim" alt="date" name="datafim" class="size1"/>
                    </dd>
                    <dt>
                        <label>Paciente*</label>
                    </dt>
                    <dd>
                        <input type="text" name="paciente" id="paciente" value="" class="size2"/>
                    </dd>                   
                    <input type="hidden" name="paciente_id" id="paciente_id" value="" class="texto01"/>                                              
                    <dt>
                        <label>Convenio</label>
                    </dt>
                    <dd>
                        <select name="convenio" id="convenio" class="size2">
                            <option value="" >TODOS</option>
                            <? foreach ($convenios as $value) : ?>
                                <option value="<?= $value->convenio_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                        <label>Medico</label>
                    </dt>
                    <dd>
                        <select name="medico" id="medico" class="size2">
                            <option value="0">TODOS</option>
                            <? foreach ($medicos as $value) : ?>
                                <option value="<?= $value->operador_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                        <label>Apagar</label>
                    </dt>
                    <dd>
                        <select name="apagar" id="apagar" class="size2">
                            <option value=0 >NAO</option>
                            <option value=1 >SIM</option>
                        </select>
                    </dd>
                    <!--                    <dt>
                                        <label>Vers&atilde;o XML</label>
                                        </dt>
                                        <dd>
                                            <select name="xml" id="xml" class="size2">
                                                <option value='3.02.00' >3.02.00</option>
                                                <option value='3.02.01' >3.02.01</option>
                                            </select>
                                        </dd>-->
                    <dt>
                        <label>Empresa</label>
                    </dt>
                    <dd>
                        <select name="empresa" id="empresa" class="size2">
                            <? foreach ($empresa as $value) : ?>
                                <option value="<?= $value->empresa_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                            <option value="0">TODOS</option>
                        </select>
                    </dd>
                    <dl>
                        <button type="submit" id="enviar">Gerar</button>
                        </form>
                        </div>

                        <h3 class="singular"><a href="#">Arquivos XML Laudo</a></h3>
                        <div>
                            <table>
                               
                                    <?
                                    $this->load->helper('directory');
                                    foreach ($convenios as $item) {
                                        foreach ($pacientes as $paciente) {
                                            $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/laudo/$item->nome/$paciente->paciente_id/");
                                            if ($arquivo_pasta != false) {
                                                ?>
                                                 <tr><th width="900px" class="tabela_header"><? echo $paciente->nome; ?></th></tr>
                                            
                                                <?
                                                $covenionome = $item->nome;
                                                $pacientenome = $paciente->nome;

                                                foreach ($arquivo_pasta as $value) {
                                                    ?>
                                                 <td style="float: left; margin-left: 5px"> <img  width="50px" height="50px" onclick="javascript:window.open('<? base_url() . "upload/laudo/" . $covenionome . "/" . $pacientenome . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<? base_url() . "upload/laudo/" . $covenionome . "/" . $value ?>"><br><? echo $value ?></td>
<!--                                                    <td>&nbsp;</td>       -->
                                                <br><?
                                            }
                                        }
                                    }
                                    ?>
                                    
                                    <?
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
                                                            $("#datainicio").datepicker({
                                                                autosize: true,
                                                                changeYear: true,
                                                                changeMonth: true,
                                                                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                                                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                                buttonImage: '<?= base_url() ?>img/form/date.png',
                                                                dateFormat: 'dd/mm/yy'
                                                            });
                                                        });

                                                        $(function () {
                                                            $("#datafim").datepicker({
                                                                autosize: true,
                                                                changeYear: true,
                                                                changeMonth: true,
                                                                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                                                                dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                                                                buttonImage: '<?= base_url() ?>img/form/date.png',
                                                                dateFormat: 'dd/mm/yy'
                                                            });
                                                        });

                                                        $(function () {
                                                            $("#paciente").autocomplete({
                                                                source: "<?= base_url() ?>index?c=autocomplete&m=pacientes",
                                                                minLength: 3,
                                                                focus: function (event, ui) {
                                                                    $("#paciente").val(ui.item.label);
                                                                    return false;
                                                                },
                                                                select: function (event, ui) {
                                                                    $("#paciente").val(ui.item.value);
                                                                    $("#paciente_id").val(ui.item.id);
                                                                    return false;
                                                                }
                                                            });
                                                        });

                                                        $(function () {
                                                            $("#accordion").accordion();
                                                        });

                        </script>


