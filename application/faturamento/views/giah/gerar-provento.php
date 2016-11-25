<div class="content"> <!-- Inicio da DIV content -->
    <label>Gerar Proventos</label><br/>
    <fieldset>
        <legend>Informe a compet&ecirc;ncia</legend>
        <label>Compet&ecirc;ncia</label><br>
        <form name="form_competencia" method="post" action="<?= base_url()?>/giah/provento/carregarcompetencia">
            <input type="text" name="txtCompetencia" alt="compet" />
            <hr/>
            <button type="submit" name="btnEnviar" >Enviar</button>
            <button type="reset" name="btnLimpar" >Limpar</button>
        </form>
    </fieldset>
           
</div> <!-- Final da DIV content -->
