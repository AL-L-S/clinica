CREATE TABLE ponto.tb_versao_alteracao
(
  versao_alteracao_id serial NOT NULL,
  versao text,
  alteracao text,
  chamado text,
  tipo text,
  banco_de_dados character varying(20),
  CONSTRAINT tb_versao_alteracao_pkey PRIMARY KEY (versao_alteracao_id)
);


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '1674');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023',
            'Adicionado um log de alterações feitas no convênio. Localize-se na tela de listagem de convênios',
            '1674',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

CREATE TABLE ponto.tb_convenio_log
(
  convenio_log_id serial NOT NULL,
  convenio_id integer,
  alteracao text,
  informacao_antiga text,
  informacao_nova text,
  json text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,

  CONSTRAINT tb_convenio_log_pkey PRIMARY KEY (convenio_log_id)
);

-- 23/05/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN orcamento_cadastro boolean DEFAULT true;

ALTER TABLE ponto.tb_ambulatorio_orcamento ADD COLUMN cadastro boolean DEFAULT true;


ALTER TABLE ponto.tb_internacao ADD COLUMN nome_responsavel character varying(200);
ALTER TABLE ponto.tb_internacao ADD COLUMN cep_responsavel character varying(9);
ALTER TABLE ponto.tb_internacao ADD COLUMN logradouro_responsavel character varying(200);
ALTER TABLE ponto.tb_internacao ADD COLUMN numero_responsavel character varying(20);
ALTER TABLE ponto.tb_internacao ADD COLUMN complemento_responsavel character varying(100);
ALTER TABLE ponto.tb_internacao ADD COLUMN bairro_responsavel character varying(100);
ALTER TABLE ponto.tb_internacao ADD COLUMN municipio_responsavel_id integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN rg_responsavel character varying(20);
ALTER TABLE ponto.tb_internacao ADD COLUMN cpf_responsavel character varying(11);
ALTER TABLE ponto.tb_internacao ADD COLUMN email_responsavel character varying(60);
ALTER TABLE ponto.tb_internacao ADD COLUMN celular_responsavel character varying(60);
ALTER TABLE ponto.tb_internacao ADD COLUMN telefone_responsavel character varying(60);
ALTER TABLE ponto.tb_internacao ADD COLUMN grau_parentesco character varying(60);



CREATE TABLE ponto.tb_internacao_modelo_grupo
(
  internacao_modelo_grupo_id serial,
  nome character varying(200),
  texto text,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_internacao_modelo_grupo_pkey PRIMARY KEY (internacao_modelo_grupo_id)
);


CREATE TABLE ponto.tb_internacao_ficha_questionario
(
  internacao_ficha_questionario_id serial NOT NULL,
  paciente_id integer,
  ocupacao_id integer,
  municipio_id integer,
  nome text,
  tipo_dependencia text,
  idade_inicio integer,
  paciente_agressivo text,
  aceita_tratamento text,
  tomou_conhecimento text,
  plano_saude text,
  plano_saude_qual text,
  tratamento_anterior text,
  telefone_contato text,
  operador_atendimento integer,
  observacao text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_ficha_questionario_pkey PRIMARY KEY (internacao_ficha_questionario_id)
);

CREATE TABLE ponto.tb_internacao_ficha_questionario
(
  internacao_ficha_questionario_id serial NOT NULL,
  paciente_id integer,
  municipio_id integer,
  convenio_id integer,
  nome text,
  grau_parentesco text,
  ocupacao_responsavel text,
  tipo_dependencia integer,
  idade_inicio integer,
  paciente_agressivo text,
  aceita_tratamento text,
  tomou_conhecimento integer,
  plano_saude text,
  tratamento_anterior text,
  telefone_contato text,
  operador_atendimento integer,
  observacao text,
  grupo text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_ficha_questionario_pkey PRIMARY KEY (internacao_ficha_questionario_id)
);

ALTER TABLE ponto.tb_internacao_ficha_questionario ADD COLUMN confirmado boolean DEFAULT false;
ALTER TABLE ponto.tb_internacao_ficha_questionario ADD COLUMN aprovado boolean DEFAULT false;


CREATE TABLE ponto.tb_internacao_tipo_dependencia
(
  internacao_tipo_dependencia_id serial,
  nome text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_tipo_dependencia_pkey PRIMARY KEY (internacao_tipo_dependencia_id)
);


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '1674');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionado um log de alterações feitas no convênio. Localize-se na tela de listagem de convênios',
            '1674',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '1674');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionado um log de alterações feitas no convênio. Localize-se na tela de listagem de convênios',
            '1674',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2117');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionado a possibilidade de cadastrar um orçamento sem um cadastro de paciente para posteriormente associa-lo na hora de autorizar',
            '2117',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '1982');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionada a possibilidade de reagendar um atendimento na multifunção geral (Recepção)',
            '1982',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '1981');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionado um botão na multifunção geral da recepção para bloquear os horários da agenda',
            '1981',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2201');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000023', 
            'Adicionado a possiblidade de fazer a criação e edição de percentuais médicos da mesma maneira que o cadastro de multiplos procedimentos. Para usar, ative a flag "Percentual similar ao Proc. Multiplos" no cadastro de empresa.',
            '2201',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();

