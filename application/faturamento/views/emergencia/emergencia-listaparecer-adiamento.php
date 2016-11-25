<div class="content ficha_ceatox">

    <div class="clear"></div>
    <h3 class="h3_title">Mundaça de prioridade de parecer</h3>

    <form name="ficha_form" id="ficha_form" action="<?=base_url() ?>emergencia/emergencia/prioridadeparecer/" method="POST">
       
                        <fieldset>
                    <dd >
                        <input type="hidden" id="txtsolicitacao" name="txtsolicitacao" value="<?= $solicitacao?>" />
                    </dd>
                                    <div>

                                            <label>Descrição</label>
                                            <input type="text" name="conduta_desc" id="conduta_desc" class="size10" />
                                            <select name="conduta_adiamento" id="conduta_select2" class="size2">
                                                <option value="">Selecione</option>
                                                <option value="0 - imediato">Imediato</option>
                                                <option value="1 - 5 minutos">1 - Vermelho - 5 minutos</option>
                                                <option value="2 - 15 minutos">2 - Laranja - 15 minutos</option>
                                                <option value="3 - 30 minutos">3 - Amarelo - 30 minutos</option>
                                                <option value="4 - 50 minutos">4 - Verde - 50 minutos</option>
                                                <option value="5 - 90 minutos">5 - Azul - 90 minutos</option>
                                                <option value="6 - Até 6 horas">6 - Até 6 horas</option>
                                                <option value="7 - Até 12 horas">7 - Até 12 horas</option>
                                                <option value="8 - Até 24 horas">8 - Até 24 horas</option>
                                                <option value="9 - Até 48 horas">9 - Até 48 horas</option>
                                                <option value="10 - Até 72 horas">10 - Até 72 horas</option>
                                                <option value="11 - Até 2 semanas">11 - Até 2 semanas</option>
                                                <option value="12 - Até 4 semanas">12 - Até 4 semanas</option>
                                                <option value="13 - Mais 4 semanas">13 - Mais 4 semanas</option>
                                            </select>
                                        </div>
                                        </fieldset>
                                                                                    <hr />
                                                                                    <button type="submit" name="btnEnviar">Enviar</button>
                                                                                    <button type="reset" name="btnLimpar">Limpar</button>
                                                                                </form>
                                                                            </div>
