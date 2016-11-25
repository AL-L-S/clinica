<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Consultar pacientes BE relatorio circunstanciado</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/pacientes/impressaocircunstanciado">
                <input type="text" name="txtbe" />
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