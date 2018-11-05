<div class="content"> <!-- Inicio da DIV content -->

    <div id="accordion">
        <h3 class="singular">Detalhar NR</h3>
        <div>

            <form method="get" action="<?= base_url() ?>ambulatorio/guia/gravardetalhamentoaso">
                <table>
                    <h3>Selecione os Crit&eacute;rios a baixo:</h3>
                    <tr>
                        <td width="400px"><input type="checkbox" name="diagnostico1" id="diagnostico1" value="on">Apto para as atividades da fun&ccedil;&atilde;o</td>
                        <td width="400px"><input type="checkbox" name="diagnostico2" id="diagnostico2" value="on">Inapto para as atividades da fun&ccedil;&atilde;o</td>
                        <td width="250px"><input type="checkbox" name="diagnostico3" id="diagnostico3" value="on">N&atilde;o se Aplica</td>                            
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="diagnostico4" id="diagnostico4" value="on">Apto para trabalho em altura</td>
                        <td><input type="checkbox" name="diagnostico5" id="diagnostico5" value="on">Inapto para trabalho em altura</td>
                        <td><input type="checkbox" name="diagnostico6" id="diagnostico6" value="on">N&atilde;o Mapeado</td>                            
                        <td><input type="checkbox" name="diagnostico6" id="diagnostico6" value="on">N&atilde;o se Aplica</td>                            
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="diagnostico7" id="diagnostico7" value="on">Apto para espa&ccedil;o confinado</td>
                        <td><input type="checkbox" name="diagnostico8" id="diagnostico8" value="on">Inapto para espa&ccedil;o confinado</td>                                                        
                        <td><input type="checkbox" name="diagnostico8" id="diagnostico8" value="on">N&atilde;o Mapeado</td>                                                        
                        <td><input type="checkbox" name="diagnostico8" id="diagnostico8" value="on">N&atilde;o se Aplica</td>                                                        
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para trabalho noturno</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para trabalho noturno</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para brigada de inc&ecirc;ndio</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para brigada de inc&ecirc;ndio</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para trabalho Mov. Cargas</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para trabalho Mov. Cargas</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para Manipula&ccedil;&atilde;o de Alimentos</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para manipula&ccedil;&atilde;o de Alimentos</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para Equipamento M&oacute;vel</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para Equipamento M&oacute;vel</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para Ve&iacute;culos Auto Motores</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para Ve&iacute;culos Auto Motores</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para trabalho com Eletricidade</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para trabalho com Eletricidade</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para Produtos Qu&iacute;micos</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para Produtos Qu&iacute;micos</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                    <tr>
                        <td><input type="checkbox" name="diagnostico9" id="diagnostico9" value="on" >Apto para Produtos Inflam&aacute;veis</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">Inapto para Produtos Inflam&aacute;veis</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o Mapeado</td>
                        <td><input type="checkbox" name="diagnostico10" id="diagnostico10" value="on">N&atilde;o se Aplica</td>
                    </tr> 
                </table>
                <br><br>
                <table>
                    <tr>
                        <td>
                            <button type="submit" name="btnEnviar">Enviar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function () {
        $("#accordion").accordion();
    });

</script>

