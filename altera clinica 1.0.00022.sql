ALTER TABLE ponto.tb_ambulatorio_receituario ALTER COLUMN texto TYPE text;

ALTER TABLE ponto.tb_paciente ADD COLUMN cpf_responsavel character varying(11);

-- 16/05/2018

ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_toten text;

ALTER TABLE ponto.tb_exame_sala ADD COLUMN toten_sala_id integer;


CREATE TABLE ponto.tb_toten_setor
(
  toten_setor_id serial NOT NULL,
  nome text,
  sigla character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo character varying(20),
  empresa_id integer,
  toten_webService_id integer,
  CONSTRAINT tb_toten_setor_pkey PRIMARY KEY (toten_setor_id)
);


CREATE TABLE ponto.tb_toten_senha
(
  toten_senha_id serial NOT NULL,
  id text,
  senha character varying(200),
  operador integer,
  data text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_toten_senha_pkey PRIMARY KEY (toten_senha_id)
);

ALTER TABLE ponto.tb_toten_senha ADD COLUMN atendida boolean DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN id_chamada text;

-- Dia 26/04/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN dia_semana_preferencia text;
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN turno_prefencia text;

-- Dia 12/05/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_seg_sex_inicio text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_seg_sex_fim text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_sab_inicio text;
ALTER TABLE ponto.tb_empresa ADD COLUMN horario_sab_fim text;

UPDATE ponto.tb_empresa
   SET horario_seg_sex_inicio='08:00', horario_seg_sex_fim='18:00', horario_sab_inicio='08:00', horario_sab_fim='12:00'
 WHERE (horario_seg_sex_inicio IS NULL OR horario_seg_sex_inicio = '');


ALTER TABLE ponto.tb_internacao ALTER COLUMN motivo_saida TYPE integer USING motivo_saida::integer;


ALTER TABLE ponto.tb_toten_senha ADD COLUMN associada boolean DEFAULT false;

ALTER TABLE ponto.tb_paciente ADD COLUMN toten_senha_id integer;
ALTER TABLE ponto.tb_paciente ADD COLUMN toten_fila_id integer;
ALTER TABLE ponto.tb_paciente ADD COLUMN senha text;

ALTER TABLE ponto.tb_toten_senha ADD COLUMN data_associada timestamp without time zone;
ALTER TABLE ponto.tb_toten_senha ADD COLUMN operador_associada integer;

ALTER TABLE ponto.tb_paciente ADD COLUMN data_senha date;


ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN toten_senha_id integer;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN toten_fila_id integer;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN senha text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_senha date;