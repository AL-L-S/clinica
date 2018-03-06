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
