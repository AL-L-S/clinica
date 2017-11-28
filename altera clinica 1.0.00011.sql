--16/11/2017

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000010');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000010', '1.0.000010');
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000011');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000011', '1.0.000011');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

-- Dia 17/11/2017

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'AGRUPADOR');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('AGRUPADOR', 'AGRUPADOR');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

CREATE TABLE ponto.tb_procedimentos_agrupados_ambulatorial
(
  procedimentos_agrupados_ambulatorial_id serial NOT NULL,
  procedimento_agrupador_id integer,
  procedimento_tuss_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimentos_agrupados_ambulatorial_id_pkey PRIMARY KEY (procedimentos_agrupados_ambulatorial_id)
);

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN agrupador boolean DEFAULT false;

-- Dia 18/11/2017
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN agrupador boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN valor_pacote_diferenciado boolean DEFAULT false;

-- Dia 20/11/2017
CREATE TABLE ponto.tb_agrupador_pacote_temp
(
  agrupador_pacote_temp_id serial NOT NULL,
  qtde_procedimentos integer,
  valor_pacote numeric(10,2),
  valor_diferenciado boolean,
  procedimento_agrupador_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  CONSTRAINT tb_agrupador_pacote_temp_id_pkey PRIMARY KEY (agrupador_pacote_temp_id)
);

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN agrupador_pacote_id integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN pacote_diferenciado boolean;

-- Dia 21/11/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN recomendacao_obrigatorio boolean DEFAULT false;

-- Dia 23/11/2017
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_producao date;

-- QUERY PARA ATUALIZAR O VALOR DA DATA_PRODUÇÃO NO REL. PROD MÉDICO
UPDATE ponto.tb_ambulatorio_laudo SET data_producao=data WHERE data_producao IS NULL;

-- Dia 24/11/2017
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN hospital_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN guia_id integer;

-- Dia 25/11/2017
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN data_atualizacao timestamp without time zone;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN operador_atualizacao integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN leito character varying(100);
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN via character varying(100);

ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN hospital_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN equipe_montada boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN orcamento_completo boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN liberada boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN data_liberacao timestamp without time zone;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN operador_liberacao integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN horario_especial boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN valor numeric(10,2);

DROP TABLE ponto.tb_solicitacao_cirurgia_orcamento;

CREATE TABLE ponto.tb_solicitacao_orcamento
(
  solicitacao_orcamento_id serial NOT NULL,
  solicitacao_cirurgia_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_solicitacao_orcamento_pkey PRIMARY KEY (solicitacao_orcamento_id)
);

CREATE TABLE ponto.tb_solicitacao_orcamento_equipe
(
  solicitacao_orcamento_equipe_id serial NOT NULL,
  solicitacao_orcamento_id integer,
  solicitacao_cirurgia_procedimento_id integer,
  operador_responsavel integer,
  funcao integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_solicitacao_orcamento_equipe_pkey PRIMARY KEY (solicitacao_orcamento_equipe_id)
);

-- Dia 27/11/2017

ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN desconto numeric(10,2);
ALTER TABLE ponto.tb_hospital ADD COLUMN valor_taxa numeric(10,2);
