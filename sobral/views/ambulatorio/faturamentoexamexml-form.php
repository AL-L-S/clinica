
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Faturamento XML Guia</a></h3>
        <div>
            <?
            $salas = $this->exame->listartodassalas();
            $convenios = $this->convenio->listarconvenionaodinheiro();
            $medicos = $this->operador_m->listarmedicos();
            $classificacao = $this->guia->listarclassificacao();
            $empresa = $this->guia->listarempresas();
            $guia = "";
            ?>
            <form method="post" action="<?= base_url() ?>ambulatorio/exame/gerarxml">
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
                    <label>Tipo</label>
                    </dt>
                    <dd>
                        <select name="tipo" id="tipo" class="size2">
                            <option value='0' >TODOS</option>
                            <option value="" >SEM RETORNO</option>
                            <? foreach ($classificacao as $value) : ?>
                                <option value="<?= $value->tuss_classificacao_id; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>
                        </select>
                    </dd>
                    <dt>
                    <label>Ra&ccedil;a / Cor</label>
                    </dt>
                    <dd>
                        <select name="raca_cor" id="txtRacaCor" class="size2">
                            <option value=0 >TODOS</option>
                            <option value=-1 >Sem o Ind&iacute;gena</option>
                            <option value=1 >Branca</option>
                            <option value=2 >Amarela</option>
                            <option value=3 >Preta</option>
                            <option value=4 >Parda</option>
                            <option value=5>Ind&iacute;gena</option>
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
                    <dt>
                    <label>Vers&atilde;o XML</label>
                    </dt>
                    <dd>
                        <select name="xml" id="xml" class="size2">
                            <option value='3.02.00' >3.02.00</option>
                            <option value='3.02.01' >3.02.01</option>
                        </select>
                    </dd>
                    <dt>
                    <label>Modelo</label>
                    </dt>
                    <dd>
                        <select name="modelo" id="modelo" class="size2">
                            <option value='cpf' >cpf</option>
                            <option value='cnpj'>cnpj</option>
                        </select>
                    </dd>
                    <dt>
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

                        <h3 class="singular"><a href="#">Arquivos XML Guia</a></h3>
                        <div>
                            <table>
                                <tr>
                                    <?
                                    $this->load->helper('directory');
                                    foreach ($convenios as $value) :

                                        $arquivo_pasta = directory_map("/home/sisprod/projetos/clinica/upload/cr/$value->nome/");
                                        if ($arquivo_pasta != false) {
                                            ?>
                                            <td width="10px" class="tabela_header"><? echo $value->nome; ?></td></tr>
                                        <tr>
                                            <?
                                            $covenionome = $value->nome;

                                            foreach ($arquivo_pasta as $value) {
                                                ?>
                                                <td width="10px"> <img  width="50px" height="50px" onclick="javascript:window.open('<?= base_url() . "upload/cr/" . $covenionome . "/" . $value ?>', '_blank', 'toolbar=no,Location=no,menubar=no,width=1200,height=600');" src="<?= base_url() . "upload/cr/" . $covenionome . "/" . $value ?>"><br><? echo $value ?></td>
                                                <td>&nbsp;</td>        
                                            <br><?
                                }
                            }
                                        ?>
                                    </tr>
                                    <?
                                endforeach;
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

                                        $(function() {
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

                                        $(function() {
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

                                        $(function() {
                                            $("#accordion").accordion();
                                        });

                        </script>
