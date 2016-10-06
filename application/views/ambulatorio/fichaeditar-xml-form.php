
<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3 class="singular"><a href="#">Cadastro de Honor&aacute;rios M&eacute;dicos</a></h3>
        <div>
            <form name="form_ficha_xml" id="form_ficha_xml" action="<?= base_url() ?>ambulatorio/guia/gravareditarfichaxml/<?= $paciente_id ?>/<?= $exames_id ?>" method="post">

                <dt><label>Peso:</label></dt>
                <dd>
                    <input type="number" name="txtpeso" id="txtpeso" class="texto03" value="<? echo $peso?>">
                </dd>
                <dt>
                    <label>Trabalha ou trabalhou com metais?</label>
                </dt>

                <dd>
                    <select name="p1" id="p1" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r1 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r1 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>
                    </select>               
                </dd>
                <br/>
                <dt>                         
                    <label>Tem ou teve fragmentos metálicos no olhos?</label>
                </dt>                    
                <dd>                       
                    <select name="p2" id="p2" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r2 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r2 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>

                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem ou teve projétil de arma de fogo no corpo (bala ou fragmentos metálicos de qualquer tipo?)? </label>
                </dt>
                <dd>
                    <select  name="p3" id="p3" class="size1" >
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r3 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r3 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>
                    </select>

                </dd>
                <br/>
                <dt>
                    <label>Tem marcapasso cardíaco, desribilador ou cardioverter?</label>
                </dt>
                <dd>                    
                    <select name="p4" id="p4" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r4 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r4 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem clipes de aneurisma no cérebro?</label>
                </dt>
                <dd>
                    <select name="p5"  id="p5" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r5 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r5 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem "PUMPS" ou neuroestimuladores implantados?</label>
                </dt>
                <dd>
                    <select name="p6"  id="p6" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r6 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r6 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Fez substituicao de valvulas cardiacas?</label>
                </dt>
                <dd>
                    <select name="p7"  id="p7" class="size1"> 
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r7 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r7 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem implantes no ouvido (coclear, estribo) ou aparelho auditivo?</label>
                </dt>
                <dd>
                    <select name="p8"  id="p8" class="size1"> 
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r8 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r8 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem algum componente artificial no corpo?</label>
                </dt>
                <dd>
                    <select name="p9"  id="p9" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r9 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r9 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br>                
                <input type="text"  name="txtp9" id="txtp9" class="texto04" value="<?echo $txtp9?>">
                <br/>
                <br/>
                <dt>
                    <label>Tem protese, hastes, placas ou parafuso metalicos no corpo?</label>
                </dt>
                <dd>
                    <select name="p10"  id="p10" class="size1">  
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r10 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r10 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem protese dentaria, aparelho ortodontico ou peruca?</label>
                </dt>
                <dd>
                    <select name="p11"  id="p11" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r11 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r11 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem implante peniano?</label>
                </dt>
                <dd>
                    <select name="p12"  id="p12" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r12 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r12 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem D.I.U dispositivo contraceptivo intra-uterino?</label>
                </dt>
                <dd>
                    <select name="p13"  id="p13" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r13 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r13 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Consegue ficar deitado de costas e sentir-se confortavel num</label>
                    <label>espaco pequeno durante aproximadamente 1/2 hora?</label>
                </dt>
                <dd>
                    <select name="p14"  id="p14" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r14 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r14 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Ja fez tratamento quimioterapico ou radioterapico?</label>
                </dt>
                <dd>
                    <select name="p15"  id="p15" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r15 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r15 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem problema de insuficiencia renal?</label>
                </dt>
                <dd>
                    <select name="p16"  id="p16" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r16 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r16 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Existe alguma possibilidade de voce estar gravida?</label>
                </dt>
                <dd>
                    <select name="p17"  id="p17" class="size1">
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r17 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r17 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Esta amamentando?</label>
                </dt>
                <dd>
                    <select name="p18"  id="p18" class="size1">  
                        <option value="">SELECIONE</option>
                        <option value="SIM" <?
                        if ($r18 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r18 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                </dd>
                <br/>
                <dt>
                    <label>Tem alergia?</label>
                </dt>
                <dd>
                    <select name="p19"  id="p19" class="size1">  
                        <option value="" disabled selected>SELECIONE</option>
                        <option value="SIM" <?
                        if ($r19 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r19 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                    <label>A que?</label>
                    <input type="text"  name="txtp19" id="txtp19" class="texto04" value="<?echo $txtp19?>">
                </dd>
                <br/>
                <dt>
                    <label>Ja realizou cirurgias?</label>
                </dt>
                <dd>
                    <select name="p20"  id="p20" class="size1">  
                        <option value="" disabled selected>SELECIONE</option>
                        <option value="SIM" <?
                        if ($r20 == "SIM"):echo 'selected';
                        endif;
                        ?>>SIM</option> 
                        <option value="NAO" <?
                        if ($r20 == "NAO"):echo 'selected';
                        endif;
                        ?>>NÃO</option>                                   
                    </select>
                    <label> Quais?</label>
                    <input type="text"  name="txtp20" id="txtp20" class="texto04" value="<?echo $txtp20?>">
                </dd>
                <br/>
                <dt><label>OBS</label></dt>
                <dd>
                    <input type="text"  name="obs" id="obs" class="texto03" STYLE=" width: 18cm; height: 1.5cm;  padding: 0.15cm; " value="<?echo $obs?>">
                </dd>
                </dl>    
                <hr/>
                <button type="submit" name="btnEnviar">Enviar</button>
                <button type="reset" name="btnLimpar">Limpar</button>
                <button type="button" id="btnVoltar" name="btnVoltar">Voltar</button>
            </form>

        </div>
    </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">
    $('#btnVoltar').click(function () {
        $(location).attr('href', '<?= base_url(); ?>ponto/cargo');
    });

    $(function () {
        $("#accordion").accordion();
    });

    $(document).ready(function () {
        jQuery('#form_ficha_xml').validate({
            rules: {
                p1: {
                    required: true
                },
                p2: {
                    required: true
                },
                p3: {
                    required: true
                },
                p4: {
                    required: true
                },
                p5: {
                    required: true
                },
                p6: {
                    required: true
                },
                p7: {
                    required: true
                },
                p8: {
                    required: true
                },
                p9: {
                    required: true
                },
                p10: {
                    required: true
                },
                p11: {
                    required: true
                },
                p12: {
                    required: true
                },
                p13: {
                    required: true
                },
                p14: {
                    required: true
                },
                p15: {
                    required: true
                },
                p16: {
                    required: true
                },
                p17: {
                    required: true
                },
                p18: {
                    required: true
                },
                txtpeso: {
                    required: true
                }

            },
            messages: {
                p1: {
                    required: "*"
                },
                p2: {
                    required: "*"
                },
                p3: {
                    required: "*"
                },
                p4: {
                    required: "*"
                },
                p5: {
                    required: "*"
                },
                p6: {
                    required: "*"
                },
                p7: {
                    required: "*"
                },
                p8: {
                    required: "*"
                },
                p9: {
                    required: "*"
                },
                p10: {
                    required: "*"
                },
                p11: {
                    required: "*"
                },
                p12: {
                    required: "*"
                },
                p13: {
                    required: "*"
                },
                p14: {
                    required: "*"
                },
                p15: {
                    required: "*"
                },
                p16: {
                    required: "*"
                },
                p17: {
                    required: "*"
                },
                p18: {
                    required: "*"
                },
                txtpeso: {
                    required: "*"
                }

            }
        });
    });


</script>