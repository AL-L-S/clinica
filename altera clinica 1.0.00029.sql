-- Dia 13/09/2018

CREATE TABLE ponto.tb_laudo_apendicite
(
  simnao text,
  perguntas text,
  
  guia_id integer,
  paciente_id integer,
  laudo_apendicite_id serial not null  
);

-- Dia 14/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN integracaosollis boolean DEFAULT false;

CREATE TABLE ponto.tb_receituario_sollis
(
  receituario_sollis_id serial NOT NULL,
  cid_id integer,
  frequencia integer,
  frequnit text,
  qtdmed integer,
  medid integer,
  periodo integer,
  perunit text,
  observacao text,
  medico_parecer1 integer,
  laudo_id integer,
  tipo character varying(50),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_receituario_sollis_pkey PRIMARY KEY (receituario_sollis_id)
  );

-- Dia 15/09/2018

ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN paciente_id integer;

CREATE TABLE ponto.tb_prescricao
(
  prescricao_id serial NOT NULL,
  prescricao text,
  medico_parecer1 integer,
  laudo_id integer,  
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  paciente_id integer,
  CONSTRAINT tb_prescricao_pkey PRIMARY KEY (prescricao_id)
  );

-- Dia 17/09/2018

ALTER TABLE ponto.tb_prescricao ADD COLUMN ativo boolean NOT NULL DEFAULT true;

ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN prescricao_id integer;
ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN ativo boolean NOT NULL DEFAULT true;


-- Dia 18/09/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_integracao_lab text;

-- Dia 20/09/2018
ALTER TABLE ponto.tb_operador ADD COLUMN guiche integer;
