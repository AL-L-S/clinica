<div class="content ficha_ceatox">
    <div>
        <form name="form_paciente" id="form_paciente">
            <fieldset>
                <legend>Dados do Paciente</legend>
                <div>
                    <label>Nome</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>
                <div>
                    <label>Nome da mãe</label>                      
                    <input type="text" id="txtNome" name="nome"  class="texto09" value="<?= $paciente[0]->paciente ?>" readonly/>
                </div>

                <div>
                    <label>Leito</label>
                    <input type="text"  name="leito" id="leito" class="texto09" value="<?= $paciente[0]->leito; ?>" />
                </div>


                <div>
                    <label>data da Internacao</label>                      
                    <input type="text" id="data_internacao" name="data_internacao"  class="texto09" value="<?= $paciente[0]->data_internacao; ?>" readonly/>
                </div>

                <div>
                    <label>data de Nascimento</label>                      
                    <input type="text" id="data_nascimento" name="data_nascimento"  class="texto09" value="<?= $paciente[0]->nascimento; ?>" readonly/>
                </div>

                <div>
                    <label>Sexo</label>
                    <input type="text" id="sexo" name="sexo"  class="texto09" value="<?
                    if ($paciente[0]->sexo == "M"):echo 'Masculino';
                    endif;
                    if ($paciente[0]->sexo == "F"):echo 'Feminino';
                    endif;
                    if ($paciente[0]->sexo == "O"):echo 'Outro';
                    endif;
                    ?>" readonly/>
                </div>    
            </fieldset>
    </div>
    <fieldset>
        <legend>A&ccedil;&otilde;es</legend>
        <div>
            <table>
                <td width="250px;"><div class="bt_link_new"><a href="">Alterar Leito</a></div></td>
                <td width="250px;"><div class="bt_link"><a href="<?= base_url() ?>emergencia/filaacolhimento/gravarsolicitacao/">Dar alta</a></div></td>


            </table>            
        </div>
    </fieldset>
    <div class="clear"></div>
</div>
<link rel="stylesheet" href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-verificaCPF.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/funcoes.js"></script>
