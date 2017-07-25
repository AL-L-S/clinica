<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar Relatorio Sintético</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ambulatorio/guia/gerarelatoriogeralsintetico">
                <dl>
                    
                    <label>Ano</label>
                    </dt>
                    <dd>
                        <input type="text" name="ano" id="ano" alt="2099" required=""/>
                    </dd>
                    
                    
                    
                </dl>
                <button type="submit" >Pesquisar</button>
            </form>

        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
   


    $(function() {
        $("#accordion").accordion();
    });

</script>