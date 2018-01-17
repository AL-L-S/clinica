--09/01/2018


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'GERENTE DE RECEPÇÃO FINANCEIRO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (18, 'GERENTE DE RECEPÇÃO FINANCEIRO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


-- Dia 10/01/2017
CREATE TABLE ponto.tb_paciente_indicacao_grupo
(
    paciente_indicacao_grupo_id serial NOT NULL,
    nome character varying(40),
    ativo boolean DEFAULT true,
    data_cadastro timestamp without time zone,
    operador_cadastro integer,
    data_atualizacao timestamp without time zone,
    operador_atualizacao integer,
    CONSTRAINT tb_paciente_indicacao_grupo_pkey PRIMARY KEY (paciente_indicacao_grupo_id)
);
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN data_cadastro timestamp without time zone;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN operador_cadastro integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN grupo_id integer;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN registro character varying(60);

-- Dia 13/01/2017
ALTER TABLE ponto.tb_convenio_operador_procedimento ADD COLUMN empresa_id integer;

UPDATE ponto.tb_ambulatorio_convenio_operador
SET empresa_id = (SELECT empresa_id FROM ponto.tb_empresa WHERE ativo = 't' ORDER BY empresa_id LIMIT 1)
WHERE empresa_id IS NULL;

UPDATE ponto.tb_convenio_operador_procedimento
SET empresa_id  = (SELECT empresa_id FROM ponto.tb_empresa WHERE ativo = 't' ORDER BY empresa_id LIMIT 1)
WHERE empresa_id IS NULL;

-- Dia 17/01/2018
ALTER TABLE ponto.tb_empresa_sms ADD COLUMN endereco_externo character varying(60);