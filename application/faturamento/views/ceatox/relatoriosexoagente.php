<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Gerar relatorio vitima humana sexo / agente toxico</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ceatox/ceatox/impressaosexoagente">
                <label>Data inicio</label>
                <input type="text" name="txtdata_inicio" alt="date"/>
                <label>Data fim</label>
                <input type="text" name="txtdata_fim" alt="date"/>
                <button type="submit" >Pesquisar</button>
            </form>
            
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

</script>