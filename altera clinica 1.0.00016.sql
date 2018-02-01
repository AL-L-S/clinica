-- Dia 30/01/2017
ALTER TABLE ponto.tb_empresa_sms ADD COLUMN remetente_sms character varying(50);

-- Internação 

-- Internação na Clínica

 -- Dia 22/11/16
 DROP TABLE ponto.tb_internacao;

CREATE TABLE ponto.tb_internacao
(
  internacao_id serial NOT NULL,
  paciente_id integer,
  codigo character varying(30),
  aih character varying(9),
  prelaudo character varying(30),
  medico_id integer,
  medicoaux_id integer,
  data_internacao timestamp without time zone,
  forma_de_entrada character varying(50),
  estado character varying(100),
  carater_internacao character varying(50),
  justificativa character varying(2000),
  leito integer,
  cid1solicitado character varying(10),
  cid2solicitado character varying(10),
  procedimentorealizado character varying(20),
  cid1realizado character varying(10),
  cid2realizado character varying(10),
  medico_saida integer,
  motivo_saida integer,
  data_saida timestamp without time zone,
  observacao_saida character varying(2000),
  operador_saida integer,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  hospital integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  empresa_id integer,
  hospital_id integer,
  data_solicitacao date,
  reg character varying(50),
  val character varying(50),
  pla character varying(50),
  rx character varying(50),
  acesso character varying(50),
  solicitante character varying(200),
  hospital_transferencia character varying(100),
  procedimentosolicitado integer,
  CONSTRAINT tb_internacao_pkey PRIMARY KEY (internacao_id)
);

ALTER TABLE ponto.tb_internacao DROP COLUMN leito;

ALTER TABLE ponto.tb_internacao ADD COLUMN leito integer;



CREATE TABLE ponto.tb_internacao_motivosaida
(
  internacao_motivosaida_id serial NOT NULL,
  nome character varying(100) NOT NULL,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  hospital integer,
  CONSTRAINT tb_internacao_motivosaida_pkey PRIMARY KEY (internacao_motivosaida_id )
);

ALTER TABLE ponto.tb_internacao ADD COLUMN hospital_transferencia character varying(100);

ALTER TABLE ponto.tb_internacao_leito ADD COLUMN excluido boolean DEFAULT false;


ALTER TABLE ponto.tb_internacao DROP COLUMN procedimentosolicitado;
ALTER TABLE ponto.tb_internacao ADD COLUMN procedimentosolicitado integer;


 DROP TABLE ponto.tb_internacao_prescricao;

CREATE TABLE ponto.tb_internacao_prescricao
(
  internacao_prescricao_id serial NOT NULL,
  medicamento_id integer,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  aprasamento integer,
  dias integer,
  internacao_id integer,
  qtde_volta integer,
  ativo boolean DEFAULT true,
  confirmado boolean DEFAULT false,
  qtde_ministrada integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  qtde_original integer,
  data_exclusao timestamp without time zone,
  operador_exclusao integer,
  CONSTRAINT tb_internacao_prescricao_pkey PRIMARY KEY (internacao_prescricao_id)
);

CREATE TABLE ponto.tb_internacao_prescricao_medicamento
(
  internacao_prescricao_medicamento_id serial NOT NULL,
  internacao_prescricao_id integer,
  internacao_id integer,
  medicamento_id integer,
  aprasamento integer,
  dias integer,
  volume integer,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  ativo boolean NOT NULL DEFAULT true,
  CONSTRAINT tb_internacao_prescricao_medicamento_pkey PRIMARY KEY (internacao_prescricao_medicamento_id )
);

ALTER TABLE ponto.tb_internacao_prescricao_medicamento DROP COLUMN volume;

ALTER TABLE ponto.tb_internacao_enfermaria ADD COLUMN aprasamento_enfermagem integer;




ALTER TABLE ponto.tb_internacao ALTER COLUMN leito TYPE character varying(50);

 -- Dia 23/11/16

ALTER TABLE ponto.tb_internacao ALTER COLUMN motivo_saida TYPE character varying(50);


ALTER TABLE ponto.tb_empresa ADD COLUMN internacao boolean DEFAULT false;



CREATE TABLE ponto.tb_internacao_evolucao
(
  internacao_evolucao_id serial NOT NULL,
  internacao_id integer,
  diagnostico character varying(500),
  conduta character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  
  CONSTRAINT tb_internacao_evolucao_pkey PRIMARY KEY (internacao_evolucao_id )
);


-- Dia 29/11/16

ALTER TABLE ponto.tb_paciente ADD COLUMN situacao character varying(20);



CREATE TABLE ponto.tb_paciente_contrato
(
  paciente_contrato_id serial NOT NULL,
  paciente_id integer,
  plano_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  
  CONSTRAINT tb_paciente_contrato_pkey PRIMARY KEY (paciente_contrato_id )
);


-- 12/12/2017
CREATE TABLE ponto.tb_internacao_evolucao
(
  internacao_evolucao_id serial NOT NULL,
  internacao_id integer,
  diagnostico character varying(500),
  conduta character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_internacao_evolucao_pkey PRIMARY KEY (internacao_evolucao_id)
);

--13/12/2017

ALTER TABLE ponto.tb_estoque_saida ADD COLUMN ambulatorio_gasto_sala_id integer;
ALTER TABLE ponto.tb_estoque_saldo ADD COLUMN ambulatorio_gasto_sala_id integer;

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN transferencia boolean DEFAULT false;
ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN armazem_transferencia integer;

ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN saida_id_transferencia text;
ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN lote character varying(30);

ALTER TABLE ponto.tb_estoque_fornecedor add column  credor_devedor_id integer;
ALTER TABLE ponto.tb_estoque_entrada add column inventario boolean DEFAULT false;

ALTER TABLE ponto.tb_estoque_produto ADD COLUMN procedimento_id integer;
ALTER TABLE ponto.tb_estoque_cliente ADD COLUMN sala_id integer;
ALTER TABLE ponto.tb_estoque_fornecedor add column  credor_devedor_id integer;

--16/12/2017
ALTER TABLE ponto.tb_farmacia_saida ADD COLUMN internacao_id integer;

ALTER TABLE ponto.tb_farmacia_saida ADD COLUMN internacao_prescricao_id integer;


--18/12/2017

ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN qtde_volta integer;
ALTER TABLE ponto.tb_internacao_prescricao  ADD COLUMN ativo boolean DEFAULT true;
ALTER TABLE ponto.tb_internacao_prescricao  ADD COLUMN confirmado boolean DEFAULT false;
ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN qtde_ministrada integer;

ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN data_atualizacao timestamp without time zone;
ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN operador_atualizacao integer;
ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN qtde_original integer;

ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN data_exclusao timestamp without time zone;
ALTER TABLE ponto.tb_internacao_prescricao ADD COLUMN operador_exclusao integer;


-- Centro cirurgico de novo 

--19/01/2018

CREATE TABLE ponto.tb_solicitacao_cirurgia
(
  solicitacao_cirurgia_id serial NOT NULL,
  internacao_id integer,
  procedimento_id character varying(20),
  data_solicitacao timestamp without time zone,
  operador_solicitacao integer,
  data_autorizacao timestamp without time zone,
  operador_autorizacao integer,
  excluido boolean NOT NULL DEFAULT false,
  ativo boolean NOT NULL DEFAULT true,
  data_prevista timestamp without time zone,
  data_realizou timestamp without time zone,
  medico_agendado integer,
  medico_relizou integer,
  sala_agendada integer,
  sala_realizou integer,
  

  CONSTRAINT tb_solicitacao_cirurgia_pkey PRIMARY KEY (solicitacao_cirurgia_id )
);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN autorizado boolean DEFAULT false;


-- Dia 26/12/2016  Correcao no Centro Cirurgico

DROP TABLE IF EXISTS ponto.tb_solicitacao_cirurgia;

CREATE TABLE IF NOT EXISTS ponto.tb_solicitacao_cirurgia
(
  solicitacao_cirurgia_id serial NOT NULL,
  internacao_id integer,
  procedimento_id integer,
  data_prevista date,
  data_realizou date,
  medico_agendado integer,
  medico_relizou integer,
  sala_agendada integer,
  sala_realizou integer,
  paciente_id integer,
  autorizado boolean DEFAULT false,
  excluido boolean NOT NULL DEFAULT false,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  

  CONSTRAINT tb_solicitacao_cirurgia_pkey PRIMARY KEY (solicitacao_cirurgia_id )
);

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN medico_solicitante integer;



-- Dia 27/12/2016 


CREATE TABLE IF NOT EXISTS ponto.tb_solicitacao_cirurgia_orcamento
(
  solicitacao_cirurgia_orcamento_id serial NOT NULL,
  convenio_id integer,
  operador_responsavel integer,
  data_solicitacao timestamp without time zone,
  observacao character varying(1000),
  solicitacao_cirurgia_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  

  CONSTRAINT tb_solicitacao_cirurgia_orcamento_pkey PRIMARY KEY (solicitacao_cirurgia_orcamento_id)
);



ALTER TABLE ponto.tb_solicitacao_cirurgia DROP COLUMN procedimento_id;


CREATE TABLE ponto.tb_solicitacao_cirurgia_procedimento
(
  solicitacao_cirurgia_procedimento_id serial NOT NULL,
  solicitacao_cirurgia_id integer,
  procedimento_tuss_id integer,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  
  CONSTRAINT tb_solicitacao_cirurgia_procedimento_pkey PRIMARY KEY (solicitacao_cirurgia_procedimento_id)
);

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN convenio integer;

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN situacao character varying;
ALTER TABLE ponto.tb_solicitacao_cirurgia ALTER COLUMN situacao SET DEFAULT 'ABERTA'::character varying;

-- Dia 17/01/2017
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN descricao_procedimento character varying(600);

CREATE TABLE ponto.tb_solicitacao_cirurgia_equipe
(
  cirurgia_equipe_id serial NOT NULL,
  funcao integer,
  operador_responsavel integer,
  solicitacao_cirurgia_id integer,
  ativo boolean DEFAULT true,
  CONSTRAINT solicitacao_cirurgia_equipe_pkey PRIMARY KEY (cirurgia_equipe_id )
);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN situacao character varying;
ALTER TABLE ponto.tb_solicitacao_cirurgia ALTER COLUMN situacao SET DEFAULT 'ABERTA'::character varying;


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN convenio integer;



CREATE TABLE ponto.tb_funcoes_cirurgia
(
  funcao_cirurgia_id serial NOT NULL,
  nome character varying,
  CONSTRAINT funcao_cirurgia_pkey PRIMARY KEY (funcao_cirurgia_id )
);

ALTER TABLE ponto.tb_solicitacao_cirurgia_orcamento ADD COLUMN grau_participacao integer;

INSERT INTO ponto.tb_funcoes_cirurgia (funcao_cirurgia_id , nome)
VALUES(1 , 'CIRURGIAO');
INSERT INTO ponto.tb_funcoes_cirurgia (funcao_cirurgia_id , nome)
VALUES(2 , 'ANESTESISTA');
INSERT INTO ponto.tb_funcoes_cirurgia (funcao_cirurgia_id , nome)
VALUES(3 , 'AUXILIAR 1');


ALTER TABLE ponto.tb_solicitacao_cirurgia_orcamento ADD COLUMN procedimento_tuss_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia_orcamento ADD COLUMN valor numeric(10,2);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN orcamento boolean NOT NULL DEFAULT true;

DROP TABLE ponto.tb_solicitacao_cirurgia_equipe;

CREATE TABLE ponto.tb_equipe_cirurgia
(
  equipe_cirurgia_id serial NOT NULL,
  nome character varying(500),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_equipe_cirurgia_pkey PRIMARY KEY (equipe_cirurgia_id)
);

-- NAO ESTA FUNCIONAL AINDA
CREATE TABLE ponto.tb_equipe_cirurgia_operadores
(
  equipe_cirurgia_operadores_id serial NOT NULL,
  funcao integer,
  operador_responsavel integer,
  solicitacao_cirurgia_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_equipe_cirurgia_operadores_pkey PRIMARY KEY (equipe_cirurgia_operadores_id)
);


CREATE TABLE ponto.tb_hospital
(
  hospital_id serial NOT NULL,
  razao_social character varying(200),
  nome character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo_logradouro_id integer,
  caixa boolean DEFAULT false,
  cnpjxml character varying(20),
  razao_socialxml character varying(200),
  cpfxml character varying(11),
  registroans character varying(11),
  dinheiro boolean DEFAULT false,
  producaomedicadinheiro boolean DEFAULT false,
  cnes character varying(20),
  tipo_xml_id integer,
  CONSTRAINT tb_hospital_pkey PRIMARY KEY (hospital_id )
);

-- Dia 25/02/2017
ALTER TABLE ponto.tb_equipe_cirurgia_operadores DROP COLUMN solicitacao_cirurgia_id;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores ADD COLUMN equipe_cirurgia_id integer;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores DROP COLUMN funcao;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores ADD COLUMN funcao character varying(10);

DROP TABLE IF EXISTS ponto.tb_funcoes_cirurgia;
CREATE TABLE ponto.tb_grau_participacao
(
  grau_participacao_id serial NOT NULL,
  codigo character varying(5),
  descricao character varying(100),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_grau_participacao_pkey PRIMARY KEY (grau_participacao_id )
);
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN via character varying(100);
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN leito character varying(100);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN horario_especial boolean DEFAULT false;

-- Dia 01/03/2017
ALTER TABLE ponto.tb_equipe_cirurgia_operadores DROP COLUMN IF EXISTS funcao;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores ADD COLUMN funcao integer;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores DROP COLUMN IF EXISTS valor;

-- Dia 02/03/2017
CREATE TABLE ponto.tb_agenda_exame_equipe
(
  agenda_exame_equipe_id serial NOT NULL,
  operador_responsavel integer,
  agenda_exames_id integer,
  funcao character varying(10),
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_agenda_exame_equipe_pkey PRIMARY KEY (agenda_exame_equipe_id)
);

ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN equipe boolean;
ALTER TABLE ponto.tb_ambulatorio_guia ALTER COLUMN equipe SET DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN equipe_id integer;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores ADD COLUMN solicitacao_cirurgia_id integer;

ALTER TABLE ponto.tb_convenio ADD COLUMN carteira_obrigatoria boolean DEFAULT false;

-- GRAU DE PARTICIPAÇÃO CIRURGICA

-- CRIANDO FUNÇÃO PARA INSERIR APENAS UMA VEZ NA TABELA
CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_grau_participacao );
    IF resultado = 0 THEN 
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('0','Cirurgião');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('1','Primeiro Auxiliar');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('2','Segundo Auxiliar');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('3','Terceiro Auxiliar');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('4','Quarto Auxiliar');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('5','Instrumentador');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('6','Anestesista');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('7','Auxiliar de Anestesista');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('8','Consultor');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('9','Perfusionista');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('10','Pediatra na sala de parto');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('11','Auxiliar SADT');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('12','Clínico');
        INSERT INTO ponto.tb_grau_participacao(codigo, descricao) VALUES ('13','Intensivista');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();






CREATE TABLE ponto.tb_solicitacao_cirurgia
(
  solicitacao_cirurgia_id serial NOT NULL,
  internacao_id integer,
  procedimento_id character varying(20),
  data_solicitacao timestamp without time zone,
  operador_solicitacao integer,
  data_autorizacao timestamp without time zone,
  operador_autorizacao integer,
  excluido boolean NOT NULL DEFAULT false,
  ativo boolean NOT NULL DEFAULT true,
  data_prevista timestamp without time zone,
  data_realizou timestamp without time zone,
  medico_agendado integer,
  medico_relizou integer,
  sala_agendada integer,
  sala_realizou integer,
  

  CONSTRAINT tb_solicitacao_cirurgia_pkey PRIMARY KEY (solicitacao_cirurgia_id )
);


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN autorizado boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa add column centrocirurgico boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa add column relatoriorm boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN cirurgias character varying(40000);

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
  CONSTRAINT tb_centrocirurgico_percentual_outros_pkey PRIMARY KEY (centrocirurgico_percentual_outros_id)
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


ALTER TABLE ponto.tb_grau_participacao ALTER column codigo type integer USING codigo::integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ALTER column funcao type integer USING funcao::integer;
ALTER TABLE ponto.tb_centrocirurgico_percentual_funcao ALTER column funcao type integer USING funcao::integer;

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
  CONSTRAINT tb_centrocirurgico_percentual_outros_pkey PRIMARY KEY (centrocirurgico_percentual_outros_id)
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


ALTER TABLE ponto.tb_grau_participacao ALTER column codigo type integer USING codigo::integer;
ALTER TABLE ponto.tb_agenda_exame_equipe ALTER column funcao type integer USING funcao::integer;
ALTER TABLE ponto.tb_centrocirurgico_percentual_funcao ALTER column funcao type integer USING funcao::integer;


ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN hospital_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN guia_id integer;


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



ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN desconto numeric(10,2);

ALTER TABLE ponto.tb_hospital ADD COLUMN valor_taxa numeric(10,2);



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


ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN agrupador boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN valor_pacote_diferenciado boolean DEFAULT false;


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
ALTER TABLE ponto.tb_agrupador_procedimento_nome ADD COLUMN convenio_id integer


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'CIRURGICO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome)
        VALUES ('CIRURGICO', 'CIRURGICO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


ALTER TABLE ponto.tb_ambulatorio_grupo ADD COLUMN tipo character varying(40);

UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'ESPECIALIDADE' WHERE nome = 'AUDIOMETRIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'CONSULTA' WHERE nome = 'CONSULTA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'DENSITOMETRIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'ECOCARDIOGRAMA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'ELETROCARDIOGRAMA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'ELETROENCEFALOGRAMA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'ESPIROMETRIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'ESPECIALIDADE' WHERE nome = 'FISIOTERAPIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'LABORATORIAL';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'MAMOGRAFIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'TOMOGRAFIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'ENDOSCOPIA';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'RM';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'RX';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'EXAME' WHERE nome = 'US';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'MEDICAMENTO' WHERE nome = 'MEDICAMENTO';
UPDATE ponto.tb_ambulatorio_grupo  SET tipo= 'CIRURGICO' WHERE nome = 'CIRURGICO';


ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_medico numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_medico boolean;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_faturar date;

UPDATE ponto.tb_agenda_exames
SET data_faturar = data
WHERE data_faturar is null;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_antiga date;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_antiga timestamp without time zone;

--22/01/2018
ALTER TABLE ponto.tb_agenda_exame_equipe ADD COLUMN guia_id integer;

--23/01/2018
ALTER TABLE ponto.tb_paciente ADD COLUMN leito text;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN hora_prevista time without time zone;
ALTER TABLE ponto.tb_solicitacao_cirurgia_procedimento ADD COLUMN agenda_exames_id integer;

ALTER TABLE ponto.tb_centrocirurgico_percentual_funcao ADD COLUMN operador_percentual_padrao integer ;
ALTER TABLE ponto.tb_centrocirurgico_percentual_funcao ADD COLUMN data_percentual_padrao timestamp without time zone;

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN encaminhado_paciente boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN encaminhado_convenio boolean DEFAULT false;
ALTER TABLE ponto.tb_solicitacao_orcamento ADD COLUMN guia_id integer;
ALTER TABLE ponto.tb_solicitacao_orcamento_equipe ADD COLUMN guia_id integer;

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN situacao_convenio text;



CREATE TABLE ponto.tb_solicitacao_orcamento_convenio
(
  solicitacao_orcamento_convenio_id serial NOT NULL,
  solicitacao_cirurgia_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  guia_id integer,
  CONSTRAINT tb_solicitacao_orcamento_convenio_pkey PRIMARY KEY (solicitacao_orcamento_convenio_id)
);


CREATE TABLE ponto.tb_solicitacao_orcamento_convenio_equipe
(
  solicitacao_orcamento_convenio_equipe_id serial,
  solicitacao_orcamento_convenio_id integer,
  solicitacao_cirurgia_procedimento_id integer,
  operador_responsavel integer,
  funcao integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_solicitacao_orcamento_convenio_equipe_pkey PRIMARY KEY (solicitacao_orcamento_convenio_equipe_id)
);

-- FARMACIA 


CREATE TABLE ponto.tb_farmacia
(
  farmacia_id serial NOT NULL,
  entrada_id integer,
  saida_id integer,
  fornecedor_id integer,
  produto_id integer,
  armazem_id integer,
  lote character varying(50),
  validade date,
  valor_compra numeric(10,2),
  valor_venda numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo character varying(20),
  nota_fiscal character varying(30),
  CONSTRAINT tb_farmacia_pkey PRIMARY KEY (farmacia_id)
);

CREATE TABLE ponto.tb_farmacia_armazem
(
  farmacia_armazem_id serial NOT NULL,
  descricao character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_armazem_pkey PRIMARY KEY (farmacia_armazem_id)
);


CREATE TABLE ponto.tb_farmacia_classe
(
  farmacia_classe_id serial NOT NULL,
  descricao character varying(200),
  tipo_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_classe_pkey PRIMARY KEY (farmacia_classe_id)
);


CREATE TABLE ponto.tb_farmacia_cliente
(
  farmacia_cliente_id serial NOT NULL,
  nome character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  menu_id integer,
  CONSTRAINT tb_farmacia_cliente_pkey PRIMARY KEY (farmacia_cliente_id)
);


CREATE TABLE ponto.tb_farmacia_entrada
(
  farmacia_entrada_id serial NOT NULL,
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
  CONSTRAINT tb_farmacia_entrada_pkey PRIMARY KEY (farmacia_entrada_id)
);


CREATE TABLE ponto.tb_farmacia_fornecedor
(
  farmacia_fornecedor_id serial NOT NULL,
  razao_social character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo_logradouro_id integer,
  fantasia character varying(200),
  credor_devedor_id integer,
  CONSTRAINT tb_farmacia_fornecedor_pkey PRIMARY KEY (farmacia_fornecedor_id)
);


CREATE TABLE ponto.tb_farmacia_fracionamento_entrada
(
  farmacia_fracionamento_entrada_id serial,
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
  CONSTRAINT tb_farmacia_fracionamento_pkey PRIMARY KEY (farmacia_fracionamento_entrada_id)
);


CREATE TABLE ponto.tb_farmacia_fracionamento_saida
(
  farmacia_fracionamento_saida_id serial,
  produto_id integer,
  fornecedor_id integer,
  armazem_id integer,
  valor_venda numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  nota_fiscal character varying(30),
  validade date,
  exames_id integer,
  farmacia_entrada_id integer,
  farmacia_solicitacao_itens_id integer,
  solicitacao_cliente_id integer,
  CONSTRAINT tb_farmacia_fracionamento_saida_pkey PRIMARY KEY (farmacia_fracionamento_saida_id)
);



CREATE TABLE ponto.tb_farmacia_fracionamento_saldo
(
  farmacia_fracionamento_saldo_id serial,
  farmacia_fracionamento_entrada_id integer,
  farmacia_fracionamento_saida_id integer,
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
  CONSTRAINT tb_farmacia_fracionamento_saldo_pkey PRIMARY KEY (farmacia_fracionamento_saldo_id)
);

CREATE TABLE ponto.tb_farmacia_menu_produtos
(
  farmacia_menu_produtos_id serial NOT NULL,
  menu_id integer,
  produto integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_menu_produtos_pkey PRIMARY KEY (farmacia_menu_produtos_id)
);


CREATE TABLE ponto.tb_farmacia_produto
(
  farmacia_produto_id serial NOT NULL,
  descricao character varying(200),
  unidade_id integer,
  valor_compra numeric(10,2),
  valor_venda numeric(10,2),
  sub_classe_id integer,
  codigo_de_barras character varying(30),
  farmacia_minimo numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  quantidade_unitaria numeric,
  CONSTRAINT tb_farmacia_produto_pkey PRIMARY KEY (farmacia_produto_id)
);



CREATE TABLE ponto.tb_farmacia_saida
(
  farmacia_saida_id serial NOT NULL,
  produto_id integer,
  fornecedor_id integer,
  armazem_id integer,
  valor_venda numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  nota_fiscal character varying(30),
  validade date,
  exames_id integer,
  farmacia_entrada_id integer,
  farmacia_solicitacao_itens_id integer,
  solicitacao_cliente_id integer,
  internacao_id integer,
  internacao_prescricao_id integer,
  CONSTRAINT tb_farmacia_saida_pkey PRIMARY KEY (farmacia_saida_id)
);


CREATE TABLE ponto.tb_farmacia_saldo
(
  farmacia_saldo_id serial NOT NULL,
  farmacia_entrada_id integer,
  farmacia_saida_id integer,
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
  CONSTRAINT tb_farmacia_saldo_pkey PRIMARY KEY (farmacia_saldo_id)
);


CREATE TABLE ponto.tb_farmacia_solicitacao
(
  farmacia_solicitacao_id serial NOT NULL,
  produto_id integer,
  fornecedor_id integer,
  armazem_id integer,
  valor_venda numeric(10,2),
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  solicitacao_cliente_id integer,
  situacao character varying(30) DEFAULT 'PENDENTE'::character varying,
  CONSTRAINT tb_farmacia_solicitacao_pkey PRIMARY KEY (farmacia_solicitacao_id)
);


CREATE TABLE ponto.tb_farmacia_solicitacao_cliente
(
  farmacia_solicitacao_setor_id serial,
  cliente_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  situacao character varying DEFAULT 'ABERTA'::character varying,
  data_liberacao timestamp without time zone,
  operador_liberacao integer,
  data_fechamento timestamp without time zone,
  operador_fechamento integer,
  CONSTRAINT tb_farmacia_solicitacao_setor_pkey PRIMARY KEY (farmacia_solicitacao_setor_id)
);

CREATE TABLE ponto.tb_farmacia_solicitacao_itens
(
  farmacia_solicitacao_itens_id serial NOT NULL,
  produto_id integer,
  quantidade numeric,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  solicitacao_cliente_id integer,
  situacao character varying(30) DEFAULT 'PENDENTE'::character varying,
  exame_id integer,
  CONSTRAINT farmacia_solicitacao_itens_pkey PRIMARY KEY (farmacia_solicitacao_itens_id)
);

CREATE TABLE ponto.tb_farmacia_sub_classe
(
  farmacia_sub_classe_id serial NOT NULL,
  descricao character varying(200),
  classe_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_sub_classe_pkey PRIMARY KEY (farmacia_sub_classe_id)
);


CREATE TABLE ponto.tb_farmacia_tipo
(
  farmacia_tipo_id serial NOT NULL,
  descricao character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_tipo_pkey PRIMARY KEY (farmacia_tipo_id)
);


CREATE TABLE ponto.tb_farmacia_unidade
(
  farmacia_unidade_id serial NOT NULL,
  descricao character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_farmacia_unidade_pkey PRIMARY KEY (farmacia_unidade_id)
);

ALTER TABLE ponto.tb_empresa ADD COLUMN farmacia boolean DEFAULT true;


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_ambulatorio_grupo WHERE nome = 'CIRURGICO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
        VALUES ('CIRURGICO', 'CIRURGICO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

ALTER TABLE ponto.tb_operador ADD COLUMN cor_mapa text;
