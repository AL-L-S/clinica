-- Salvar ao mudar o percentual médico

CREATE TABLE ponto.tb_procedimento_percentual_medico_convenio_antigo
(
  procedimento_percentual_medico_convenio_antigo_id serial,
  procedimento_percentual_medico_convenio_id integer,
  procedimento_percentual_medico_id integer,
  medico integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  CONSTRAINT tb_procedimento_percentual_medico_convenio_antigo_pkey PRIMARY KEY (procedimento_percentual_medico_convenio_antigo_id)
);

-- Valor Indicação Cadastro

UPDATE ponto.tb_agenda_exames
   SET 
       valor_promotor= mc.valor, percentual_promotor= mc.percentual


       
FROM ponto.tb_procedimento_percentual_promotor m , ponto.tb_procedimento_percentual_promotor_convenio mc, ponto.tb_paciente p

       WHERE ponto.tb_agenda_exames.procedimento_tuss_id = m.procedimento_tuss_id 

       AND m.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id

       AND p.paciente_id = ponto.tb_agenda_exames.paciente_id
       
       AND mc.promotor = p.indicacao  
 
       AND ponto.tb_agenda_exames.paciente_id is not null

       AND ponto.tb_agenda_exames.valor_promotor is null

       AND ponto.tb_agenda_exames.procedimento_tuss_id is not null

       AND m.ativo = 'true' 
       
       AND mc.ativo = 'true';
