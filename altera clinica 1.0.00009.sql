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

