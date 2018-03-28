
<div class="content ficha_ceatox">
    <!--    <div class="bt_link_new">
            <a onclick="javascript:window.open('<?= base_url() ?>ambulatorio/guia/novo/<?= $paciente['0']->paciente_id ?>');">
                Nova guia
            </a>
        </div>-->
    <?
    $operador_id = $this->session->userdata('operador_id');
    $empresa = $this->session->userdata('empresa');
    $empresa_id = $this->session->userdata('empresa_id');
    $perfil_id = $this->session->userdata('perfil_id');
    $botao_faturar_guia = $this->session->userdata('botao_faturar_guia');
    $botao_faturar_proc = $this->session->userdata('botao_faturar_proc');
    $empresapermissoes = $this->guia->listarempresapermissoes($empresa_id);
    ?>
    <form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/gravarnovasolicitacaosadt/<?= $paciente['0']->paciente_id ?>" method="post">
        <fieldset>
            <legend>Dados da Solicitação</legend>

            <div>



                <div>
                    <label>Médico Solicitante</label>                      
                    <select  name="solicitante" id="solicitante" class="size4"  required="">
                        <option value="">Selecione</option>
                        <? foreach ($medicos as $item) : ?>
                            <option value="<?= $item->operador_id; ?>"<?
                            if ($operador_id == $item->operador_id):echo 'selected';
                            endif;
                            ?>><?= $item->nome; ?></option>
                                <? endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Convênio</label>                      
                    <select  name="convenio" id="convenio" class="size4"  required="">
                        <option value="">Selecione</option>
                        <? foreach ($convenio as $item) : ?>
                            <option value="<?= $item->convenio_id; ?>"><?= $item->nome; ?></option>
                                <? endforeach; ?>
                    </select>
                </div>




            </div>
            <br>


        </fieldset>
        <fieldset>
            <div>
                <button type="submit" name="btnEnviar" id="submitButton">Enviar</button>
            </div> 
        </fieldset>
    </form> 


    <script type="text/javascript">



        $(function () {
            $(".competencia").accordion({autoHeight: false});
            $(".accordion").accordion({autoHeight: false, active: false});
            $(".lotacao").accordion({
                active: true,
                autoheight: false,
                clearStyle: true

            });


        });
    </script>
