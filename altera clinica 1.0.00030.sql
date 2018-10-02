-- 01/10/2018

CREATE TABLE ponto.tb_estoque_fracionamento
(
  estoque_fracionamento_id serial NOT NULL,
  produto_id integer,
  quantidade integer,
  produto_entrada integer,
  quantidade_entrada integer,
  fornecedor_id integer,
  armazem_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,

  CONSTRAINT tb_estoque_fracionamento_pkey PRIMARY KEY (estoque_fracionamento_id)
);

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN fracionamento_id integer;

ALTER TABLE ponto.tb_convenio ADD COLUMN padrao_particular boolean DEFAULT false;