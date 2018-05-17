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