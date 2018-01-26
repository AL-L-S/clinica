-- Dia 20/01/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN valor_ajustado numeric(10,2);

-- Dia 23/01/2018
UPDATE ponto.tb_ambulatorio_orcamento_item oi
SET paciente_id = ( SELECT paciente_id FROM ponto.tb_ambulatorio_orcamento WHERE ponto.tb_ambulatorio_orcamento.ambulatorio_orcamento_id = oi.orcamento_id LIMIT 1 )
WHERE oi.paciente_id IS NULL;

-- Dia 24/01/2018
ALTER TABLE ponto.tb_horarioagenda ADD COLUMN sala_id integer;
ALTER TABLE ponto.tb_horarioagenda_editada ADD COLUMN sala_id integer;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN desabilitar_trava_retorno boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes DROP COLUMN encaminhamento_citycor;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN encaminhamento_email boolean DEFAULT false;

-- Dia 25/01/2018
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_alteracao_producao timestamp without time zone;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN situacao_revisor TYPE TEXT;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN cabecalho TYPE TEXT;

-- Dia 26/01/2018
ALTER TABLE ponto.tb_convenio ADD COLUMN guia_prestador_unico boolean DEFAULT false;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'MEDICO ADMINISTRATIVO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (19, 'MEDICO ADMINISTRATIVO');
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000015');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000015', '1.0.000015');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();