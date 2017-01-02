        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
            <?php
    $this->load->library('utilitario');
    Utilitario::pmf_mensagem($this->session->flashdata('message'));
    ?>

<script>
    
<?php 
    if ($this->session->flashdata('message') != ''): ?>
        alert("<? echo $this->session->flashdata('message') ?>");
<? endif; ?>
    
</script>
<body bgcolor="#C0C0C0">
    <div class="content"> <!-- Inicio da DIV content -->
        <h3 class="singular">Alterar Nome Imegem</h3>
        <div>
            <?
//            var_dump(utf8_decode($imagem_id));
//            die;
            
            ?>
            <form name="form_horariostipo" id="form_horariostipo" action="<?= base_url() ?>ambulatorio/laudo/renomearimagem/<?= $exame_id; ?>" method="post">
                <fieldset>
                    <div>
                        <input type="hidden" name="imagem_id" id="imagem_id" value="<?=$imagem_id; ?> " readonly/>
                    </div>
                    <?if (count($contador) == 1) {?>
                    <div>
                        <input type="text" name="imagem_nome" id="imagem_nome" value="<?=$contador[0]->nome; ?> " readonly/>
                    </div>
                    <?}else{?>
                                        <div>
                        <input type="text" name="imagem_nome" id="imagem_nome" readonly/>
                    </div>
                    <?}?>
                    <div>
                        <img  width="500px" height="400px" src="<?= base_url() . "upload/" . $exame_id . "/" . $imagem_id ?>"></a>
                    </div>
                    <div>
                        <select name="sequencia" id="sequencia" class="size2">
                            <option value='1' >Foto 1</option>
                            <option value='2' >Foto 2</option>
                            <option value='3' >Foto 3</option>
                            <option value='4' >Foto 4</option>
                            <option value='5' >Foto 5</option>
                            <option value='6' >Foto 6</option>
                            <option value='7' >Foto 7</option>
                            <option value='8' >Foto 8</option>
                            <option value='9' >Foto 9</option>
                            <option value='10' >Foto 10</option>
                            <option value='11' >Limpar</option>
                        </select>

                        <select name="nome" id="nome" class="size1" >
                            <option value='' >Selecione</option>
                            <? foreach ($listaendoscopia as $value) : ?>
                            <option value="<?= $value->nome; ?>" ><?= $value->nome; ?></option>
                            <? endforeach; ?>

                        </select>

                        <input type="text" name="complemento" id="complemento"/>
                        
                    </div>
                </fieldset>
                <hr/>
                <button type="submit" name="btnEnviar">Salvar</button>
            </form>
        </div>
    </div> <!-- Final da DIV content -->
</body>
