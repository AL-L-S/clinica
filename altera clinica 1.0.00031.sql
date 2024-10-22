-- 10/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ocupacao_mae boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ocupacao_pai boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN limitar_acesso boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente ADD COLUMN ocupacao_mae character varying(200);
ALTER TABLE ponto.tb_paciente ADD COLUMN ocupacao_pai character varying(200);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN observacao character varying(2000);

-- 15/10/2018
ALTER TABLE ponto.tb_ambulatorio_tipo_consulta ADD COLUMN grupo text;

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

-- 18/10/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN detalhes boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN orcamento_multiplo boolean DEFAULT false;

-- Data 16/10/2018


CREATE TABLE ponto.tb_estoque_nota
(
  estoque_nota_id serial NOT NULL,  
  valor_nota numeric(10,2),  
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  nota_fiscal character varying(30),
  fornecedor_id integer,
  armazem_id integer,  
  CONSTRAINT tb_estoque_nota_pkey PRIMARY KEY (estoque_nota_id)
);

CREATE TABLE ponto.tb_estoque_entrada_nota
(
  estoque_entrada_nota_id serial NOT NULL,
  produto_id integer,
  fornecedor_id integer,
  armazem_id integer,
  valor_compra numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  nota_fiscal character varying(30),
  validade date,
  inventario boolean DEFAULT false,
  lote character varying(30),
  transferencia boolean DEFAULT false,
  armazem_transferencia integer,
  saida_id_transferencia text,
  fracionamento_id integer,
  situacao character varying(30) DEFAULT 'PENDENTE'::character varying,
  CONSTRAINT tb_estoque_entrada_nota_pkey PRIMARY KEY (estoque_entrada_nota_id)
);

CREATE TABLE ponto.tb_estoque_saldo_nota
(
  estoque_saldo_nota_id serial NOT NULL,
  estoque_entrada_nota_id integer,
  estoque_saida_id integer,
  produto_id integer,
  fornecedor_id integer,
  armazem_id integer,
  valor_compra numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  nota_fiscal character varying(30),
  validade date,
  ambulatorio_gasto_sala_id integer,
  CONSTRAINT tb_estoque_saldo_nota_pkey PRIMARY KEY (estoque_saldo_nota_id)
);

-- Data 17/10/2018

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_ajuste_faturamento integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_ajuste_faturamento timestamp without time zone;

-- Data 18/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN manternota boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN agenda_modelo2 boolean DEFAULT false;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3090');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Agora no Manter Percentual Médico já é possível ajustar os valores de mais de um convênio, médico e etc. E além disso ao clicar em Ajuste Percentual, ele abre o outro campo para digitar um ajuste em percentual podendo assim aumentar 10% do valor de um profissional por exemplo',
            '3090',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3094');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'No orçamento as datas no campo de data de preferência são listadas baseadas no "Tipo Agenda" utilizado na criação da mesma.',
            '3094',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3107');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Em Novo Agrupador (Manter Procedimentos) os filtros de pesquisa foram reposicionados baseados nos campos logo abaixo, ou seja, o filtro de grupo fica logo acima dos grupos dos procedimentos na listagem, o de nome em cima do nome do procedimento e etc.',
            '3107',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3108');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Nos procedimentos dos convenios filhos colocado um botao "desativar" que irá desativar o procedimento para todas as empresas',
            '3108',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3083');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Atualmente no cadastro de empresa existe um local onde é possível definir o horário de funcionamento da empresa. O mesmo aparecia apenas na ficha. Agora através dele, as agendas criadas são limitadas temporalmente baseando-se nesse horário cadastrado, ou seja, em caso de a clinica só funcionar de 08:00 as 12:00, os horários lançados serão ajustados para não ocorrer problemas como alguém agendar um paciente para um horário onde a empresa não funciona',
            '3083',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3109');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Existe a opção de transformar os orçamentos em "orçamento multiplo", isso irá fazer com que seja possível lançar mais de um procedimento ao mesmo tempo no orçamento. No orçamento padrão, você lança um procedimento de cada vez, utilizando esse novo método, você consegue lançar vários ao mesmo tempo e apenas alterar os detalhes posteriormente.',
            '3109',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

-- 22/10/2018

ALTER TABLE ponto.tb_agenda ADD COLUMN medico_id integer;
ALTER TABLE ponto.tb_agenda ADD COLUMN tipo_agenda integer;
ALTER TABLE ponto.tb_agenda ADD COLUMN intervalo integer;
ALTER TABLE ponto.tb_agenda ADD COLUMN datacon_inicio date;
ALTER TABLE ponto.tb_agenda ADD COLUMN datacon_fim date;
ALTER TABLE ponto.tb_agenda ADD COLUMN consolidada boolean DEFAULT false;
-- Data 22/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN laboratorio_sc boolean DEFAULT false;

ALTER TABLE ponto.tb_estoque_nota ADD COLUMN situacao character varying(30) DEFAULT 'PENDENTE'::character varying;

ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN estoque_nota_id integer;


-- Dia 23/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN faturamento_novo boolean DEFAULT false;

CREATE TABLE ponto.tb_agenda_exames_faturar
(
  agenda_exames_faturar_id serial NOT NULL,
  agenda_exames_id integer,
  guia_id integer,
  procedimento_convenio_id integer,
  forma_pagamento_id integer,
  valor_total numeric(10,2) DEFAULT 0,
  valor numeric(10,2) DEFAULT 0,
  valor_bruto numeric(10,2) DEFAULT 0,
  parcela integer DEFAULT 0,
  desconto numeric(10,2)DEFAULT 0,
  ajuste numeric(10,2) DEFAULT 0,
  desconto_ajuste numeric(10,2) DEFAULT 0,
  data date,
  ativo boolean DEFAULT true,
  faturado boolean DEFAULT false,
  financeiro boolean DEFAULT false,
  operador_faturamento integer,
  operador_cadastro integer,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  data_cadastro timestamp without time zone,
  CONSTRAINT tb_agenda_exames_faturar_pkey PRIMARY KEY (agenda_exames_faturar_id)
);


CREATE TABLE ponto.tb_agenda_exames_faturar_bkp
(
  agenda_exames_faturar_bkp_id serial NOT NULL,
  agenda_exames_faturar_id integer,
  alteracao text,
  json_salvar text,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  CONSTRAINT tb_agenda_exames_faturar_bkp_pkey PRIMARY KEY (agenda_exames_faturar_bkp_id)
);


ALTER TABLE ponto.tb_agenda_exames_faturar ADD COLUMN faturado_guia boolean DEFAULT false;

ALTER TABLE ponto.tb_agenda_exames_faturar ADD COLUMN operador_financeiro integer;
ALTER TABLE ponto.tb_agenda_exames_faturar ADD COLUMN data_financeiro timestamp without time zone;


CREATE TABLE ponto.tb_financeiro_caixa
(
  financeiro_caixa_id serial NOT NULL,
  forma_pagamento_id integer,
  forma_pagamento_nome text,
  valor numeric(10,2),
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  CONSTRAINT tb_financeiro_caixa_pkey PRIMARY KEY (financeiro_caixa_id)
);


ALTER TABLE ponto.tb_financeiro_contasreceber ADD COLUMN financeiro_caixa_id integer;
ALTER TABLE ponto.tb_entradas ADD COLUMN financeiro_caixa_id integer;

-- Dia 26/10/2018

ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN data_aso date;


ALTER TABLE ponto.tb_financeiro_contasreceber_temp ADD COLUMN financeiro_caixa_id integer;


CREATE TABLE ponto.tb_internacao_statusinternacao
(
  internacao_statusinternacao_id serial NOT NULL,
  nome character varying(100) NOT NULL,
  observacao text,
  dias_status integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  hospital integer,
  CONSTRAINT tb_internacao_statusinternacao_pkey PRIMARY KEY (internacao_statusinternacao_id)
);


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3109');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Desenvolvida uma nova forma de criar agendas. Ao ativar a nova opção, as agendas são associadas diretamente ao médico e podem ser editadas/consolidadas em uma única tela.',
            '3134',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '3109');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000031',
            'Recriado o faturamento de procedimentos particulares. Ao ativar a opção agora existe uma nova forma de faturar procedimentos particulares e a possibilidade de faturar parcialmente um procedimento. Ex: Paciente pagou 50 reais do procedimento, o caixa irá fechar com aqueles 50 reais e quando o paciente pagar o resto, será possível fechar o caixa novamente. Também é possível fechar o caixa várias vezes ao dia.',
            '2999',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_internacao_statusinternacao ADD COLUMN color text;
-- 05/11/2018
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000031');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000031', '1.0.000031');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
-- Dia 30/10/2018

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN cadastro_aso_id integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN situacao_aso integer;

CREATE TABLE ponto.tb_aso_situacao
(
  aso_situacao_id serial NOT NULL,
  descricao_situacao character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer, 
  CONSTRAINT tb_aso_situacao_pkey PRIMARY KEY (aso_situacao_id)
);

-- Dia 01/11/2018

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'ACUIDADE VISUAL');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('ACUIDADE VISUAL', 'ESPECIALIDADE');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
