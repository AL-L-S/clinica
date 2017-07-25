<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Consultar pacientes PRONTUÁRIO</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/pacientes/faturamentohospub">
                <input type="text" name="txtprontuario" />
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