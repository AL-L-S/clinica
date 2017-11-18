-- Dia 17/11/2017

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'AGRUPADOR');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('AGRUPADOR', 'AGRUPADOR');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

CREATE TABLE ponto.tb_procedimentos_agrupados_ambulatorial
(
  procedimentos_agrupados_ambulatorial_id serial NOT NULL,
  procedimento_agrupador_id integer,
  procedimento_tuss_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimentos_agrupados_ambulatorial_id_pkey PRIMARY KEY (procedimentos_agrupados_ambulatorial_id)
);

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN agrupador boolean DEFAULT false;
