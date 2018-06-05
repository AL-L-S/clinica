-- Dia 30/05/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2202');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Com essa melhoria, o sistema só irá criar um novo profissional caso o CPF que tenha sido informado não conste na lista de operadores (o sistema irá buscar entre os inativos também). Ao excluir, caso o credor associado a este operador esteja associado somente a esse operador, o sistema irá exclui-lo também.',
            '2202',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

-- Dia 02/05/2018
ALTER TABLE ponto.tb_estoque_fornecedor ADD COLUMN cpf character varying(11);
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

-- Dia 04/06/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2203');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Adicionado a funcionalidade de o sistema não permitir criar mais de um credor com o mesmo CPF/CNPJ. Além disso, ao excluir o sistema irá verificar se há algum operador ou fornecedor associado a este credor. Caso possua, ele irá alertar o usuário. Também foi adicionado um botão para reativar credores excluidos.',
            '2203',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2213');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Adicionado a funcionalidade de o sistema não permitir criar mais de um convenio com o mesmo CNPJ. Ao excluir, caso o credor associado a este convenio esteja associado somente a esse convenio, o sistema irá exclui-lo também.',
            '2213',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2214');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Adicionado a funcionalidade de o sistema não permitir criar mais de um fornecedor com o mesmo CPF/CNPJ. Ao excluir, caso o credor associado a este fornecedor esteja associado somente a esse fornecedor, o sistema irá exclui-lo também.',
            '2214',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

-- Dia 05/06/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2247');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'O Relatorio Procedimento Convenio agora mostra os preços nas diversas empresas.',
            '2247',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2259');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Apartir dessa versão, o Relatório Email Operador irá ser renomeado para Relatorio Operador.',
            '2259',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_imagem_paciente boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_arquivos_paciente boolean DEFAULT true;
