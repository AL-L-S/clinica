-- 14/06/2018
ALTER TABLE ponto.tb_internacao ADD COLUMN idade_inicio integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN tipo_dependencia integer;

ALTER TABLE ponto.tb_internacao ADD COLUMN ocupacao_responsavel text;

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_internacao integer;



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2275');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Adicionado filtro de especialidade no faturar. Obs: Para fechar o faturamento é necessário retirar o filtro',
            '2275',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2286');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Impressões configuráveis adicionadas a lista de internação',
            '2286',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2282');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Versão alternativa do termo de internação e termo de saída adicionado para local específico (IVV)',
            '2282',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_internacao ADD COLUMN excluido boolean DEFAULT false;



CREATE TABLE ponto.tb_empresa_impressao_internacao_temp
(
  empresa_impressao_internacao_temp_id serial,
  texto text,
  impressao_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  adicional_cabecalho text,
  CONSTRAINT tb_empresa_impressao_internacao_temp_pkey PRIMARY KEY (empresa_impressao_internacao_temp_id)
);


ALTER TABLE ponto.tb_internacao ADD COLUMN procedimento_convenio_id integer;

ALTER TABLE ponto.tb_internacao ADD COLUMN valor_total numeric(10,2);


-- QUERY CORRETA PARA AS CLINICAS COMUNS
UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, pc.procedimento_convenio_id
FROM ponto.tb_internacao i
LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
WHERE p.convenio_id is not null
AND pc.procedimento_tuss_id = i.procedimentosolicitado
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;
 



-- QUERY ESPECIFICA PARA O IVV
-- ESSA QUERY É PARA O IVV ESPECIFICAMENTE DEVIDO AO FATO DE QUE ELES COLOCARAM PROCEDIMENTOS_TUSS
-- COM ID DIFERENTE NAS INTERNAÇOES, NAO SEGUINDO UM PADRAO PARA PODER COMEÇAR A UTILIZAR VALOR NOS PROCEDIMENTOS
-- SENDO ASSIM ESSA QUERY ABAIXO OLHA APENAS PARA O CONVENIO E NAO PARA O PROCEDIMENTO, JA QUE ELES POSSUEM APENAS UM
-- POR CONVENIO
-- NAS OUTRAS CLINICAS, É SÓ RODAR A DE CIMA
/*

UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, i.paciente_id, i.procedimentosolicitado, p.convenio_id, pc.procedimento_convenio_id
 FROM ponto.tb_internacao i
 LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
 LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
 --WHERE p.convenio_id is not null
 WHERE pc.convenio_id = p.convenio_id
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;



UPDATE ponto.tb_internacao i
  SET procedimento_convenio_id = selecao.procedimento_convenio_id
FROM 
 (SELECT i.internacao_id, pc.procedimento_convenio_id
FROM ponto.tb_internacao i
LEFT JOIN ponto.tb_paciente p ON i.paciente_id = p.paciente_id 
LEFT JOIN ponto.tb_procedimento_convenio pc ON p.convenio_id = pc.convenio_id 
WHERE p.convenio_id is not null
AND pc.procedimento_tuss_id = i.procedimentosolicitado
 ) as selecao
 WHERE i.internacao_id = selecao.internacao_id;

 */

UPDATE ponto.tb_internacao i
  SET valor_total = selecao.valortotal
FROM 
 (SELECT pc.procedimento_convenio_id, valortotal
   FROM ponto.tb_procedimento_convenio pc
 ) as selecao
 WHERE i.procedimento_convenio_id = selecao.procedimento_convenio_id;


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

-- Dia 25/06/2018
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento_ajuste integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN valor_forma_pagamento_ajuste numeric(10,2);

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_laudo_paciente boolean DEFAULT true;
--  Dia 28/06/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2385');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Com esta melhoria, em manter procedimento (ao ativar a flag de procedimentos multiempresa) mostrar uma legenda com as cores presentes no campo valor.',
            '2385',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2386');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Adicionada uma flag no cadastro de empresa para saber se elá irá usar a tela de preço procedimento ou apenas a tela de orçamento.',
            '2386',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2387');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'O campo "Forma de Pagamento" passa a ser obrigatorio no orçamento e no momento de lançar algum procedimento (caso esteja marcado que á empresa vá usar ajuste no procedimento).',
            '2387',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2421');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000025',
            'Adicionada uma flag no cadastro de empresa para saber se elá irá usar a tela de preço procedimento ou apenas a tela de orçamento.',
            '2421',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
