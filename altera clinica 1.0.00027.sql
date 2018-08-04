-- Dia 26/07/2018
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN autorizado boolean DEFAULT false;
UPDATE ponto.tb_ambulatorio_orcamento_item SET autorizado = ao.autorizado 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.autorizado != true;

UPDATE ponto.tb_ambulatorio_orcamento_item SET data_preferencia = ao.data_criacao 
FROM ( 
    ponto.tb_ambulatorio_orcamento_item aoi 
    INNER JOIN ponto.tb_ambulatorio_orcamento ao
    ON aoi.orcamento_id = ao.ambulatorio_orcamento_id
)
WHERE ponto.tb_ambulatorio_orcamento_item.ambulatorio_orcamento_item_id = aoi.ambulatorio_orcamento_item_id
AND ponto.tb_ambulatorio_orcamento_item.data_preferencia IS NULL;

ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN observacao TEXT;

-- Dia 27/07/2018
ALTER TABLE ponto.tb_toten_senha ADD COLUMN chamada boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN idfila_painel TEXT;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN campos_atendimentomed text;

-- Dia 30/07/2018
ALTER TABLE ponto.tb_internacao ADD COLUMN faturado boolean DEFAULT false;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor1 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor2 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor3 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN valor4 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento1 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento2 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento3 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN forma_pagamento4 integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN operador_faturamento integer;
ALTER TABLE ponto.tb_internacao ADD COLUMN data_faturamento timestamp without time zone;
ALTER TABLE ponto.tb_internacao ADD COLUMN desconto numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_laudo TYPE TEXT;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_revisor TYPE TEXT;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto TYPE TEXT;

-- Dia 31/07/2018

CREATE TABLE ponto.tb_laudo_form
(
  obesidade character varying(3),
  diabetes character varying(3),
  sedentarismo character varying(3),
  hipertensao character varying(3),
  dac character varying(3),
  tabagismo character varying(3),
  dislipidemia character varying(3),
  diabetespe character varying(3),
  haspe character varying(3),
  dacpe character varying(3),
  ircpe character varying(3),
  sopros character varying(3),
  questoes text,
  paciente_id integer,
  guia_id integer,
  laudo_form_id serial primary key
  );

-- Dia 03/08/2018

CREATE TABLE ponto.tb_laudo_avaliacao
(
  avaliacao_tabela1 text,
  avaliacao_tabela2 text,
  avaliacao_tabela3 text,
  avaliacao_tabela4 text,
  paciente_id integer,
  guia_id integer,
  laudo_avaliacao_id serial primary key  
);
CREATE TABLE ponto.tb_internacao_procedimentos
(
  internacao_procedimentos_id SERIAL NOT NULL,
  internacao_id integer,
  procedimento_convenio_id integer,
  empresa_id integer,
  medico_id integer,
  quantidade integer,
  valor_total numeric(10,2) DEFAULT 0,
  forma_pagamento1 integer,
  valor1 numeric(10,2) DEFAULT 0,
  forma_pagamento2 integer,
  valor2 numeric(10,2) DEFAULT 0,
  forma_pagamento3 integer,
  valor3 numeric(10,2) DEFAULT 0,
  forma_pagamento4 integer,
  valor4 numeric(10,2) DEFAULT 0,
  operador_faturamento integer,
  data_faturamento timestamp without time zone,
  desconto numeric(10,2) DEFAULT 0,
  faturado boolean NOT NULL DEFAULT false,
  autorizacao character varying(50),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_internacao_procedimentos_pkey PRIMARY KEY (internacao_procedimentos_id)
);


ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN financeiro boolean DEFAULT false;

ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN operador_financeiro integer;
ALTER TABLE ponto.tb_internacao_procedimentos ADD COLUMN data_financeiro timestamp without time zone;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2338');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Na lista de saídas é possível re-internar o paciente e foram adicionados mais filtros na busca',
            '2338',
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
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao_alteracao WHERE chamado = '2581');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao_alteracao(versao, alteracao, chamado, tipo)
        VALUES ('1.0.000027',
            'Criado o faturamento de internações em Faturamento->Rotinas->Faturar e Faturamento->Rotinas->Faturamento Manual',
            '2581',
            'Melhoria'
            );
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;
SELECT insereValor();


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN gerente_cancelar boolean DEFAULT true;


 <?if(@$empresapermissoes->gerente_cancelar == 't' || $perfil_id == 1){?><?}?>
