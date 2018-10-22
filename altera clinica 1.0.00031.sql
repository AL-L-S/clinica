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

-- Data 22/10/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN laboratorio_sc boolean DEFAULT false;

ALTER TABLE ponto.tb_estoque_nota ADD COLUMN situacao character varying(30) DEFAULT 'PENDENTE'::character varying;

ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN estoque_nota_id integer;
