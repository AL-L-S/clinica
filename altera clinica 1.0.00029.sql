-- 18/09
ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_integracao_lab text;
ALTER TABLE ponto.tb_empresa ADD COLUMN identificador_lis text;
ALTER TABLE ponto.tb_empresa ADD COLUMN origem_lis text;


ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN texto TYPE text;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN mensagem_integracao_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN json_integracao_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_integracao_lab timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_integracao_lab integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN json_resultado_lab text;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_resultado_lab timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_resultado_lab integer;
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


-- Dia 18/09/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN endereco_integracao_lab text;

-- Dia 20/09/2018
ALTER TABLE ponto.tb_operador ADD COLUMN guiche integer;

CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2965');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000029',
            'No caso de existir chamada de Painel via Toten, é obrigatório o cadastro da senha no atendimento do paciente. (Novo atendimento e Autorizar Atendimento)',
            '2965',
            'Melhoria'
            );

    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


-- Dia 21/09/2018
ALTER TABLE ponto.tb_aso_risco ALTER COLUMN descricao_risco TYPE text;

-- Dia 24/09/2018
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN medicinadotrabalho boolean DEFAULT false;
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN data_realizacao date;
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN data_validade date;
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN convenio_id integer;

-- Dia 25/09/2018
ALTER TABLE ponto.tb_setor_cadastro ADD COLUMN exames_id text;

-- Dia 26/09/2018
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN consulta text;
ALTER TABLE ponto.tb_cadastro_aso ADD COLUMN convenio2 text;
