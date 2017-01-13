<div class="content"> <!-- Inicio da DIV content -->
        <div id="accordion">
            <h3><a href="#">Lista das pontua&ccedil;&otilde;es</a></h3>
        <div>
        <table>
            <thead>
                <tr>
                    <th class="tabela_header">Compet&ecirc;ncia</th>
                    <th class="tabela_header">Médicos</th>
                    <th class="tabela_header" width="50px;"></th>
                </tr>
            </thead>
            <tbody>
                     <?
                      // variavel para testar se a competencia aberta possui cadastro
                     $capc = true;
                    if (count($lista) > 0) :
                        $i=0;
                        $capc = true;
                        foreach ($lista as $item) :

                             if ($item->competencia == $competencia )
                            { $capc = false; }

                            if ($i%2 == 0) : $classe = "tabela_content01";
                            else: $classe = "tabela_content02";
                            endif;
                ?>
                <tr>
                    <td class="<?=$classe;?>"><?= substr($item->competencia, 0, 4) . "/" . substr($item->competencia, 4);?></td>
                    <td class="<?=$classe;?>"><?= $item->total_pontuacao;?></td>
                    <td class="<?=$classe;?>">
                        <? if ($competencia == $item->competencia) :?>
                       
                        <a onclick="javascript: return confirm('Deseja realmente excluir os dados da compet&ecirc;ncia <?= substr($item->competencia, 0, 4) . "/" . substr($item->competencia, 4); ?>');"
                            href="<?=base_url()?>giah/pontuacaomedica/excluir/<?=$item->competencia;?>">
                            <img border="0" title="Excluir" alt="Excluir" src="<?=  base_url()?>img/form/page_white_delete.png" />
                        </a>
                        
                        <? endif; ?>
                    </td>
                </tr>
                <?
                            $i++;
                        endforeach;
                    else : ?>
                <tr>
                    <td class="">Sem registros encontrados.</td>
                </tr>
                <? endif; ?>
            </tbody>
            <tfoot>
                <tr>
                     <th class="tabela_footer" colspan="3">Total de registros: <?=count($lista); ?></th>
                </tr>
            </tfoot>
        </table>
        <?
                    if (isset ($naoimportados)) :?>
                       <h3><a href="#">CRMs n&atilde;o importados </a></h3>
        <div id="accordion">
               <? echo 'CRMs n&atilde;o importados<br/>';
                foreach ($naoimportados as $crm) {
                    echo $crm . ";";
                }?>
                </div>
           <? endif;  ?>


        </div>
        <? if ($capc && $competencia != '000000') : ?>
            <h3><a href="#">Carregar pontua&ccedil;&atilde;o </a></h3>
        <div>

    <?= form_open_multipart(base_url() .'giah/pontuacaomedica/importar'); ?>
        <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br/>
        <input type="file" name="userfile" />
        <button type="submit" name="btnEnviar">Enviar</button>
    <?= form_close();?>
        <div style="width: 400px; margin: 0">
        <?
            if (isset ($erros)) :
                echo $erros;
            endif;
            if (isset ($naoimportados)) :
                echo 'CRMs n&atilde;o importados<br/>';
                foreach ($naoimportados as $crm) {
                    echo $crm . ";";
                }
            endif;
        ?>
    </div><br/>

    </div>
            <? endif; ?>
  </div>
</div> <!-- Final da DIV content -->
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });

    

</script>
