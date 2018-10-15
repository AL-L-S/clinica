-- 10/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ocupacao_mae boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ocupacao_pai boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN limitar_acesso boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente ADD COLUMN ocupacao_mae character varying(200);
ALTER TABLE ponto.tb_paciente ADD COLUMN ocupacao_pai character varying(200);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN observacao character varying(2000);

-- 15/10/2018

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3015');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'É possível cadastrar pacientes com um CPF coringa. Esse CPF é o 000.000.000-00.',
            '3015',
            'Melhoria'
            );

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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3016');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'É possível programar um lembrete de aniversário que aparece para o aniversariante do dia. Em Configuração -> Administrativas -> Manter Lembretes -> Lembrete Aniversário. ',
            '3016',
            'Melhoria'
            );

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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3047');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'O Perfil Recepção terá acesso a coluna de Valor na guia do Paciente e deixará de ter acesso as Configurações e a Sala de Espera, caso a flag limitar_acesso esteja ativa.',
            '3047',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN perfil_marketing_p boolean DEFAULT false;