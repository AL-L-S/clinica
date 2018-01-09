--22/12/2017

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000013');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000013', '1.0.000013');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();



ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN valor_autorizar boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_contasapagar boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN cpf_obrigatorio boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN orcamento_recepcao boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_ordem boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorio_producao boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN relatorios_recepcao boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN financeiro_cadastro boolean DEFAULT false;

-- Dia 26/12/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN retirar_botao_ficha boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN desativar_personalizacao_impressao boolean DEFAULT false;

-- Dia 28/12/2017
ALTER TABLE ponto.tb_empresa ADD COLUMN mostrar_logo_clinica boolean DEFAULT false;

-- Dia 04/01/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN confirmacao_medico boolean;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'CONTADOR');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (17, 'CONTADOR');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();




