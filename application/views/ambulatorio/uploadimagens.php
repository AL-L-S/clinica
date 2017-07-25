<body bgcolor="#C0C0C0">
    <meta charset="utf-8"/>
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular"></h3>
        <div>
            <form name="form_faturar" id="form_faturar" action="<?= base_url() ?>ambulatorio/laudo/redirecionauploadcliente" method="post">
                <fieldset>
                    <!---->

                    <dl class="dl_desconto_lista">
                        <dt>
                            <label>Caminho da pasta</label>
                        </dt>
                        <dd>
                            <?$valor = "C:\\"?>
                            <input type="text" name="caminho" id="caminho" value="<?=$valor?>" />
                        </dd>
                        <div class="arquivo_nome">
                            <div class="conteudo">
                                <dt>
                                    <label>Nome do arquivo (com extensão)</label>
                                </dt>
                                <dd>
                                    <input type="text" name="arquivo" id="arquivo" placeholder="arquivo.jpeg"/>
                                </dd>
                            </div>
                        </div>
                        <dt>
                            <label for="todos">Enviar todos os arquivos da pasta?</label>
                        </dt>
                        <dd>
                            <input type="checkbox" name="todos" id="todos" onclick="checado(this);" />
                        </dd>

                    </dl>    

                    <hr/>
                    <button type="submit" name="btnEnviar" >Enviar</button>
            </form>
            </fieldset>
        </div>
    </div> <!-- Final da DIV content -->
</body>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    var x = true;
//    var todos = document.getElementById("todos");
    
    function checado(todos){
        if (todos.checked) {
            $(".arquivo_nome .conteudo").remove();
            x = false;
        }
        else{
            if(x == false){
                var html = '<div class="conteudo"><dt><label>Nome do arquivo</label></dt><dd><input type="text" name="arquivo" id="arquivo"/></dd></div>';
                $(".arquivo_nome").append(html);
            }
            x = true;
        }
    }
</script>