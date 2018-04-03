<head>
    <link href="<?= base_url() ?>css/reset.css" rel="stylesheet" type="text/css" />

<!--<link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />-->
<!--<link href="<?= base_url() ?>css/batepapo.css" rel="stylesheet" type="text/css" />-->

    <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />

    <style>
        body{
            /*width: 750pt;*/
        }
        .content.ficha_ceatox fieldset{
            width: 95%;
            margin: 10pt;
        }
        /*        #conteudo{
                    overflow-x: auto;
                    overflow-y: auto;
                }*/
    </style>
</head>
<body>
    <div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
        <form name="form_paciente" id="form_paciente" action="<?= base_url() ?>cadastros/pacientes/gravar" method="post">
            <!--<div id="conteudo">-->
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente['0']->nome; ?>" readonly/>
                </div>
                <div>
                    <label>Sexo</label>
                    <select name="sexo" id="txtSexo" class="size2">
                        <option value="M" <?
                        if ($paciente['0']->sexo == "M"):echo 'selected';
                        endif;
                        ?>>Masculino</option>
                        <option value="F" <?
                        if ($paciente['0']->sexo == "F"):echo 'selected';
                        endif;
                        ?>>Feminino</option>
                        <option value="O" <?
                        if ($paciente['0']->sexo == "O"):echo 'selected';
                        endif;
                        ?>>Outro</option>
                    </select>
                </div>

                <div>
                    <label>Nascimento</label>


                    <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" value="<?php echo substr($paciente['0']->nascimento, 8, 2) . '/' . substr($paciente['0']->nascimento, 5, 2) . '/' . substr($paciente['0']->nascimento, 0, 4); ?>" onblur="retornaIdade()" readonly/>
                </div>


                <div>
                    <label>Nome da M&atilde;e</label>


                    <input type="text" name="nome_mae" id="txtNomeMae" class="texto08" value="<?= $paciente['0']->nome_mae; ?>" readonly/>
                </div>
                <div>
                    <label>Nome do Pai</label>


                    <input type="text"  name="nome_pai" id="txtNomePai" class="texto08" value="<?= $paciente['0']->nome_pai; ?>" readonly/>
                </div>
                <div>
                    <label>CNS</label>


                    <input type="text" id="txtCns" name="cns"  class="texto04" value="<?= $paciente['0']->cns; ?>" readonly/>
                </div>

            </fieldset>
            <fieldset>
                <legend>Documentos</legend>
                <div>
                    <label>CPF</label>


                    <input type="text" name="cpf" id ="txtCpf" maxlength="11" alt="cpf" class="texto02" value="<?= $paciente['0']->cpf; ?>" readonly/>
                </div>
                <div>
                    <label>RG</label>


                    <input type="text" name="rg"  id="txtDocumento" class="texto04" maxlength="20" value="<?= $paciente['0']->rg; ?>" readonly/>
                </div>
                <div>
                    <label>UF Expedidor</label>


                    <input type="text" id="txtuf_rg" class="texto02" name="uf_rg" value="<?= $paciente['0']->uf_rg; ?>" readonly/>
                </div>
                <div>
                    <div>
                        <label>Data Emiss&atilde;o</label>


                        <input type="text" name="data_emissao" id="txtDataEmissao" class="texto02" alt="date" value="<?php echo substr($paciente['0']->data_emissao, 8, 2) . '/' . substr($paciente['0']->data_emissao, 5, 2) . '/' . substr($paciente['0']->data_emissao, 0, 4); ?>" readonly/>
                    </div>

                    <div>

                        <label>T. Eleitor</label>


                        <input type="text"   name="titulo_eleitor" id="txtTituloEleitor" class="texto02" value="<?= $paciente['0']->titulo_eleitor; ?>" readonly/>
                    </div>




            </fieldset>
            <fieldset>
                <legend>Domicilio</legend>

                <div>
                    <label>Endere&ccedil;o</label>


                    <input type="text" id="txtendereco" class="texto10" name="endereco" value="<?= $paciente['0']->logradouro; ?>" readonly/>
                </div>
                <div>
                    <label>N&uacute;mero</label>


                    <input type="text" id="txtNumero" class="texto02" name="numero" value="<?= $paciente['0']->numero; ?>" readonly/>
                </div>
                <div>
                    <label>Bairro</label>


                    <input type="text" id="txtBairro" class="texto03" name="bairro" value="<?= $paciente['0']->bairro; ?>" readonly/>
                </div>
                <div>
                    <label>Complemento</label>


                    <input type="text" id="txtComplemento" class="texto06" name="complemento" value="<?= $paciente['0']->complemento; ?>" readonly/>
                </div>

                <div>
                    <label>CEP</label>


                    <input type="text" id="txtCep" class="texto02" name="cep" alt="cep" value="<?= $paciente['0']->cep; ?>" readonly/>
                </div>


                <div>
                    <label>Telefone</label>


                    <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone" value="<?= $paciente['0']->telefone; ?>" readonly/>
                </div>
                <div>
                    <label>Celular</label>


                    <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone" value="<?= $paciente['0']->celular; ?>" readonly/>
                </div>
                <div>
                    <label>Observa&ccedil;&otilde;es</label>


                    <input type  ="text" name="observacao" id="txtObservacao" class="texto10"  value ="<?= $paciente['0']->observacao; ?>" readonly/>

                    <!--</div>-->
            </fieldset>
    </div>
</form>

</div> <!-- Final da DIV content -->
</body>
<!--<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>-->
<script type="text/javascript">

</script>