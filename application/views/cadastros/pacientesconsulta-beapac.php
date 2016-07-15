<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Consultar pacientes BE - APAC</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>cadastros/pacientes/impressaoabeapac">
                <input type="hidden" id="codigo" class="texto04" name="txtcodigo" />
                <input type="hidden" id="descricao" class="texto09" name="txtdescricao" /><br>
                <input type="text" id="labeldescricao" class="texto10" name="txtlabeldescricao"  /><br>
                <input type="text" name="txtbe" />
                <button type="submit" >Pesquisar</button>
            </form>
            
        </div>
    </div>


</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?php base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">
        $(function() {
        $( "#labeldescricao" ).autocomplete({
            source: "<?= base_url() ?>index?c=autocomplete&m=procedimento",
            minLength: 2,
            focus: function( event, ui ) {
                $( "#labeldescricao" ).val( ui.item.label );
                return false;
            },
            select: function( event, ui ) {
                $( "#labeldescricao" ).val( ui.item.value );
                $( "#codigo" ).val( ui.item.id );
                $( "#descricao" ).val( ui.item.descricao );
                return false;
            }
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });

</script>