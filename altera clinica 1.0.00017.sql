-- Dia 02/02/2018

-- Remove os procedimentos repetidos no cadastro de convenio por operador.
UPDATE ponto.tb_convenio_operador_procedimento SET ativo = false WHERE convenio_operador_procedimento_id in (
    WITH t AS (
        SELECT convenio_operador_procedimento_id, operador, convenio_id, empresa_id, procedimento_convenio_id, ROW_NUMBER() 
        OVER (PARTITION BY operador, convenio_id, empresa_id, procedimento_convenio_id) AS row_number 
        FROM ponto.tb_convenio_operador_procedimento
        WHERE ativo = 't'
    )
    SELECT convenio_operador_procedimento_id FROM t WHERE row_number > 1
);

-- Remove os convenios repetidos no cadastro de convenio por operador.
UPDATE ponto.tb_ambulatorio_convenio_operador SET ativo = false WHERE ambulatorio_convenio_operador_id in (
    WITH t AS (
        SELECT ambulatorio_convenio_operador_id, operador_id, convenio_id, empresa_id, ROW_NUMBER() 
        OVER (PARTITION BY operador_id, convenio_id, empresa_id) AS row_number 
        FROM ponto.tb_ambulatorio_convenio_operador
        WHERE ativo = 't'
    )
    SELECT ambulatorio_convenio_operador_id FROM t WHERE row_number > 1
);

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'OPME');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('OPME', 'CIRURGICO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


-- Dia 03/02/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_previsao_labotorio boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_previsao_promotor boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_previsao_medico boolean DEFAULT false;

-- Dia 05/02/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN numero_empresa_painel integer;

CREATE TABLE ponto.tb_exame_sala_painel
(
  exame_sala_painel_id serial NOT NULL,
  nome_chamada character varying(200),
  exame_sala_id integer,
  painel_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_exame_sala_painel_pkey PRIMARY KEY (exame_sala_painel_id)
);

INSERT INTO ponto.tb_exame_sala_painel(exame_sala_id, nome_chamada, painel_id)
SELECT exame_sala_id, nome_chamada, painel_id FROM ponto.tb_exame_sala
WHERE exame_sala_id NOT IN ( SELECT exame_sala_id FROM ponto.tb_exame_sala_painel )
AND painel_id IS NOT NULL;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000017');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000017', '1.0.000017');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();
