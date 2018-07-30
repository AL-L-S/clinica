-- Dia 12/07/2018
ALTER TABLE ponto.tb_paciente_estorno_registro ADD COLUMN justificativa TEXT;

-- Dia 16/07/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorios_clinica_med boolean DEFAULT false;

-- Dia 17/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN data_preferencia timestamp without time zone;

-- Dia 18/07/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_ficha_convenio boolean;
ALTER TABLE ponto.tb_empresa_permissoes ALTER COLUMN botao_ficha_convenio SET DEFAULT false;

-- Dia 23/07/2018
ALTER TABLE ponto.tb_paciente ADD COLUMN cpf_responsavel_flag boolean DEFAULT false;

UPDATE ponto.tb_paciente
   SET cpf=cpf_responsavel, cpf_responsavel_flag = true
 WHERE (cpf = '' OR cpf IS NULL) AND (cpf_responsavel != '' OR cpf_responsavel IS NOT NULL);

-- Dia 24/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento ADD COLUMN observacao TEXT;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000026');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000026', '1.0.000026');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
