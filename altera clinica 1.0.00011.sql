--16/11/2017

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000010');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000010', '1.0.000010');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000011');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000011', '1.0.000011');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

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

-- Dia 18/11/2017
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN agrupador boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN valor_pacote_diferenciado boolean DEFAULT false;

-- Dia 20/11/2017
CREATE TABLE ponto.tb_agrupador_pacote_temp
(
  agrupador_pacote_temp_id serial NOT NULL,
  qtde_procedimentos integer,
  valor_pacote numeric(10,2),
  valor_diferenciado boolean,
  procedimento_agrupador_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  CONSTRAINT tb_agrupador_pacote_temp_id_pkey PRIMARY KEY (agrupador_pacote_temp_id)
);

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN agrupador_pacote_id integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN pacote_diferenciado boolean;

