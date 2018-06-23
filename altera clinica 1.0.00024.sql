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

-- Dia 09/06/2018
CREATE TABLE ponto.tb_procedimento_convenio_forma_pagamento
(
  procedimento_convenio_forma_pagamento_id serial NOT NULL,
  procedimento_convenio_id integer,
  forma_pagamento_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_convenio_forma_pagamento_pkey PRIMARY KEY (procedimento_convenio_forma_pagamento_id)
);
ALTER TABLE ponto.tb_procedimento_convenio_forma_pagamento ADD COLUMN ajuste numeric(10,2);

CREATE TABLE ponto.tb_convenio_forma_pagamento
(
  convenio_forma_pagamento_id serial NOT NULL,
  forma_pagamento_id integer,
  convenio_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_forma_pagamento_pkey PRIMARY KEY (convenio_forma_pagamento_id)
);
ALTER TABLE ponto.tb_convenio_forma_pagamento ADD COLUMN ajuste numeric(10,2);

-- Dia 11/06/2018
CREATE TABLE ponto.tb_convenio_forma_pagamento
(
  convenio_forma_pagamento_id serial NOT NULL,
  forma_pagamento_id integer,
  convenio_id integer,
  ajuste numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_forma_pagamento_pkey PRIMARY KEY (procedimento_convenio_forma_pagamento_id)
);

-- Dia 12/06/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2273');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_procedimento_convenio_forma_pagamento(procedimento_convenio_id, forma_pagamento_id, ajuste)
        SELECT pcp.procedimento_convenio_id, gf.forma_pagamento_id, 0
        FROM ponto.tb_procedimento_convenio pc
        INNER JOIN ponto.tb_procedimento_convenio_pagamento pcp ON pcp.procedimento_convenio_id = pc.procedimento_convenio_id
        INNER JOIN ponto.tb_grupo_formapagamento gf ON gf.grupo_id = pcp.grupo_pagamento_id
        WHERE pcp.ativo = 't' AND gf.ativo = 't';
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2273');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_convenio_forma_pagamento(convenio_id, forma_pagamento_id, ajuste)
        SELECT c.convenio_id, gf.forma_pagamento_id, 0
        FROM ponto.tb_convenio c
        INNER JOIN ponto.tb_convenio_grupopagamento cgp ON cgp.convenio_id = c.convenio_id
        INNER JOIN ponto.tb_grupo_formapagamento gf ON gf.grupo_id = cgp.grupo_pagamento_id
        WHERE cgp.ativo = 't' AND gf.ativo = 't';
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ajuste_pagamento_procedimento boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN retirar_preco_procedimento boolean DEFAULT false;

-- Dia 14/06/2018
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN procedimento_possui_ajuste_pagamento boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN forma_pagamento_ajuste integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_forma_pagamento_ajuste numeric(10,2);

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2273');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Foi retirada a funcionalidade do grupo de pagamento. Agora os procedimentos poderão ser associados diretamente a uma forma de pagamento. Além disso, foi inserido uma opção de ajuste no pagamento. Ao lançar um novo procedimento, caso ele possua um ajuste associado a alguma de suas formas de pagamento, será obrigatorio escolher uma forma de pagamento. Caso a forma de pagamento selecionada possua ajuste, esse valor irá se sobrepôr ao valor original do procedimento.',
            '2273',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2346');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000024',
            'Apatir desta versao, a lista de promotores e solicitantes na tela de Novo Atendimento nao ira mais ordenar de forma alfabetica, mas sim de acordo com a frequencia de uso dos registros no sistema.',
            '2346',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();