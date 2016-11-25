<div id="servidor" class="servidor_div">
    <h3 class="singular servidor_detalhe"><a href="#">Servidor</a></h3>
    <div class=" servidor_detalhe">
        <dl class="dl_servidor_desc_1">
            <dt>Matr&iacute;cula</dt>
            <dd><?=$servidor->_matricula; ?></dd>
            <dt>Nome</dt>
            <dd><?=$servidor->_nome; ?></dd>
        </dl>
        <dl class="dl_servidor_desc_2">
            <dt>CPF</dt>
            <?$cpfservidor=$servidor->_cpf?>
            <dd><?echo $cpfmodificado = substr($cpfservidor,0,3).".".substr($cpfservidor,3,3).".".substr($cpfservidor,6,3)."-".substr($cpfservidor,9,2)  ?></dd>
            <dt>Lota&ccedil;&atilde;o:</dt>
            <dd><?=$servidor->_lotacao; ?></dd>
        </dl>
    </div>
</div>
