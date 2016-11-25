<div class="content"> <!-- Inicio da DIV content -->
    <div id="accordion">
        <h3><a href="#">Consultar cirurgias</a></h3>
        <div>
            <form method="post" action="<?= base_url() ?>ccih/ccih/imprimircirurgia">
                <label>Classifica&ccedil;&atilde;o</label>
                <select name="txtclassificacao">
                    <option value=" ">TODAS</option>
                    <option value="LIMPA">LIMPA</option>
                    <option value="CONTAMINADA">CONTAMINADA</option>
                    <option value="POTENCIALMENTE CONTAMINADA">POTENCIALMENTE CONTAMINADA</option>
                    <option value="INFECTADA">INFECTADA</option>
                </select>
                <br>
                <label>Competencia</label>
                <input type="text" alt="compet" name="txtcompetencia" />
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