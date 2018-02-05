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
CREATE TABLE ponto.tb_agenda_exames_flag
(
  agenda_exames_flag_id serial NOT NULL,
  agenda_exames_id integer,
  confirmacao_previsao_labotorio boolean DEFAULT false,
  confirmacao_previsao_promotor boolean DEFAULT false,
  confirmacao_previsao_medico boolean DEFAULT false,
  CONSTRAINT tb_agenda_exames_flag_pkey PRIMARY KEY (agenda_exames_flag_id)
);