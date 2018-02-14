-- Dia 06/02/2018
ALTER TABLE ponto.tb_estoque_armazem ADD COLUMN visivel_solicitacao boolean DEFAULT true;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_recebimento_convenio boolean DEFAULT false;

-- Dia 07/02/2018
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN credor_devedor_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN conta_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN classe character varying(60);
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN tipo_id character varying(60);

CREATE TABLE ponto.tb_fornecedor_material
(
  fornecedor_material_id serial NOT NULL,
  razao_social character varying(200),
  nome character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo_logradouro_id integer,
  caixa boolean DEFAULT false,
  cnpjxml character varying(20),
  razao_socialxml character varying(200),
  cpfxml character varying(11),
  registroans character varying(11),
  dinheiro boolean DEFAULT false,
  producaomedicadinheiro boolean DEFAULT false,
  cnes character varying(20),
  tipo_xml_id integer,
  valor_taxa numeric(10,2),
  CONSTRAINT tb_fornecedor_material_pkey PRIMARY KEY (fornecedor_material_id)
);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN fornecedor_id integer;

CREATE TABLE ponto.tb_solicitacao_cirurgia_material
(
  solicitacao_cirurgia_material_id serial,
  solicitacao_cirurgia_id integer,
  procedimento_tuss_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  horario_especial boolean DEFAULT false,
  valor numeric(10,2),
  quantidade integer,
  desconto numeric(10,2),
  agenda_exames_id integer,
  equipe_particular boolean DEFAULT false,
  via character varying(100),
  CONSTRAINT tb_solicitacao_cirurgia_material_pkey PRIMARY KEY (solicitacao_cirurgia_material_id)
);