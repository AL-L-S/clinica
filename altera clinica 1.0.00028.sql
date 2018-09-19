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
