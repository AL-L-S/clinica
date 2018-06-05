--02/06/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_relatorio_financeiro boolean DEFAULT false;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2228');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'O Perfil Gerente de Recepção Financeiros tem acesso a mais relatórios ativando uma flag no cadastro da empresa',
            '2228',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2170');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Criada uma nova tela onde se tem uma lista das internações',
            '2170',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_upload text;

--05/06/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_imagem_paciente boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_arquivos_paciente boolean DEFAULT true;