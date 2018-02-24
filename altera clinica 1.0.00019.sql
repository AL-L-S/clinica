-- Dia 16/02/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN repetir_horarios_agenda boolean DEFAULT false;

-- Dia 19/02/2018
CREATE TABLE ponto.tb_estoque_pedido
(
  estoque_pedido_id serial NOT NULL,
  descricao character varying(200),
  situacao character varying(30) DEFAULT 'PENDENTE'::character varying,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_estoque_pedido_pkey PRIMARY KEY (estoque_pedido_id )
);

CREATE TABLE ponto.tb_estoque_pedido_itens
(
  estoque_pedido_itens_id serial NOT NULL,
  estoque_pedido_id integer,
  produto_id integer,
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_estoque_pedido_itens_pkey PRIMARY KEY (estoque_pedido_itens_id)
);

-- Dia 20/02/2018
ALTER TABLE ponto.tb_estoque_pedido_itens ADD COLUMN observacao TEXT;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN conjuge boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente ADD COLUMN nome_conjuge text;
ALTER TABLE ponto.tb_paciente ADD COLUMN nascimento_conjuge date;
ALTER TABLE ponto.tb_paciente ADD COLUMN instagram text;
ALTER TABLE ponto.tb_paciente ADD COLUMN vencimento_carteira date;

ALTER TABLE ponto.tb_operador ADD COLUMN ocupacao_painel boolean DEFAULT true;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN laudo_sigiloso boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN adendo text;

-- Dia 22/02/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_por_sms boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_confirmacao_por_sms timestamp without time zone;