
<div class="content ficha_ceatox">
    <div id="accordion">
        <h3 class="singular"><a href="#">UNIFICAR</a></h3>
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>seguranca/operador/gravarunificar" method="post">
        <fieldset>
            <legend>Dados do Operador</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $operador['0']->nome; ?>" readonly/>
                <input type="hidden" id="paciente_id" name="operador_id"  class="texto02" value="<?= $operador_id; ?>"/>
            </div>
            <div>
                <label>Usuário</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto02" value="<?= $operador['0']->usuario; ?>" readonly/>
            </div>
            <div>
                <label>Perfil</label>
                <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?=$operador[0]->perfil ?>" readonly/>
            </div>
            
<!--            <div>
                <label>Nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($operador['0']->nascimento, 8, 2) . '/' . substr($operador['0']->nascimento, 5, 2) . '/' . substr($operador['0']->nascimento, 0, 4); ?>" readonly/>
            </div>-->
        </fieldset>
        <fieldset>
            <legend>Operador que sera unificado e excluido</legend>
            <div>
                <label>Nome</label>                      
                <input type="text" id="operador" name="operador"  class="texto09" value=""/>
            </div>
            <div>
                <label>Usuário</label>
                <input type="text" name="usuario" id="usuario" class="texto02" value="" readonly/>
            </div>
            <div>
                <label>Perfil</label>
                <input type="text" name="perfil" id="perfil" class="texto08" value="" readonly/>
                <input type="hidden" name="operadorid" id="operadorid" class="texto08" value="" readonly/>
            </div>
        </fieldset>
        <button type="submit" name="btnEnviar">enviar</button>
    </form>
</div>
</div>


<script type="text/javascript">
    $(function() {
        
            
        $(function() {
            $( "#operador" ).autocomplete({
                source: "<?= base_url() ?>index.php?c=autocomplete&m=operadorunificar",
                minLength: 3,
                focus: function( event, ui ) {
                    $( "#operador" ).val( ui.item.label );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#operador" ).val( ui.item.value );
                    $( "#usuario" ).val( ui.item.usuario );
                    $( "#perfil" ).val( ui.item.perfil );
                    $( "#operadorid" ).val( ui.item.id );
                    return false;
                }
            });
        });
        
        $( ".competencia" ).accordion({ autoHeight: false });
        $( ".accordion" ).accordion({ autoHeight: false, active: false });
        $( ".lotacao" ).accordion({

            active: true,
            autoheight: false,
            clearStyle: true

        });


    });
</script>
