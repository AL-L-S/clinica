<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Envio De Emails</a></h3>

        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriomedicoagendaexamefaltouemail">
                <dl>
                    
                    <dt>
                    <label>Data inicio</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_inicio" id="txtdata_inicio" alt="date"/>
                    </dd>
                    <dt>
                    <label>Data fim</label>
                    </dt>
                    <dd>
                        <input type="text" name="txtdata_fim" id="txtdata_fim" alt="date"/>
                    </dd>
                    <dt>
                    <label>Situação</label>
                    </dt>
                    <dd>
                        <select name="situacao" id="empresa" class="size2">
                            <option value="">TODOS</option>
                            <option value="FALTOU">FALTOU</option>
                            <option value="COMPARECEU">COMPARECEU</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Idade maior que:</label>
                    </dt>
                    <dd>
                        <input type="number" name="idade_maior" min=1 id="idade_maior" alt=""/>
                    </dd>
                    <dt>
                        <label>Idade menor que:</label>
                    </dt>
                    <dd>
                        <input type="number" name="idade_menor" min=1 id="idade_menor" alt=""/>
                    </dd>
                    <dt>
                        <label>Ra&ccedil;a / Cor</label>
                    </dt>
                    <dd>
                        <select name="raca_cor" id="raca_cor" class="size2" >>

                            <option value='' >TODOS</option>
                            <option value=1>Branca</option>
                            <option value=2>Amarela</option>
                            <option value=3 >Preta</option>
                            <option value=4 >Parda</option>
                            <option value=5 >Ind&iacute;gena</option>
                        </select>
                    </dd>
                    <dt>
                        <label>Estado Civíl</label>
                    </dt>
                    <dd>
                        <select name="estado_civil_id" id="txtEstadoCivil" class="size2"  >
                            <option value=''>TODOS</option>
                            <option value=1>Solteiro</option>
                            <option value=2>Casado</option>
                            <option value=3>Divorciado</option>
                            <option value=4>Viuvo</option>
                            <option value=5>Outros</option>
                        </select>
                    </dd>
                    
                    <dt>
                        <label>Gênero</label>
                    </dt>
                    <dd>
                        <select name="sexo" id="sexo" class="size2" >
                            <option value='' >TODOS</option>    
                            <option value='M' >Masculino</option>
                            <option value='F'>Feminino</option>
                         
                        </select>
                        </dd>
                    <dt>
                        <label>Especialidade</label>
                    </dt>
                    <dd>
                        <select name="grupo" id="grupo" class="size2" >
                            <option value='' >TODOS</option>
                            <!-- <option value='1' >SEM RM/TOMOGRAFIA</option> -->
                            <? foreach ($grupos as $value) : ?>
                                <option value="<?= $value->nome; ?>" ><?php echo $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>
                    </dd>
                    <dt>
                    <label>Mala Direta</label>
                    </dt>
                    <dd>
                        <select name="mala" id="empresa" class="size2">
                            <option value="NAO">NÃO</option>
                            <option value="SIM">SIM</option>
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
                            <option value="">TODOS</option>
                        </select>
                    </dd>
                    <dt>
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
    $(function() {
        $("#txtdata_inicio").datepicker({
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
        $("#txtdata_fim").datepicker({
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