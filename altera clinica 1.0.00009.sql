-- Salvar ao mudar o percentual médico

CREATE TABLE ponto.tb_procedimento_percentual_medico_convenio_antigo
(
  procedimento_percentual_medico_convenio_antigo_id serial,
  procedimento_percentual_medico_convenio_id integer,
  procedimento_percentual_medico_id integer,
  medico integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  CONSTRAINT tb_procedimento_percentual_medico_convenio_antigo_pkey PRIMARY KEY (procedimento_percentual_medico_convenio_antigo_id)
);

-- Valor Indicação Cadastro

UPDATE ponto.tb_agenda_exames
   SET 
       valor_promotor= mc.valor, percentual_promotor= mc.percentual


       
FROM ponto.tb_procedimento_percentual_promotor m , ponto.tb_procedimento_percentual_promotor_convenio mc, ponto.tb_paciente p

       WHERE ponto.tb_agenda_exames.procedimento_tuss_id = m.procedimento_tuss_id 

       AND m.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id

       AND p.paciente_id = ponto.tb_agenda_exames.paciente_id
       
       AND mc.promotor = p.indicacao  
 
       AND ponto.tb_agenda_exames.paciente_id is not null

       AND ponto.tb_agenda_exames.valor_promotor is null

       AND ponto.tb_agenda_exames.procedimento_tuss_id is not null

       AND m.ativo = 'true' 
       
       AND mc.ativo = 'true';

-- Dia 21/09/2017
CREATE TABLE ponto.tb_centrocirurgico_percentual_funcao
(
  centrocirurgico_percentual_funcao_id serial NOT NULL,
  funcao character varying(10) NOT NULL,
  valor numeric(10,2),
  valor_base numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_centrocirurgico_percentual_funcao_pkey PRIMARY KEY (centrocirurgico_percentual_funcao_id)
);

INSERT INTO ponto.tb_centrocirurgico_percentual_funcao(funcao)
SELECT codigo FROM ponto.tb_grau_participacao
WHERE codigo NOT IN (
    SELECT funcao FROM ponto.tb_centrocirurgico_percentual_funcao WHERE ativo = 't'
);


CREATE TABLE ponto.tb_centrocirurgico_percentual_outros
(
  centrocirurgico_percentual_outros_id serial NOT NULL,
  leito_enfermaria boolean,
  leito_apartamento boolean,
  mesma_via boolean,
  via_diferente boolean,
  valor numeric(10,2),
  valor_base numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_centrocirurgico_percentual_outros_pkey PRIMARY KEY (centrocirurgico_percentual_funcao_id)
);

ALTER TABLE ponto.tb_centrocirurgico_percentual_outros ADD COLUMN horario_especial boolean DEFAULT false;

-- CRIANDO FUNÇÃO PARA INSERIR APENAS UMA VEZ NA TABELA
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_centrocirurgico_percentual_outros );
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial) VALUES ('t', 'f', 't', 'f', 'f');
	INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial) VALUES ('t', 'f', 'f', 't', 'f');
	INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial) VALUES ('f', 't', 't', 'f', 'f');
	INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial) VALUES ('f', 't', 'f', 't', 'f');
	INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial) VALUES ('f', 'f', 'f', 'f', 't');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

-- Dia 22/09/2017
ALTER TABLE ponto.tb_grau_participacao ALTER column codigo type integer USING codigo::integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ALTER column funcao type integer USING funcao::integer;
ALTER TABLE ponto.tb_centrocirurgico_percentual_funcao ALTER column funcao type integer USING funcao::integer;

UPDATE ponto.tb_procedimento_tuss
   SET qtde=1
 WHERE qtde is null;

ALTER TABLE ponto.tb_paciente_credito ADD COLUMN empresa_id integer;
-- VERSÃO 1.0.00009
INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00009', '1.0.00009');

-- Dia 26/09/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN calendario_layout boolean DEFAULT false;

-- Dia 29/09/2017
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN recomendacao_configuravel boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN botao_ativar_sala boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa_sms ADD COLUMN ip_servidor_sms character varying(50);
-- UPDATE ponto.tb_empresa_sms SET ip_servidor_sms = '200.98.64.240';


-- Dia 03/10/2017

CREATE TABLE ponto.tb_convenio_grupopagamento
(
  convenio_grupopagamento_id serial NOT NULL,
  grupo_pagamento_id integer,
  convenio_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_grupopagamento_pkey PRIMARY KEY (convenio_grupopagamento_id)
);
