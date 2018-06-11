-- atualiza 08/09/2015

CREATE TABLE ponto.tb_ambulatorio_modelo_receita
(
  ambulatorio_modelo_receita_id serial NOT NULL,
  medico_id integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_modelo_receita_pkey PRIMARY KEY (ambulatorio_modelo_receita_id)
);

CREATE TABLE ponto.tb_ambulatorio_modelo_atestado
(
  ambulatorio_modelo_atestado_id serial NOT NULL,
  medico_id integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_modelo_atestado_pkey PRIMARY KEY (ambulatorio_modelo_atestado_id)
);

CREATE TABLE ponto.tb_ambulatorio_atestado
(
  ambulatorio_atestado_id integer NOT NULL DEFAULT nextval('ponto.tb_ambulatorio_receituario_es_ambulatorio_receituario_espec_seq'::regclass),
  paciente_id integer,
  procedimento_tuss_id integer,
  texto character varying(3000),
  observacao character varying(3000),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  medico_parecer1 integer,
  laudo_id integer,
  tipo character varying(50),
  CONSTRAINT tb_ambulatorio_atestado_pkey PRIMARY KEY (ambulatorio_atestado_id )
);

CREATE TABLE ponto.tb_ambulatorio_grupo
(
  ambulatorio_grupo_id serial,
  nome character varying(40),
  CONSTRAINT tb_ambulatorio_grupo_pkey PRIMARY KEY (ambulatorio_grupo_id )
);

INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('AUDIOMETRIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('CONSULTA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('DENSITOMETRIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('ECOCARDIOGRAMA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('ELETROCARDIOGRAMA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('ELETROENCEFALOGRAMA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('ESPIROMETRIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('FISIOTERAPIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('LABORATORIAL');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('MEDICAMENTO');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('MAMOGRAFIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('TOMOGRAFIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('ENDOSCOPIA');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('RM');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('RX');
INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('US');


CREATE TABLE ponto.tb_ambulatorio_nome_endoscopia
(
  ambulatorio_nome_endoscopia_id serial,
  nome character varying(40),
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_nome_endoscopia_pkey PRIMARY KEY (ambulatorio_nome_endoscopia_id )
);


-- atualiza 17/09/2015

CREATE TABLE ponto.tb_paciente_indicacao
(
  paciente_indicacao_id serial,
  nome character varying(40),
  ativo boolean DEFAULT true,
  CONSTRAINT tb_paciente_indicacao_pkey PRIMARY KEY (paciente_indicacao_id)
);


ALTER TABLE ponto.tb_paciente ALTER column indicacao  type integer USING indicacao::integer; 
USING x::int; 
-- atualiza 22/09/2015

CREATE TABLE ponto.tb_ambulatorio_atendimentos_excluiragendado
(
  ambulatorio_atendimentos_excluiragendado_id serial,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  agenda_exames_id integer,
  paciente_id integer,
  procedimento_tuss_id integer,
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_atendimentos_excluiragendado_pkey PRIMARY KEY (ambulatorio_atendimentos_excluiragendado_id )
)

ALTER TABLE ponto.tb_empresa add column caixa boolean DEFAULT false;


-- atualiza 01/10/2015

CREATE TABLE ponto.tb_ambulatorio_desconto
(
  ambulatorio_desconto_id serial,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  agenda_exames_id integer,
  paciente_id integer,
  guia_id integer,
  operador_id integer,
  valor_total numeric(10,2),
  CONSTRAINT tb_ambulatorio_desconto_pkey PRIMARY KEY (ambulatorio_desconto_id )
)

-- atualiza 07/10/2015

ALTER TABLE ponto.tb_ambulatorio_guia add column observacoes character varying(8000);
ALTER TABLE ponto.tb_ambulatorio_guia add column data_observacoes timestamp without time zone;
ALTER TABLE ponto.tb_ambulatorio_guia add column operador_observacoes integer;
ALTER TABLE ponto.tb_ambulatorio_guia add column nota_fiscal boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_guia add column recibo boolean DEFAULT false;

-- atualiza 16/10/2015

INSERT INTO ponto.tb_ambulatorio_grupo(nome) VALUES ('PSICOLOGIA');

-- atualiza 02/11/2015

ALTER TABLE ponto.tb_convenio add column entrega integer;
ALTER TABLE ponto.tb_convenio add column pagamento integer;
ALTER TABLE ponto.tb_convenio add column ir decimal;
ALTER TABLE ponto.tb_convenio add column pis decimal;
ALTER TABLE ponto.tb_convenio add column cofins decimal;
ALTER TABLE ponto.tb_convenio add column csll decimal;
ALTER TABLE ponto.tb_convenio add column iss decimal;
ALTER TABLE ponto.tb_convenio add column valor_base decimal;

-- atualiza 10/11/2015

CREATE TABLE ponto.tb_ambulatorio_nome_endoscopia_imagem
(
  ambulatorio_nome_endoscopia_imagem_id serial,
  ambulatorio_nome_endoscopia character varying(40),
  exame_id integer,
  nome character varying(40),
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_nome_endoscopia_imagem_pkey PRIMARY KEY (ambulatorio_nome_endoscopia_imagem_id )
)

-- atualiza 27/11/2015

ALTER TABLE ponto.tb_ambulatorio_guia add column peso numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_guia add column altura integer;
ALTER TABLE ponto.tb_ambulatorio_guia add column pasistolica integer;
ALTER TABLE ponto.tb_ambulatorio_guia add column padiastolica integer;

-- atualiza 28/11/2015

ALTER TABLE ponto.tb_empresa add column cnpjxml character varying(20);
ALTER TABLE ponto.tb_empresa add column razao_socialxml character varying(200);
ALTER TABLE ponto.tb_empresa add column cpfxml character varying(11);

ALTER TABLE ponto.tb_ambulatorio_laudo rename ae_indice_diametro to ae_volume;
ALTER TABLE ponto.tb_ambulatorio_laudo add column ae_volume_indexado numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_laudo add column ad_volume integer;
ALTER TABLE ponto.tb_ambulatorio_laudo add column ad_volume_indexado numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_laudo add column vd_diametro_pel numeric(10,2);
ALTER TABLE ponto.tb_ambulatorio_laudo add column vd_diametro_basal numeric(10,2);


CREATE TABLE ponto.tb_sangria
(
  sangria_id serial NOT NULL,
  valor numeric(10,2),
  observacao character varying(2000),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  operador_caixa integer,
  data_cancelamento timestamp without time zone,
  operador_cancelamento integer,
  operador_caixa_cancelamento integer,
  data date,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_sangria_pkey PRIMARY KEY (sangria_id )
)


ALTER TABLE ponto.tb_operador add column ir decimal;
ALTER TABLE ponto.tb_operador add column pis decimal;
ALTER TABLE ponto.tb_operador add column cofins decimal;
ALTER TABLE ponto.tb_operador add column csll decimal;
ALTER TABLE ponto.tb_operador add column iss decimal;
ALTER TABLE ponto.tb_operador add column  credor_devedor_id integer;
ALTER TABLE ponto.tb_operador add column valor_base decimal;


-- atualiza 16/12/2015

ALTER TABLE ponto.tb_empresa add column registroans character varying(11);



-- atualiza 11/01/2015

CREATE TABLE ponto.tb_ambulatorio_orcamento
(
  ambulatorio_orcamento_id serial NOT NULL,
  paciente_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_criacao date,
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_orcamento_pkey PRIMARY KEY (ambulatorio_orcamento_id )
)


CREATE TABLE ponto.tb_ambulatorio_orcamento_item
(
  ambulatorio_orcamento_item_id serial NOT NULL,
  paciente_id integer,
  procedimento_tuss_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data date,
  realizada boolean DEFAULT false,
  orcamento_id integer,
  valor numeric(10,2),
  quantidade integer,
  valor_total numeric(10,2),
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_orcamento_item_pkey PRIMARY KEY (ambulatorio_orcamento_item_id )
)

-- atualiza 19/01/2015

ALTER TABLE ponto.tb_operador add column conta_id  integer;
ALTER TABLE ponto.tb_operador add column tipo_id  character varying(60);
ALTER TABLE ponto.tb_saldo add column data date;

UPDATE ponto.tb_saldo
   SET data=data_cadastro


CREATE TABLE ponto.tb_integracao_agenda
(
  integracao_agenda_id serial,
  paciente_prontuario character varying(40),
  paciente_nome character varying(200),
  paciente_sexo character varying(1),
  paciente_data_nascimento date,
  paciente_cpf character varying(11),
  paciente_senha character varying(40),
  paciente_celular character varying(15),
  paciente_email character varying(50),
  exame_requisicao character varying(50),
  exame_lancamento character varying(50),
exame_codigo character varying(50),
exame_convenio character varying(50),
exame_dados_clinicos character varying(50),
exame_data_hora character varying(50),
exame_descricao character varying(50),
exame_modalidade character varying(50),
exame_equipamento character varying(50),
solicitante_nome character varying(50),
solicitante_conselho character varying(50),
pacs_accessionnumber character varying(50),
pacs_url character varying(50),
status_integracao character varying(1),
  CONSTRAINT tb_integracao_agenda_pkey PRIMARY KEY (integracao_agenda_id )
)


CREATE TABLE ponto.tb_integracao_laudo
(
  integracao_laudo_id serial,
  paciente_prontuario integer,
  paciente_nome character varying(200),
  paciente_sexo character varying(1),
  paciente_data_nascimento date,
  paciente_idade character varying(3),
  exame_uid integer,
  exame_guia character varying(50),
  exame_requisicao character varying(50),
  exame_data date,
  exame_hora time,
  exame_descricao character varying(50),
  exame_modalidade character varying(20),
  laudo_data_hora  timestamp without time zone,
  laudo_texto character varying(3000),
  laudo_medico_id integer,
  laudo_nome_medico character varying(200),
  laudo_conselho_medico character varying(10),
  laudo_conselho_uf_medico character varying(2),
  laudo_medico_revisor_id integer,
  laudo_nome_medico_revisor character varying(200),
  laudo_conselho_medico_revisor character varying(10),
  laudo_conselho_uf_medico_revisor character varying(2),
  laudo_status character varying(20),
  CONSTRAINT tb_integracao_laudo_pkey PRIMARY KEY (integracao_laudo_id )
)


-- atualiza 24/02/2015

ALTER TABLE ponto.tb_agenda_exames_nome add column ativo boolean NOT NULL DEFAULT true;
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER column peso type numeric(10,2);
ALTER TABLE ponto.tb_empresa add column producaomedicadinheiro boolean DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_guia add column declaracao character varying(3000);
ALTER TABLE ponto.tb_ambulatorio_guia add column operador_declaracao integer;
ALTER TABLE ponto.tb_ambulatorio_guia add column data_declaracao timestamp without time zone;

-- atualiza 02/02/2015

ALTER TABLE ponto.tb_agenda_exames add column operador_aterardatafaturamento integer;
ALTER TABLE ponto.tb_agenda_exames add column data_aterardatafaturamento timestamp without time zone;

-- atualiza 02/02/2015

ALTER TABLE ponto.tb_integracao add column wkl_id serial;

-- atualiza 15/03/2015

ALTER TABLE ponto.tb_convenio add column registroans character varying(11);
ALTER TABLE ponto.tb_convenio add column codigoidentificador character varying(20);


-- atualiza 24/03/2015

ALTER TABLE ponto.tb_ambulatorio_guia add column guiaconvenio character varying(25);

-- atualiza 26/03/2015

ALTER TABLE ponto.tb_procedimento_tuss add column percentual boolean default true;

-- atualiza 30/03/2015

ALTER TABLE ponto.tb_procedimento_tuss add column entrega integer;





ALTER TABLE ponto.tb_integracao_laudo add column paciente_prontuario integer;
ALTER TABLE ponto.tb_integracao_laudo add column paciente_nome character varying(200);
ALTER TABLE ponto.tb_integracao_laudo add column paciente_sexo character varying(1);
ALTER TABLE ponto.tb_integracao_laudo add column paciente_data_nascimento date;
ALTER TABLE ponto.tb_integracao_laudo add column paciente_idade character varying(3);
ALTER TABLE ponto.tb_integracao_laudo add column exame_id integer;
ALTER TABLE ponto.tb_integracao_laudo add column exame_guia character varying(50);
ALTER TABLE ponto.tb_integracao_laudo add column exame_requisicao character varying(50);
ALTER TABLE ponto.tb_integracao_laudo add column exame_data date;
ALTER TABLE ponto.tb_integracao_laudo add column exame_hora time;
ALTER TABLE ponto.tb_integracao_laudo add column exame_descricao character varying(50);
ALTER TABLE ponto.tb_integracao_laudo add column exame_modalidade character varying(20);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_data_hora  timestamp without time zone;
ALTER TABLE ponto.tb_integracao_laudo add column laudo_texto character varying(3000);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_medico_id integer;
ALTER TABLE ponto.tb_integracao_laudo add column laudo_nome_medico character varying(200);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_conselho_medico character varying(10);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_conselho_uf_medico character varying(2);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_medico_revisor_id integer;
ALTER TABLE ponto.tb_integracao_laudo add column laudo_nome_medico_revisor character varying(200);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_conselho_medico_revisor character varying(10);
ALTER TABLE ponto.tb_integracao_laudo add column laudo_conselho_uf_medico_revisor character varying(2)
ALTER TABLE ponto.tb_integracao_laudo add column laudo_status character varying(20);

-- atualiza 18/04/2015

ALTER TABLE ponto.tb_agenda_exames add column guiaconvenio character varying(25);

-- atualiza 18/04/2015

ALTER TABLE ponto.tb_procedimento_tuss add column medico boolean default false;

-- atualiza 09/05/2015

CREATE TABLE ponto.tb_ambulatorio_convenio_operador
(
  ambulatorio_convenio_operador_id serial NOT NULL,
  operador_id integer,
  convenio_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_convenio_operador_pkey PRIMARY KEY (ambulatorio_convenio_operador_id )
)


-- atualiza 12/05/2016

ALTER TABLE ponto.tb_agenda_exames add column tipo_agenda character varying(20);

-- atualiza 27/05/2016

ALTER TABLE ponto.tb_tuss add column ativo boolean default true;

-- atualiza 29/05/2016

ALTER TABLE ponto.tb_integracao add column wkl_exame_id integer;
ALTER TABLE ponto.tb_estoque_fornecedor add column  credor_devedor_id integer;

-- atualiza 13/06/2016

CREATE TABLE ponto.tb_convenio_grupo
(
  convenio_grupo_id serial NOT NULL,
  nome character varying(200),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_grupo_pkey PRIMARY KEY (convenio_grupo_id )
)

-- atualiza 14/06/2016

ALTER TABLE ponto.tb_convenio add column convenio_grupo_id integer;

-- atualiza 17/06/2016

CREATE TABLE ponto.tb_convenio_operador_procedimento
(
  convenio_operador_procedimento_id serial NOT NULL,
  operador integer,
  convenio_id integer,
  procedimento_convenio_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_convenio_operador_procedimento_pkey PRIMARY KEY (convenio_operador_procedimento_id )
)



-- atualiza 05/07/2016

  update ponto.tb_agenda_exames
	set medico_consulta_id = medico_agenda
	where medico_consulta_id is null

ALTER TABLE ponto.tb_agenda_exames add column ocupado boolean DEFAULT false;

-- atualiza 16/07/2016

CREATE TABLE ponto.tb_versao
(
  versao_id integer NOT NULL,
  sistema character varying(20),
  banco_de_dados character varying(20),
  CONSTRAINT tb_versao_pkey PRIMARY KEY (versao_id )
);

-- atualiza 20/07/2016

CREATE TABLE ponto.tb_procedimento_percentual_medico_convenio

-- atualiza 01/08/2016

ALTER TABLE ponto.tb_agenda_exames add column internet boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente add column internet boolean DEFAULT false;

-- atualiza 04/08/2016

ALTER TABLE ponto.tb_estoque_entrada add column inventario boolean DEFAULT false;

-- atualiza 08/08/2016

CREATE TABLE ponto.tb_ambulatorio_exame
(
  ambulatorio_exame_id serial NOT NULL,
  paciente_id integer,
  procedimento_tuss_id integer,
  guia_id integer,
  texto character varying(20000),
  assinatura boolean,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  medico_parecer1 integer,
  medico_parecer2 integer,
  laudo_id integer,
  empresa_id integer,
  tipo character varying(50),
  CONSTRAINT tb_ambulatorio_exame_pkey PRIMARY KEY (ambulatorio_exame_id )
);

CREATE TABLE ponto.tb_procedimento_percentual_medico_convenio
(
  procedimento_percentual_medico_convenio_id serial,
  procedimento_percentual_medico_id integer,
  medico integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_percentual_medico_convenio_pkey PRIMARY KEY (procedimento_percentual_medico_convenio_id )
);

CREATE TABLE ponto.tb_ambulatorio_modelo_receita_especial
(
  ambulatorio_modelo_receita_especial_id serial,
  medico_id integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_modelo_receita_especial_pkey PRIMARY KEY (ambulatorio_modelo_receita_especial_id )
);


CREATE TABLE ponto.tb_ambulatorio_modelo_solicitar_exames
(
  ambulatorio_modelo_solicitar_exames_id serial,
  medico_id integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_modelo_solicitar_exames_pkey PRIMARY KEY (ambulatorio_modelo_solicitar_exames_id )
);

ALTER TABLE ponto.tb_exame_sala add column excluido boolean DEFAULT false;

-- atualiza 31/08/16

ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN data_atualizacao timestamp without time zone;
ALTER TABLE ponto.tb_paciente_indicacao ADD COLUMN operador_atualizacao integer;

CREATE TABLE ponto.tb_financeiro_classe
(
  financeiro_classe_id serial NOT NULL,
  descricao character varying(200),
  tipo_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_financeiro_classe_pkey PRIMARY KEY (financeiro_classe_id )
);

CREATE TABLE ponto.tb_financeiro_sub_classe
(
  financeiro_sub_classe_id serial NOT NULL,
  descricao character varying(200),
  classe_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_financeiro_sub_classe_pkey PRIMARY KEY (financeiro_sub_classe_id )
);

-- atualiza 02/09/16

ALTER TABLE ponto.tb_saidas ADD COLUMN classe character varying(60);

-- atualiza 03/09/16

ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN classe character varying(60);
ALTER TABLE ponto.tb_entradas ADD COLUMN classe character varying(60);
ALTER TABLE ponto.tb_financeiro_contasreceber ADD COLUMN classe character varying(60);

-- atualiza 08/09/16

ALTER TABLE ponto.tb_empresa ADD COLUMN CNES character varying(20);
UPDATE ponto.tb_empresa SET cnes= '3348873';

-- atualiza 09/09/2016

UPDATE ponto.tb_entradas
   SET classe= tipo;


UPDATE ponto.tb_saidas
   SET classe= tipo;

UPDATE ponto.tb_financeiro_contaspagar
   SET classe= tipo;

UPDATE ponto.tb_financeiro_contasreceber
   SET classe= tipo;

INSERT INTO ponto.tb_financeiro_classe(
            financeiro_classe_id, descricao,data_cadastro, 
            operador_cadastro, data_atualizacao, operador_atualizacao)
   (SELECT tipo_entradas_saida_id, descricao, data_cadastro, operador_cadastro, 
       data_atualizacao, operador_atualizacao
  FROM ponto.tb_tipo_entradas_saida);


DELETE FROM ponto.tb_tipo_entradas_saida;


-- atualiza 21/09/16

CREATE TABLE ponto.tb_financeiro_email
(
  financeiro_email_id serial NOT NULL,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  mensagem text
);

-- atualiza 13/09/16

CREATE TABLE ponto.tb_lote
(
  lote character varying(100)
);

INSERT INTO ponto.tb_lote(lote) VALUES (7899);

-- atualiza 28/09/16

CREATE TABLE ponto.tb_respostas_xml
(
  agenda_exames_id integer,
  perguntas_respostas xml,
  peso integer,
  obs character varying(2000),
  txtp9 character varying(100),
  txtp19 character varying(500),
  txtp20 character varying(500)
);

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN operador_cadastro integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN data_cadastro timestamp without time zone;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN data_atualizacao timestamp without time zone;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN operador_atualizacao integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN conta_id integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN ajuste numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN dia_receber integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN tempo_receber integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN credor_devedor integer;


-- atualiza 06/10/2016


CREATE TABLE ponto.tb_chat_mensagens
(
  chat_mensagens_id serial NOT NULL,
  mensagem character varying(300),
  operador_origem integer,
  operador_destino integer,
  data_envio timestamp without time zone,
  visualizada boolean NOT NULL DEFAULT false,
  ativo boolean NOT NULL DEFAULT true,
  CONSTRAINT tb_chat_mensagens_pkey PRIMARY KEY (chat_mensagens_id )
);




-- atualiza 13/10/2016

CREATE TABLE ponto.tb_procedimento_convenio_pagamento
(
  procedimento_convenio_pagamento_id serial NOT NULL,
  procedimento_convenio_id integer,
  forma_pagamento_id integer,
  CONSTRAINT tb_procedimento_convenio_pagamento_pkey PRIMARY KEY (procedimento_convenio_pagamento_id)
);

-- atualiza 14/10/2016


DELETE FROM ponto.tb_perfil WHERE perfil_id = 6;

UPDATE ponto.tb_perfil SET nome = 'ADMINISTRADOR TOTAL' WHERE perfil_id = 1;
UPDATE ponto.tb_perfil SET nome = 'CAIXA RECEPCAO' WHERE perfil_id = 2;

INSERT INTO ponto.tb_perfil VALUES (9, 'CAIXA', TRUE);
INSERT INTO ponto.tb_perfil VALUES (10, 'ADMINISTRADOR', TRUE);
INSERT INTO ponto.tb_perfil VALUES (11, 'RECEPCAO', TRUE);

UPDATE ponto.tb_perfil SET nome = 'FATURAMENTO' WHERE perfil_id = 3;
UPDATE ponto.tb_perfil SET nome = 'MEDICO' WHERE perfil_id = 4;
UPDATE ponto.tb_perfil SET nome = 'GERENTE RECEPCAO' WHERE perfil_id = 5;
UPDATE ponto.tb_perfil SET nome = 'TECNICO' WHERE perfil_id = 7;
UPDATE ponto.tb_perfil SET nome = 'ALMOXARIFADO' WHERE perfil_id = 8;


-- atualiza 18/10/2016

CREATE TABLE ponto.tb_financeiro_grupo
(
  financeiro_grupo_id serial NOT NULL,
  nome character varying(40),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_financeiro_grupo_pkey PRIMARY KEY (financeiro_grupo_id )
);

CREATE TABLE ponto.tb_grupo_formapagamento
(
  grupo_formapagamento_id serial NOT NULL,
  grupo_id integer,
  forma_pagamento_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_grupo_formapagamento_pkey PRIMARY KEY (grupo_formapagamento_id )
);

ALTER TABLE ponto.tb_procedimento_convenio_pagamento ADD COLUMN grupo_pagamento_id integer;

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




-- atualiza 19/10/16

ALTER TABLE ponto.tb_empresa ADD COLUMN tipo_xml_id integer;

CREATE TABLE ponto.tb_empresa_tipo_xml
(
  tipo_xml_id serial NOT NULL,
  nome character varying(20),
  descricao character varying(200),
  ativo boolean NOT NULL DEFAULT true,
  CONSTRAINT tb_empresa_tipo_xml_pkey PRIMARY KEY (tipo_xml_id )
);

CREATE TABLE ponto.tb_integracao_naja
(
  wkl_aetitle character varying(16),
  wkl_procstep_startdate character varying(10),
  wkl_procstep_starttime character varying(8),
  wkl_modality character varying(20),
  wkl_perfphysname character varying(200),
  wkl_procstep_descr character varying(300),
  wkl_procstep_id character varying(50),
  wkl_reqprocid character varying(50),
  wkl_reqprocdescr character varying(200),
  wkl_studyinstuid character varying(50),
  wkl_accnumber character varying(50),
  wkl_reqphysician character varying(200),
  wkl_refphysname character varying(200),
  wkl_patientid character varying(50),
  wkl_patientname character varying(200),
  wkl_patientbirthdate character varying(10),
  wkl_patientsex character varying(2),
  wkl_id serial NOT NULL,
  wkl_exame_id integer
);

-- atualiza 20/10/16

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN parcelas integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN taxa_juros integer;

-- atualiza 21/10/16

ALTER TABLE ponto.tb_financeiro_grupo ADD COLUMN ajuste numeric(10,2);

-- atualiza 22/10/16

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN parcelas1 integer;
ALTER TABLE ponto.tb_agenda_exames ALTER COLUMN parcelas1 SET DEFAULT 1;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN parcelas2 integer;
ALTER TABLE ponto.tb_agenda_exames ALTER COLUMN parcelas2 SET DEFAULT 1;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN parcelas3 integer;
ALTER TABLE ponto.tb_agenda_exames ALTER COLUMN parcelas3 SET DEFAULT 1;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN parcelas4 integer;
ALTER TABLE ponto.tb_agenda_exames ALTER COLUMN parcelas4 SET DEFAULT 1;

-- atualiza 26/10/16

CREATE TABLE ponto.tb_financeiro_contasreceber_temp
(
  financeiro_contasreceber_temp_id serial NOT NULL,
  valor numeric(10,2),
  devedor integer,
  parcela character varying(3),
  numero_parcela character varying(3),
  observacao character varying(2000),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  data date,
  tipo character varying(60),
  tipo_numero character varying(40),
  ativo boolean DEFAULT true,
  excluido boolean DEFAULT false,
  entrada_id integer,
  conta integer,
  classe character varying(60),
  CONSTRAINT tb_financeiro_contasreceber_temp_pkey PRIMARY KEY (financeiro_contasreceber_temp_id )
);

-- atualiza 28/1016

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN observacao_faturamento character varying(8000);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_obs_faturamento integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_obs_faturamento timestamp without time zone;

-- atualiza 01/11/16

CREATE TABLE ponto.tb_ambulatorio_modelo_declaracao
(
  ambulatorio_modelo_declaracao_id serial NOT NULL,
  medico_id integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_modelo_declaracao_pkey PRIMARY KEY (ambulatorio_modelo_declaracao_id )
);

-- atualiza 07/11/16


CREATE TABLE ponto.tb_formapagamento_pacela_juros
(
  formapagamento_pacela_juros_id serial NOT NULL,
  forma_pagamento_id integer,
  taxa_juros numeric(10,2),
  parcelas_inicio integer,
  parcelas_fim integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT formapagamento_pacela_juros_id_pkey PRIMARY KEY (formapagamento_pacela_juros_id)
); 


ALTER TABLE ponto.tb_forma_pagamento DROP COLUMN taxa_juros;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN taxa_juros numeric(10,2);

-- atualiza 16/11/16

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_antiga date;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_antiga timestamp without time zone;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN operador_alteradata integer;

-- atualiza 24/11/16

update ponto.tb_saldo
set data = to_date(to_char(data_cadastro, 'YYYY/MM/DD'), 'YYYY/MM/DD')
where data is null;

-- atualiza 21/11/16

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_tipo integer;


-- atualiza 23/11/16

INSERT INTO ponto.tb_perfil VALUES (12, 'RECEPCAO AGENDAMENTO', TRUE);


-- Internação na Clínica

 -- Dia 22/11/16
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

CREATE TABLE ponto.tb_internacao_prescricao
(
  internacao_prescricao_id serial NOT NULL,
  internacao_id integer,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  data date,
  CONSTRAINT tb_internacao_prescricao_pkey PRIMARY KEY (internacao_prescricao_id )
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

-- Dia 25/11/16

INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
    VALUES ('PROCEDIMENTO', 'EXAME');


-- Dia 28/11/16


ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN fixar boolean DEFAULT false;

-- Dia 01/12/16 Centro Cirurgico

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

-- Valor da Nota Fiscal 

ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN valor_guia numeric(10,2);


-- atualiza 06/12/16

CREATE TABLE ponto.tb_agrupador_fisioterapia_temp
(
  agrupador_fisioterapia_temp_id serial NOT NULL,
  qtde_sessoes integer,
  ativo boolean NOT NULL DEFAULT true,
  CONSTRAINT agrupador_fisioterapia_temp_id_pkey PRIMARY KEY (agrupador_fisioterapia_temp_id )
);

ALTER TABLE ponto.tb_horarioagenda ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_horarioagenda ADD COLUMN observacoes character varying(1000);

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN encaixe boolean;


-- atualiza 07/12/16

CREATE TABLE ponto.tb_operador_empresas
(
  operador_empresa_id serial NOT NULL,
  operador_id integer,
  empresa_id integer,
  ativo boolean NOT NULL DEFAULT true,
  CONSTRAINT tb_operador_empresas_pkey PRIMARY KEY (operador_empresa_id )
);


-- atualiza 08/12/2016

CREATE TABLE ponto.tb_ambulatorio_receituario_medicamento
(
  ambulatorio_receituario_medicamento_id serial NOT NULL,
  nome character varying(200),
  texto text,
  medico_id integer,    
  quantidade character varying(200),
  unidade_id integer,
  posologia text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_receituario_medicamento_pkey PRIMARY KEY (ambulatorio_receituario_medicamento_id)
);

CREATE TABLE ponto.tb_ambulatorio_receituario_medicamento_unidade
(
  ambulatorio_receituario_medicamento_unidade_id serial NOT NULL,
  descricao character varying(200),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_receituario_medicamento_unidade_pkey PRIMARY KEY (ambulatorio_receituario_medicamento_unidade_id)
);


-- atualiza  08/12/16

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN cartao boolean;


INSERT INTO ponto.tb_operador_empresas(
             operador_id, empresa_id)
SELECT o.operador_id, e.empresa_id
FROM ponto.tb_operador o, ponto.tb_empresa e
WHERE o.ativo = 't' and e.ativo = 't';


-- Dia 14/12/2016

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN parcela_minima numeric(10,2);


-- Dia 22/12/2016

ALTER TABLE ponto.tb_estoque_produto ADD COLUMN procedimento_id integer;
ALTER TABLE ponto.tb_estoque_cliente ADD COLUMN sala_id integer;


-- Dia 23/12/2016

CREATE TABLE ponto.tb_ambulatorio_gasto_sala
(
  ambulatorio_gasto_sala_id serial NOT NULL,
  guia_id integer,
  produto_id integer,
  quantidade integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_gasto_sala_pkey PRIMARY KEY (ambulatorio_gasto_sala_id)
);


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


-- Dia 29/12/2016

ALTER TABLE ponto.tb_ambulatorio_gasto_sala add column agenda_exame_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia DROP COLUMN procedimento_id;

CREATE TABLE ponto.tb_procedimentos_agrupados
(
  procedimento_agrupado_id serial NOT NULL,
  agrupador_id integer,
  procedimento_tuss_id integer,
  obs character varying,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimentos_agrupados_id PRIMARY KEY (procedimento_agrupado_id )
);

CREATE TABLE ponto.tb_agrupador_procedimento_nome
(
  agrupador_id serial NOT NULL,
  nome character varying,
  ativo boolean NOT NULL DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT agrupador_procedimento_pkey PRIMARY KEY (agrupador_id )
);


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


-- 30/12/16

ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN data date;
ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN imprimir_cid boolean NOT NULL DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN cid1 character varying;

--02/01/17

ALTER TABLE ponto.tb_agenda_exames ALTER COLUMN ordenador SET DEFAULT ''::character varying;
ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN cid boolean;
ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN cid SET NOT NULL;
ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN cid SET DEFAULT false;


-- 02/01/17

ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN convenio integer;


-- 05/01/17
ALTER TABLE ponto.tb_ambulatorio_receituario ADD COLUMN carimbo boolean;
ALTER TABLE ponto.tb_ambulatorio_receituario ALTER COLUMN carimbo SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_receituario ADD COLUMN assinatura boolean;
ALTER TABLE ponto.tb_ambulatorio_receituario ALTER COLUMN assinatura SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_receituario_especial ADD COLUMN carimbo boolean;
ALTER TABLE ponto.tb_ambulatorio_receituario_especial ALTER COLUMN carimbo SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_receituario_especial ADD COLUMN assinatura boolean;
ALTER TABLE ponto.tb_ambulatorio_receituario_especial ALTER COLUMN assinatura SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN carimbo boolean;
ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN carimbo SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN assinatura boolean;
ALTER TABLE ponto.tb_ambulatorio_atestado ALTER COLUMN assinatura SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_exame ADD COLUMN carimbo boolean;
ALTER TABLE ponto.tb_ambulatorio_exame ALTER COLUMN carimbo SET DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_exame ADD COLUMN assinatura boolean;
ALTER TABLE ponto.tb_ambulatorio_exame ALTER COLUMN assinatura SET DEFAULT false;

ALTER TABLE ponto.tb_operador ADD COLUMN carimbo character varying;



-- Dia 09/01/2017

ALTER TABLE ponto.tb_ambulatorio_gasto_sala ADD COLUMN descricao text;


-- Dia 11/01/2017

ALTER TABLE ponto.tb_ambulatorio_atestado ADD COLUMN cid2 character varying;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN cid2 character varying(8);

-- Dia 13/01/2017

ALTER TABLE ponto.tb_operador ADD COLUMN horario_login timestamp without time zone;
ALTER TABLE ponto.tb_operador ADD COLUMN horario_logout timestamp without time zone;
ALTER TABLE ponto.tb_operador ADD COLUMN online boolean NOT NULL DEFAULT false;

-- Dia 14/01/2017
ALTER TABLE ponto.tb_empresa ADD COLUMN chat boolean NOT NULL DEFAULT false;


-- Dia 16/01/2017
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


-- Dia 31/01/2017

ALTER TABLE ponto.tb_solicitacao_cirurgia_orcamento ADD COLUMN procedimento_tuss_id integer;
ALTER TABLE ponto.tb_solicitacao_cirurgia_orcamento ADD COLUMN valor numeric(10,2);


-- Dia 01/02/2017

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_bruto numeric(10,2);

CREATE TABLE ponto.tb_procedimento_convenio_antigo
(
  procedimento_convenio_id_antigo serial NOT NULL,
  procedimento_convenio_id integer,
  convenio_id integer,
  procedimento_tuss_id integer,
  qtdech numeric(10,4),
  valorch numeric(10,4),
  qtdefilme numeric(10,4),
  valorfilme numeric(10,4),
  qtdeporte numeric(10,4),
  valorporte numeric(10,4),
  qtdeuco numeric(10,4),
  valoruco numeric(10,4),
  valortotal numeric(10,2),
  percentual_ch character varying(100),
  percentual_filme character varying(100),
  percentual_porte character varying(100),
  percentual_uco character varying(100),
  percentual_total character varying(100),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_convenio_antigo_pkey PRIMARY KEY (procedimento_convenio_id_antigo )
);


-- Dia 04/02/16
-- Comando para resolver o erro de duplicate primary key ou de lastval not defined in the season
SELECT setval('ponto.tb_financeiro_classe_financeiro_classe_id_seq', (SELECT MAX(financeiro_classe_id) FROM ponto.tb_financeiro_classe)+1);

-- Dia 09/02/2017
ALTER TABLE ponto.tb_solicitacao_cirurgia ADD COLUMN orcamento boolean NOT NULL DEFAULT true;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_medico numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_medico numeric(10,2);

-- Dia 10/02/2017
ALTER TABLE ponto.tb_agenda_exames drop COLUMN valor_medico;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_medico boolean;

-- Dia 13/02/2017
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_laudo TYPE character varying(40000);
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto_revisor TYPE character varying(40000);

-- Dia 16/02/2017
INSERT INTO ponto.tb_perfil(
            perfil_id, nome, ativo)
    VALUES (13, 'FINANCEIRO', true);
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN indicacao_id integer;

-- Dia 20/02/2017
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN indicacao integer;


-- Dia 21/02/2017

ALTER TABLE ponto.tb_agenda_exames DROP COLUMN valor_medico;
ALTER TABLE ponto.tb_agenda_exames DROP COLUMN percentual_medico;


ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_medico numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_medico boolean;



ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_declaracao integer;
-- Definir na coluna acima do banco o tipo de impressão de declaração. O NÚMERO >>>>>>>> 1 equivale ao logo pequeno
-- Qualquer coisa diferente ou vazio significa logo grande padrão Hcor

-- Dia 22/02/2017

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_alterarautorizacao integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_alterarautorizacao timestamp without time zone;

-- Dia 23/02/2017

-- QUERY RELACIONADA AO PERCENTUAL DOS MEDICOS
-- RODAR PRIMEIRO A QUERY ABAIXO

UPDATE ponto.tb_agenda_exames
   SET 
       valor_medico= mc.valor, percentual_medico= mc.percentual


       
FROM ponto.tb_procedimento_percentual_medico m , ponto.tb_procedimento_percentual_medico_convenio mc

	WHERE ponto.tb_agenda_exames.procedimento_tuss_id = m.procedimento_tuss_id 

	AND m.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id
       
        AND mc.medico = ponto.tb_agenda_exames.medico_agenda  
 
       AND ponto.tb_agenda_exames.paciente_id is not null

       AND ponto.tb_agenda_exames.procedimento_tuss_id is not null  

       AND m.ativo = 'true' 
       
       AND mc.ativo = 'true';



---------------------------------------------------------------------------------------------------------------------
--LOGO APÓS RODAR ESSA QUERY

UPDATE ponto.tb_agenda_exames ae
   SET 
       valor_medico= pt.perc_medico, percentual_medico= pt.percentual
       
FROM ponto.tb_agenda_exames ae1

       LEFT JOIN ponto.tb_procedimento_convenio pc 
       
       ON ae1.procedimento_tuss_id = pc.procedimento_convenio_id 
       
       LEFT JOIN ponto.tb_procedimento_tuss pt 
       
       ON pc.procedimento_tuss_id = pt.procedimento_tuss_id 
       
       WHERE pc.procedimento_convenio_id = ae.procedimento_tuss_id
       
       AND ae.valor_medico is null

       AND ae.paciente_id is not null

       AND ae.procedimento_tuss_id is not null 
       
       AND pc.ativo = 'true' 
       
       AND pt.ativo = 'true';


-- Dia 24/02/2017
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


-- Dia 03/03/2017
ALTER TABLE ponto.tb_operador ADD COLUMN classe character varying(60);



-- Dia 07/03/2017
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN checado boolean DEFAULT false;

ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN operador_checado integer;
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN data_checado timestamp without time zone;
ALTER TABLE ponto.tb_estoque_entrada ADD COLUMN lote character varying(30);

-- Dia 09/03/2017
ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_recibo integer;

-- Dia 13/03/2017

ALTER TABLE ponto.tb_paciente ADD COLUMN escolaridade_id integer;

-- Dia 15/03/2017

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN chegada boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_chegada integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_chegada timestamp without time zone;

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN atendimento boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_atendimento integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_atendimento timestamp without time zone;

-- Dia 17/03/17

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN operador_finalizado integer;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_finalizado timestamp without time zone;


ALTER TABLE ponto.tb_agenda_exames ADD COLUMN situacao_faturamento character varying(30);


CREATE TABLE ponto.tb_tempo_medio_atendimento
(
  tempo_medio_atendimento_id serial NOT NULL,

  tempo_chegada character varying(20),
  tempo_atendimento character varying(20),
  tempo_finalizado character varying(20),
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  CONSTRAINT tb_tempo_medio_atendimento_pkey PRIMARY KEY (tempo_medio_atendimento_id)
);

-- Dia 18/03/2017
CREATE TABLE ponto.tb_empresa_sms
(
  empresa_sms_id serial NOT NULL,
  empresa_id integer,
  pacote_id integer,
  mensagem_confirmacao character varying(20000),
  mensagem_agradecimento character varying(20000),
  mensagem_aniversariante character varying(20000),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_sms_pkey PRIMARY KEY (empresa_sms_id)
);

CREATE TABLE ponto.tb_pacote_sms
(
  pacote_sms_id serial NOT NULL,
  descricao_pacote character varying(2000),
  quantidade integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_pacote_sms_pkey PRIMARY KEY (pacote_sms_id)
);

-- PACOTES DE MENSAGENS --
INSERT INTO ponto.tb_pacote_sms(descricao_pacote, quantidade)
    VALUES ('PACOTE 1000 MENSAGENS', 1000),
	   ('PACOTE 5000 MENSAGENS', 5000),
	   ('PACOTE 10000 MENSAGENS', 10000),
	   ('PACOTE 20000 MENSAGENS', 20000);


-- Dia 20/03/2017
CREATE TABLE ponto.tb_empresa_sms_verificacao
(
  sms_verificacao_id serial NOT NULL,
  data_verificacao date,
  CONSTRAINT tb_empresa_sms_verificacao_pkey PRIMARY KEY (sms_verificacao_id)
);

CREATE TABLE ponto.tb_sms
(
  sms_id serial NOT NULL,
  agenda_exames_id integer,
  paciente_id integer,
  medico_id integer,
  tipo character varying(200),
  numero character varying(200),
  data date,
  ativo boolean DEFAULT true,
  enviado boolean DEFAULT false,
  data_envio timestamp without time zone,
  CONSTRAINT tb_sms_pkey PRIMARY KEY (sms_id)
);

CREATE TABLE ponto.tb_empresa_sms_registro
(
  empresa_sms_registro_id serial NOT NULL,
  empresa_id integer,
  periodo character varying(20),
  qtde integer,
  CONSTRAINT tb_empresa_sms_registro_pkey PRIMARY KEY (empresa_sms_registro_id)
);
--22/03/17

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN operador_unificacaomedico integer;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_unificacaomedico timestamp without time zone;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN medico_antigo integer;

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN operador_unificacaomedico integer;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN data_unificacaomedico timestamp without time zone;
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN medico_antigo integer;


ALTER TABLE ponto.tb_empresa ADD COLUMN email character varying(40);

INSERT INTO ponto.tb_perfil(
            perfil_id, nome, ativo)
    VALUES (14, 'MARKETING', true);

-- Dia 23/03/2017
ALTER TABLE ponto.tb_sms ADD COLUMN registrado boolean DEFAULT false;
ALTER TABLE ponto.tb_sms ADD COLUMN controle_id integer;
ALTER TABLE ponto.tb_sms ADD COLUMN mensagem character varying(255);
ALTER TABLE ponto.tb_sms ADD COLUMN empresa_id integer;

-- Dia 24/03/2017
ALTER TABLE ponto.tb_ambulatorio_laudo ALTER COLUMN texto TYPE character varying(40000);

-- 27/03/2017
UPDATE ponto.tb_horarioagenda
   SET empresa_id=1;

-- 29/03/2017

ALTER TABLE ponto.tb_empresa ADD COLUMN impressao_laudo integer;

UPDATE ponto.tb_empresa
   SET 
       impressao_laudo=impressao_tipo; 


-- Dia 30/03/2017
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN equipe boolean;
ALTER TABLE ponto.tb_ambulatorio_guia ALTER COLUMN equipe SET DEFAULT false;
ALTER TABLE ponto.tb_ambulatorio_guia ADD COLUMN equipe_id integer;
ALTER TABLE ponto.tb_equipe_cirurgia_operadores ADD COLUMN solicitacao_cirurgia_id integer;

ALTER TABLE ponto.tb_convenio ADD COLUMN carteira_obrigatoria boolean DEFAULT false;

-- GRAU DE PARTICIPAÇÃO CIRURGICA
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

-- Atualizando procedimentos convenio para tuss na tabela produto

UPDATE ponto.tb_estoque_produto produto
   SET 
       procedimento_id= pt.procedimento_tuss_id
       
FROM ponto.tb_estoque_produto produto1, ponto.tb_procedimento_convenio pc , ponto.tb_procedimento_tuss pt

       WHERE produto.procedimento_id = pc.procedimento_convenio_id 
              
       AND pc.procedimento_tuss_id = pt.procedimento_tuss_id 
       
       AND pc.procedimento_convenio_id = produto.procedimento_id;


CREATE TABLE ponto.tb_procedimento_convenio_produto_valor
(
  procedimento_convenio_produto_valor_id serial NOT NULL,
  procedimento_tuss_id integer,
  convenio_id integer,
  ativo boolean DEFAULT true,
  valor numeric(10,2),
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  CONSTRAINT tb_procedimento_convenio_produto_valor_pkey PRIMARY KEY (procedimento_convenio_produto_valor_id )
);
-- FIM DA VERSÃO 1.0.00002
DROP TABLE ponto.tb_versao;
CREATE TABLE ponto.tb_versao
(
  versao_id SERIAL NOT NULL,
  sistema character varying(20),
  banco_de_dados character varying(20),
  CONSTRAINT tb_versao_pkey PRIMARY KEY (versao_id )
);

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00003', '1.0.00003');

---++++++++++ CRIAR NOVO ARQUIVO ++++++++++---
