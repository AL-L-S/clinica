-- Dia 05/03/2018
CREATE TABLE ponto.tb_ambulatorio_empresa_operador
(
  ambulatorio_empresa_operador_id serial NOT NULL,
  operador_id integer,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_empresa_operador_pkey PRIMARY KEY (ambulatorio_empresa_operador_id)
);

INSERT INTO ponto.tb_ambulatorio_empresa_operador(operador_id, empresa_id)
SELECT oe.operador_id, oe.empresa_id
FROM ponto.tb_operador_empresas oe
WHERE oe.ativo = 't'
AND oe.operador_id NOT IN (
    SELECT DISTINCT(operador_id)
    FROM ponto.tb_ambulatorio_empresa_operador
    WHERE ativo = 't'
);

-- Dia 07/03/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN subgrupo_procedimento boolean DEFAULT false;

CREATE TABLE ponto.tb_ambulatorio_subgrupo
(
  ambulatorio_subgrupo_id serial NOT NULL,
  nome character varying(250),
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_subgrupo_pkey PRIMARY KEY (ambulatorio_subgrupo_id)
);

CREATE TABLE ponto.tb_ambulatorio_subgrupo_grupo
(
  ambulatorio_subgrupo_grupo_id serial NOT NULL,
  grupo character varying(250),
  subgrupo_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_ambulatorio_subgrupo_grupo_pkey PRIMARY KEY (ambulatorio_subgrupo_grupo_id)
);

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN subgrupo_id integer;
