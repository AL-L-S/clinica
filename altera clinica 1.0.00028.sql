--------------------------------- INICIANDO A VERSÃO 28-----------------------------------------------------

-- Dia 12/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN profissional_agendar boolean DEFAULT true;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN profissional_externo boolean DEFAULT false;

ALTER TABLE ponto.tb_operador ADD COLUMN profissional_agendar_o boolean DEFAULT true;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2870');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000028',
            'Adicionada a possibilidade de um profissional não poder agendar na multifunção fisioterapia. Existe uma flag no cadastro de empresa e uma no cadastro do profissional para isso. Ativando a da empresa a opção fica ativa no cadastro do profissional',
            '2870',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_internacao ADD COLUMN senha TEXT;

ALTER TABLE ponto.tb_internacao_ficha_questionario ADD COLUMN observacao_ligacao TEXT;

ALTER TABLE ponto.tb_internacao_ficha_questionario ALTER COLUMN tipo_dependencia TYPE TEXT;

UPDATE ponto.tb_internacao_ficha_questionario
   SET tipo_dependencia= '["' ||  tipo_dependencia || '"]'
   WHERE position('[' in tipo_dependencia) = 0;


ALTER TABLE ponto.tb_internacao ALTER COLUMN tipo_dependencia TYPE TEXT;

UPDATE ponto.tb_internacao
   SET tipo_dependencia= '["' ||  tipo_dependencia || '"]'
   WHERE position('[' in tipo_dependencia) = 0;


ALTER TABLE ponto.tb_internacao ALTER COLUMN tipo_dependencia TYPE TEXT;

UPDATE ponto.tb_internacao
   SET tipo_dependencia= '["' ||  tipo_dependencia || '"]'
   WHERE position('[' in tipo_dependencia) = 0;

-- Melhorias da versão 26 e 27.

-- ACRESCENTAR CAMPO CPF E RENOMEAR O CAMPO DETALHES(PARA STATUS),
--  EXCLUIR "TIPO DE BUSCA" (CLIENTE / PRÉ-CADASTRO) E ADICIONAR O CAMPO STATUS NO CABEÇALHO DO DOCUMENTO.

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2522');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Acrescentado campo de CPF e nomeado o campo de detalhes para status no relatório de orçamento.',
            '2522',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2521');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Acrescentado uma pesquisa por CPF no relatório de orçamentos.',
            '2521',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2505');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Unificado o relatório de Demanda Grupo ao relatório de orçamento. Os gráficos que atualmente são mostrados no relatório de demanda agora serão mostrados ao final do relatório de orçamento.',
            '2505',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2499');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Legenda no relatório de situação. A cor vermelha indica que o pŕocedimento já passou do prazo de entrega (data prevista) e ainda não foi finalizado. A data prevista é calculada da seguinte maneira: pega-se a quantidade de dias informado no campo PRAZO ENTREGA no cadastro de procedimento. Soma-se esses dias à data de atendimento.',
            '2499',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2497');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Retirado o termo "Total exames Marcados" no relatório de Faltas (RECEPÇÃO -> RELATÓRIOS -> RECEPÇÃO AGENDA -> FALTAS)',
            '2497',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2494');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Em recepção -> rotinas -> editar medico solicitante,  trocado o termo "cadastro operador" Para "Cadastro Médico Solicitante".',
            '2494',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2494');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Em recepção -> rotinas -> editar medico solicitante,  trocado o termo "cadastro operador" Para "Cadastro Médico Solicitante".',
            '2494',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2493');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Trocado o termo "Lab. Terceirizado" para "Terceirizado"',
            '2493',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2485');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Opção do operador inserir uma justificativa no momento de dar o estorno no crédito.',
            '2485',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2481');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Em todos os relátorio do sistema, nos filtros, não permitir que apareça empresas que não estão cadastradas para o operador. ps: Os relatórios que possuem "todos" ainda continuam com essa opção',
            '2481',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2530');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Adicionada opção de observações no relatório de orçamento',
            '2530',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2524');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'No relatório de orçamento os mesmos podem ser filtrados por status.',
            '2524',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2523');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Termo "Teleoperadora" alterado para "Operadora" no relatório de Teleoperadores.',
            '2523',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2532');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000026',
            'Na tela de associar médico a convênios (Configuração -> Listar Profissional -> Convênio), agora tem a opção de replicar de um médico para outro.',
            '2532',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();



-- Dia 13/09/2018

CREATE TABLE ponto.tb_laudo_apendicite
(
  simnao text,
  perguntas text,
  
  guia_id integer,
  paciente_id integer,
  laudo_apendicite_id serial not null  
);

-- Dia 14/09/2018

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN integracaosollis boolean DEFAULT false;

CREATE TABLE ponto.tb_receituario_sollis
(
  receituario_sollis_id serial NOT NULL,
  cid_id integer,
  frequencia integer,
  frequnit text,
  qtdmed integer,
  medid integer,
  periodo integer,
  perunit text,
  observacao text,
  medico_parecer1 integer,
  laudo_id integer,
  tipo character varying(50),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_receituario_sollis_pkey PRIMARY KEY (receituario_sollis_id)
  );

-- Dia 15/09/2018

ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN paciente_id integer;

CREATE TABLE ponto.tb_prescricao
(
  prescricao_id serial NOT NULL,
  prescricao text,
  medico_parecer1 integer,
  laudo_id integer,  
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  paciente_id integer,
  CONSTRAINT tb_prescricao_pkey PRIMARY KEY (prescricao_id)
  );

-- Dia 17/09/2018

ALTER TABLE ponto.tb_prescricao ADD COLUMN ativo boolean NOT NULL DEFAULT true;

ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN prescricao_id integer;
ALTER TABLE ponto.tb_receituario_sollis ADD COLUMN ativo boolean NOT NULL DEFAULT true;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000028');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000028', '1.0.000028');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();
