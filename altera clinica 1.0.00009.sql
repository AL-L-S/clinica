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

-- 05/10/2017

CREATE TABLE ponto.tb_operador_grupo
(
  operador_grupo_id serial NOT NULL,
  nome character varying(250),
  operador_id integer,
  empresa_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_operador_grupo_pkey PRIMARY KEY (operador_grupo_id)
);

CREATE TABLE ponto.tb_operador_grupo_medico
(
  operador_grupo_medico_id serial NOT NULL,
  operador_id integer,
  operador_grupo_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_operador_grupo_medicos_pkey PRIMARY KEY (operador_grupo_medico_id)
);


-- 06/10/2017

CREATE TABLE ponto.tb_agenda_exames_valor
(

  agenda_exames_valor_id serial NOT NULL,
  agenda_exames_id integer,
  procedimento_convenio_id integer,
  valor_total numeric(10,2),
  valor numeric(10,2),
  forma_pagamento integer,
  valor1 numeric(10,2) DEFAULT 0,
  forma_pagamento2 integer,
  valor2 numeric(10,2) DEFAULT 0,
  forma_pagamento3 integer,
  valor3 numeric(10,2) DEFAULT 0,
  forma_pagamento4 integer,
  valor4 numeric(10,2) DEFAULT 0,
  operador_faturamento integer,
  operador_cadastro integer,
  ata_cadastro timestamp without time zone,
  data_atualizacao timestamp without time zone,
  CONSTRAINT tb_agenda_exames_valor_pkey PRIMARY KEY (agenda_exames_valor_id)
);

CREATE TABLE ponto.tb_procedimento_convenio_sessao
(
  procedimento_convenio_sessao_id serial NOT NULL,
  procedimento_convenio_id integer,
  valor_sessao numeric(10,2),
  sessao integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  empresa_id integer,
  CONSTRAINT tb_procedimento_convenio_sessao_pkey PRIMARY KEY (procedimento_convenio_sessao_id)
);

-- 08/10/2017

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN transferencia boolean DEFAULT false;
ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN armazem_transferencia integer;
ALTER TABLE ponto.tb_procedimento_percentual_medico_convenio ADD COLUMN revisor boolean DEFAULT false;

-- 09/10/2017

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN valor_revisor numeric(10,2);
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN percentual_revisor boolean DEFAULT false;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_revisor numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_revisor boolean DEFAULT false;

-- 11/10/2017
ALTER TABLE ponto.tb_ambulatorio_guia ALTER COLUMN declaracao TYPE text;

-- VERSÃO 1.0.00009
INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00009', '1.0.00009');



-- 16/10/2017
UPDATE ponto.tb_agenda_exames
   SET 
       valor_revisor= mc.valor, percentual_revisor= mc.percentual


       
FROM ponto.tb_procedimento_percentual_medico m , ponto.tb_procedimento_percentual_medico_convenio mc, ponto.tb_exames e, ponto.tb_ambulatorio_laudo al , ponto.tb_procedimento_convenio pc, ponto.tb_procedimento_tuss pt

	WHERE ponto.tb_agenda_exames.procedimento_tuss_id = m.procedimento_tuss_id 

	AND m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
        AND e.agenda_exames_id = ponto.tb_agenda_exames.agenda_exames_id
        AND e.agenda_exames_id = ponto.tb_agenda_exames.agenda_exames_id
        AND e.exames_id = al.exame_id
	AND pc.procedimento_convenio_id = ponto.tb_agenda_exames.procedimento_tuss_id
	AND pc.procedimento_tuss_id = pt.procedimento_tuss_id
	AND m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
       
        AND mc.medico = al.medico_parecer2  
 
       AND ponto.tb_agenda_exames.paciente_id is not null

       AND ponto.tb_agenda_exames.procedimento_tuss_id is not null  

       AND m.ativo = 'true' 
       
       AND mc.ativo = 'true'
       AND mc.revisor = 'true'
       AND pt.grupo = 'RM';


---------------------------------------------------------------------------------------------------------------------

UPDATE ponto.tb_agenda_exames
   SET 
       valor_medico= mc.valor, percentual_medico= mc.percentual


       
FROM ponto.tb_procedimento_percentual_medico m , ponto.tb_procedimento_percentual_medico_convenio mc, ponto.tb_procedimento_convenio pc, ponto.tb_procedimento_tuss pt

	WHERE ponto.tb_agenda_exames.procedimento_tuss_id = m.procedimento_tuss_id 
        AND pc.procedimento_convenio_id = ponto.tb_agenda_exames.procedimento_tuss_id
	AND pc.procedimento_tuss_id = pt.procedimento_tuss_id
	AND m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
       
        AND mc.medico = ponto.tb_agenda_exames.medico_agenda  
 
       AND ponto.tb_agenda_exames.paciente_id is not null

       AND ponto.tb_agenda_exames.procedimento_tuss_id is not null  

       AND m.ativo = 'true' 
       
       AND mc.ativo = 'true'
       AND pt.grupo = 'RM';






-- Dia 19/10/2017
ALTER TABLE ponto.tb_convenio ADD COLUMN convenio_associacao integer;

-- Dia 20/10/2017
ALTER TABLE ponto.tb_convenio DROP COLUMN convenio_associacao;
ALTER TABLE ponto.tb_convenio ADD COLUMN associado boolean DEFAULT false;
ALTER TABLE ponto.tb_convenio ADD COLUMN associacao_percentual numeric(10,4);
ALTER TABLE ponto.tb_convenio ADD COLUMN associacao_convenio_id integer;
ALTER TABLE ponto.tb_convenio ADD COLUMN data_percentual_atualizacao timestamp without time zone;
ALTER TABLE ponto.tb_convenio ADD COLUMN operador_percentual_atualizacao integer;



ALTER TABLE ponto.tb_convenio ADD COLUMN fidelidade_parceiro_id integer;
ALTER TABLE ponto.tb_convenio ADD COLUMN fidelidade_endereco_ip text;
-- Dia 23/10/2017
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN forma_pagamento integer;


-- Dia 27/10/2017
ALTER TABLE ponto.tb_ambulatorio_atendimentos_cancelamento ADD COLUMN lancou_credito boolean DEFAULT false;

ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento1 integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN valor1 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento2 integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN valor2 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento3 integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN valor3 numeric(10,2) DEFAULT 0;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento4 integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN valor4 numeric(10,2) DEFAULT 0;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN dias_retorno integer;

-- Dia 28/10/2017
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN encaminhado boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN medico_encaminhamento_id integer;

-- Dia 01/11/2017
ALTER TABLE ponto.tb_empresa_impressao_cabecalho ADD COLUMN timbrado text;
ALTER TABLE ponto.tb_empresa_impressao_cabecalho ADD COLUMN timbrado_tamanho text;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'ODONTOLOGIA');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('ODONTOLOGIA', 'ESPECIALIDADE');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();



-- 16/10/2017
---------------------- OFTAMOLOGIA -----------------------------

-- APARENTEMENTE O GIT EXCLUIU CERTAS COISAS DESSE ARQUIVO QUANDO CLICARAM EM REVERTER MODIFICAÇÕES
-- ADICIONANDO ABAIXO AS COLUNAS
UPDATE ponto.tb_operador
   SET perfil_id=1
 WHERE operador_id = 1;


CREATE TABLE ponto.tb_oftamologia_od_esferico
(
  od_esferico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_od_esferico_pkey PRIMARY KEY (od_esferico_id)
);

CREATE TABLE ponto.tb_oftamologia_oe_esferico
(
  oe_esferico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_oe_esferico_pkey PRIMARY KEY (oe_esferico_id)
);

CREATE TABLE ponto.tb_oftamologia_od_cilindrico
(
  od_cilindrico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_od_cilindrico_pkey PRIMARY KEY (od_cilindrico_id)
);

CREATE TABLE ponto.tb_oftamologia_oe_cilindrico
(
  oe_cilindrico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_oe_cilindrico_pkey PRIMARY KEY (oe_cilindrico_id)
);


CREATE TABLE ponto.tb_oftamologia_oe_eixo
(
  oe_eixo_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_oe_eixo_pkey PRIMARY KEY (oe_eixo_id)
);

CREATE TABLE ponto.tb_oftamologia_oe_av
(
  oe_av_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_oe_av_pkey PRIMARY KEY (oe_av_id)
);

CREATE TABLE ponto.tb_oftamologia_od_eixo
(
  od_eixo_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_od_eixo_pkey PRIMARY KEY (od_eixo_id)
);

CREATE TABLE ponto.tb_oftamologia_od_av
(
  od_av_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_od_av_pkey PRIMARY KEY (od_av_id)
);

CREATE TABLE ponto.tb_oftamologia_ad_esferico
(
  ad_esferico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_ad_esferico_pkey PRIMARY KEY (ad_esferico_id)
);

CREATE TABLE ponto.tb_oftamologia_ad_cilindrico
(
  ad_cilindrico_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_ad_cilindrico_pkey PRIMARY KEY (ad_cilindrico_id)
);

CREATE TABLE ponto.tb_oftamologia_od_acuidade
(
  od_acuidade_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_od_acuidade_pkey PRIMARY KEY (od_acuidade_id)
);

CREATE TABLE ponto.tb_oftamologia_oe_acuidade
(
  oe_acuidade_id serial NOT NULL,
  nome character varying(20),
  numero numeric (10,2),
  ativo boolean DEFAULT TRUE,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_oftamologia_oe_acuidade_pkey PRIMARY KEY (oe_acuidade_id)
);


ALTER TABLE ponto.tb_agenda_exames_valor ADD COLUMN data_cadastro timestamp without time zone;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN inspecao_geral text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN motilidade_ocular  text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN biomicroscopia text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN mapeamento_retinas  text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN conduta  text;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN acuidade_od text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN acuidade_oe text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN pressao_ocular_oe numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN pressao_ocular_od numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN pressao_ocular_hora time without time zone;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN refracao_retinoscopia text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN dinamica_estatica text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN carregar_refrator boolean default false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN carregar_oculos boolean default false;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_od_esferico text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_oe_esferico text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_od_cilindrico text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_oe_cilindrico text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_oe_eixo text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_oe_av text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_od_eixo text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_od_av text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_ad_esferico text;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN oftamologia_ad_cilindrico text;

ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN oftamologia boolean DEFAULT false;


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN cancelar_sala_espera boolean DEFAULT true;

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN saida_id_transferencia text;

ALTER TABLE ponto.tb_operador ADD COLUMN cabecalho text;
ALTER TABLE ponto.tb_operador ADD COLUMN rodape text;
ALTER TABLE ponto.tb_operador ADD COLUMN timbrado text;
ALTER TABLE ponto.tb_operador ADD COLUMN timbrado_tamanho text;

-- Dia 03/11/2017

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN retorno_dias integer;
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN associacao_procedimento_tuss_id integer;

CREATE TABLE ponto.tb_convenio_secudario_associacao
(
  convenio_secudario_associacao_id serial NOT NULL,
  convenio_secundario_id integer,
  grupo character varying(50),
  convenio_primario_id integer,
  valor_percentual numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_secudario_associacao_pkey PRIMARY KEY (convenio_secudario_associacao_id)
);

-- Dia 07/11/2017

CREATE TABLE ponto.tb_odontograma
(
  odontograma_id serial NOT NULL,
  paciente_id integer,
  ambulatorio_laudo_id integer,
  observacao text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_odontograma_pkey PRIMARY KEY (odontograma_id)
);

CREATE TABLE ponto.tb_odontograma_dente
(
  odontograma_dente_id serial NOT NULL,
  odontograma_id integer,
  numero_dente integer,
  observacao text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_odontograma_dente_pkey PRIMARY KEY (odontograma_dente_id)
);

CREATE TABLE ponto.tb_odontograma_dente_procedimento
(
  odontograma_dente_procedimento_id serial NOT NULL,
  odontograma_dente_id integer,
  procedimento_convenio_id integer,
  face character varying(5),
  observacao text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_odontograma_dente_procedimento_pkey PRIMARY KEY (odontograma_dente_procedimento_id)
);