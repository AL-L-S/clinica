ALTER TABLE ponto.tb_internacao ADD COLUMN internacao_statusinternacao_id integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN operador_status integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN data_status timestamp without time zone;


CREATE TABLE ponto.tb_internacao_procedimento_externo
(
  internacao_procedimento_externo_id serial NOT NULL,
  internacao_id integer,
  procedimento text,
  duracao text,
  observacao text,
  data date,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_procedimento_externo_pkey PRIMARY KEY (internacao_procedimento_externo_id)
);


-- 06/11/2018
ALTER TABLE ponto.tb_farmacia_produto ADD COLUMN procedimento_tuss_id integer;
-- Dia 05/11/2018

ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN detalhamento_nr text;

