-- ADICIONANDO A FUNCIONALIDADE DE FISIOTERAPIA HOME CARE.
-- AO MARCAR ESSA OPÇÃO NO CONVÊNIO, A PRIMEIRA SESSÃO DO PROCEDIMENTO NÃO É LIBERADO NA HORA

-- 04/04/2017
ALTER TABLE ponto.tb_convenio ADD COLUMN home_care boolean DEFAULT false;


-- 06/04/2017


DROP TABLE ponto.tb_versao;
CREATE TABLE ponto.tb_versao
(
  versao_id SERIAL NOT NULL,
  sistema character varying(20),
  banco_de_dados character varying(20),
  CONSTRAINT tb_versao_pkey PRIMARY KEY (versao_id )
);

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00005', '1.0.00004');

-- Versão 1.0.00005 Adicionado ajuste de valores relacionados ao relatório de conferência


-- 07/04/2017 Procedimentos Home Care

ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN home_care boolean DEFAULT false;

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00006', '1.0.00005');
-- 12/04/2017 Flag para verificar se já foi feito o ajuste de valores relacionados com o convênio

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN ajuste_cbhpm boolean DEFAULT false;



---++++++++++ VERSÃO 1.0.00007 ++++++++++---
-- Querys para fazer com que na tela "manter contas a receber"
-- Seja mostrado o valor da parcela, seguido do total de parcelas. Ex: 1/7
UPDATE ponto.tb_financeiro_contasreceber fc
SET parcela = '1'
WHERE parcela IS NULL;

UPDATE ponto.tb_financeiro_contasreceber fc
SET numero_parcela =
		(
			SELECT MAX(parcela) AS total FROM ponto.tb_financeiro_contasreceber
			WHERE ponto.tb_financeiro_contasreceber.devedor = fc.devedor
			AND ponto.tb_financeiro_contasreceber.conta = fc.conta
			AND ponto.tb_financeiro_contasreceber.classe = fc.classe	
			AND TO_CHAR(ponto.tb_financeiro_contasreceber.data_cadastro, 'YYYY-DD-MM HH24:MI') = TO_CHAR(fc.data_cadastro, 'YYYY-DD-MM HH24:MI')
		);


--| Versão 1.0.00007 
--|     1 - Correções no relatorio de caixa personalizado (aparencia e layout)
--|     2 - Correções no relatorio de nota (ao clicar no nome do paciente o sistema abre um pop-up com os dados do paciente)
--|     3 - Correções na tela "manter contas a receber" (o sistema agora informa o numero total de parcelas)
--|     4 - Correção no filtro de especialidade nas multifunções do medico (ao selecionar uma especialidade e pesquisar 
--| ele traz de todos os medicos daquela especialidade)
--|     5 - Mudanças na impressão do relatorio de orçamento. Agora o relatorio esta em grade (com borda nas tabelas) e o campo 
--| "descrição" agora sai na impressao do relatorio.

INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
    VALUES ('1.0.00007', '1.0.00005');

---++++++++ FIM VERSÃO 1.0.00007 ++++++++---


--| Versão 1.0.00007 
--|     1 - Médicos não tem mais acesso a recepção, com exceção do cadastro de pacientes.
--|     2 - Médicos não tem mais acesso a recepção, com exceção do cadastro de pacientes.
--Dia 24/04/2017
ALTER TABLE ponto.tb_operador ADD COLUMN curriculo character varying(20000);


--Dia 25/04/2017

ALTER TABLE ponto.tb_estoque_saida ADD COLUMN ambulatorio_gasto_sala_id integer;
ALTER TABLE ponto.tb_estoque_saldo ADD COLUMN ambulatorio_gasto_sala_id integer;

--Dia 26/04/2017

ALTER TABLE ponto.tb_exame_sala ADD COLUMN armazem_id integer;

--Dia 04/05/2017
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN revisao boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN revisao_dias integer;
ALTER TABLE ponto.tb_empresa_sms ADD COLUMN mensagem_revisao character varying(20000);


-- Dia 05/05/2017
-- Essa coluna serve para indicar se o centro cirurgico irá aparecer ou não no menu.
--      Para alterar, basta ir no PGADMIN e setar essa coluna para 'true'
ALTER TABLE ponto.tb_empresa add column centrocirurgico boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa add column relatoriorm boolean DEFAULT false;

ALTER TABLE ponto.tb_laudoantigo ADD COLUMN laudoantigo_id serial NOT NULL;


-- Dia 15/05/2017
-- PACOTES DE MENSAGENS --
TRUNCATE ponto.tb_pacote_sms;
INSERT INTO ponto.tb_pacote_sms(descricao_pacote, quantidade)
    VALUES ('PACOTE 1000 MENSAGENS', 1000),
           ('PACOTE 2000 MENSAGENS', 2000),
           ('PACOTE 5000 MENSAGENS', 5000),
           ('PACOTE 10000 MENSAGENS', 10000),
	   ('PACOTE 50000 MENSAGENS', 50000);

ALTER TABLE ponto.tb_empresa_sms ADD COLUMN enviar_excedentes boolean DEFAULT false;

ALTER TABLE ponto.tb_integracao_laudo ALTER COLUMN exame_requisicao TYPE character varying(200);
ALTER TABLE ponto.tb_integracao_laudo ALTER COLUMN exame_descricao TYPE character varying(200);


-- 22/05/2017 INTEGRANDO AO PACS

CREATE TABLE ponto.tb_pacs
(
  pacs_id SERIAL NOT NULL,
  ip_local character varying(30),
  ip_externo character varying(80),
  login character varying(200),
  senha character varying(200),
  empresa_id integer,
  CONSTRAINT tb_pacs_pkey PRIMARY KEY (pacs_id )
);




-- 23/05/2017 CONTINUA A INTEGRAÇÃO AO PACS


-- AQUI TEM A LINHA DE COMANDO NECESSÁRIA PRA UTILIZAR NO TERMINAL PRA BAIXAR O CURL NO PHP

------------ COPIAR A SEGUIR SEM AS ASPAS E EXECUTAR 'sudo apt-get install php5-curl -y && sudo service apache2 restart'------------------------


-- 23/05/2017 TORNANDO MAIS FÁCIL A CRIAÇÃO DE AGENDA

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN horario_id integer;


-- Dia 25/05/2017
ALTER TABLE ponto.tb_agrupador_procedimento_nome ADD COLUMN convenio_id integer;

-- Dia 29/05/2017
ALTER TABLE ponto.tb_ambulatorio_convenio_operador ADD COLUMN ativo boolean DEFAULT true;

-- Dia 30/05/2017

CREATE TABLE ponto.tb_ambulatorio_fila_impressao
(
  ambulatorio_fila_impressao_id serial,
  operador_solicitante integer,
  nome character varying(200),
  texto text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_ambulatorio_fila_impressao_pkey PRIMARY KEY (ambulatorio_fila_impressao_id)
);


-- Dia 05/06/2017
ALTER TABLE ponto.tb_empresa_sms_registro ADD COLUMN data_verificacao date;
DROP TABLE ponto.tb_empresa_sms_verificacao;

CREATE TABLE ponto.tb_empresa_email_verificacao
(
  email_verificacao_id serial NOT NULL,
  data_verificacao date,
  CONSTRAINT tb_empresa_email_verificacao_pkey PRIMARY KEY (email_verificacao_id)
);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_revisao date;

ALTER TABLE ponto.tb_empresa ADD COLUMN servicosms boolean NOT NULL DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN servicoemail boolean NOT NULL DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN email_mensagem_confirmacao character varying(20000);
ALTER TABLE ponto.tb_empresa ADD COLUMN email_mensagem_agradecimento character varying(20000);


CREATE TABLE ponto.tb_contato_cliente
(
  contato_cliente_id serial,
  operador_solicitante integer,
  nome character varying(200),
  telefone character varying(200),
  email character varying(200),
  mensagem character varying(200),
  ativo boolean DEFAULT true,
  CONSTRAINT tb_contato_cliente_pkey PRIMARY KEY (contato_cliente_id)
);

-- Dia 06/06/2017
ALTER TABLE ponto.tb_paciente ADD COLUMN whatsapp character varying(15);

-- Dia 08/06/2017
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN sala_preparo boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN sala_preparo boolean DEFAULT false;

-- Dia 09/06/2017
CREATE TABLE ponto.tb_empresas_acesso_servidores
(
  empresas_acesso_externo_id serial NOT NULL,
  ip_externo character varying(500),
  CONSTRAINT tb_empresas_acesso_servidores_pkey PRIMARY KEY (empresas_acesso_externo_id)
);
ALTER TABLE ponto.tb_empresas_acesso_servidores ADD COLUMN nome_clinica character varying(500);



-- Dia 13/06/2017

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN desconto_ajuste1 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN desconto_ajuste2 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN desconto_ajuste3 numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN desconto_ajuste4 numeric(10,2);

-- Dia 16/06/2017
ALTER TABLE ponto.tb_exame_sala ADD COLUMN grupo character varying(100);

-- Dia 21/06/2017


ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_promotor numeric(10,2);
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_promotor boolean DEFAULT false;


ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN valor_promotor numeric(10,2);
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN percentual_promotor boolean DEFAULT false;

-- Dia 22/06/2017

CREATE TABLE ponto.tb_procedimento_percentual_promotor
(
  procedimento_percentual_promotor_id serial,
  procedimento_tuss_id integer,
  promotor integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_percentual_promotor_pkey PRIMARY KEY (procedimento_percentual_promotor_id )
);


CREATE TABLE ponto.tb_procedimento_percentual_promotor_convenio
(
  procedimento_percentual_promotor_convenio_id serial,
  procedimento_percentual_promotor_id integer,
  promotor integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_percentual_promotor_convenio_pkey PRIMARY KEY (procedimento_percentual_promotor_convenio_id )
);

-- Dia 05/07/2017

CREATE TABLE ponto.tb_empresa_impressao
(
  empresa_impressao_id serial NOT NULL,

  cabecalho text,
  rodape text,
  paciente boolean DEFAULT false,
  procedimento boolean DEFAULT false,
  convenio boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_pkey PRIMARY KEY (empresa_impressao_id)
);

-- Dia 10/07/2017

CREATE TABLE ponto.tb_paciente_credito
(
  paciente_credito_id serial NOT NULL,
  paciente_id integer,
  agenda_exames_id integer,
  procedimento_convenio_id integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_credito_pkey PRIMARY KEY (paciente_credito_id)
);

ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN alergias character varying(40000);
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN cirurgias character varying(40000);

ALTER TABLE ponto.tb_empresa ADD COLUMN imagem boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN consulta boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN especialidade boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN geral boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN faturamento boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN estoque boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN financeiro boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN marketing boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN laboratorio boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN ponto boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN calendario boolean DEFAULT false;


INSERT INTO ponto.tb_forma_pagamento(forma_pagamento_id, nome, cartao)
    VALUES (1000, 'CREDITO', 'f');

SELECT setval('ponto.tb_forma_pagamento_forma_pagamento_id_seq', 1001);
 
-- Dia 11/07/2017
ALTER TABLE ponto.tb_ambulatorio_laudo ADD COLUMN email_enviado boolean DEFAULT false;

CREATE TABLE ponto.tb_empresa_lembretes
(
  empresa_lembretes_id serial NOT NULL,
  texto character varying(10000),
  perfil_destino integer,
  operador_destino integer,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_lembretes_pkey PRIMARY KEY (empresa_lembretes_id)
);

CREATE TABLE ponto.tb_empresa_lembretes_visualizacao
(
  empresa_lembretes_visualizacao_id serial NOT NULL,
  empresa_id integer,
  empresa_lembretes_id integer,
  operador_visualizacao integer,
  data_visualizacao timestamp without time zone,
  CONSTRAINT tb_empresa_lembretes_visualizacao_pkey PRIMARY KEY (empresa_lembretes_visualizacao_id)
);

-- Dia 13/07/2017

ALTER TABLE ponto.tb_operador ADD COLUMN taxa_administracao numeric DEFAULT 0.00;
ALTER TABLE ponto.tb_empresa_email_verificacao ADD COLUMN empresa_id integer;

ALTER TABLE ponto.tb_empresa ALTER COLUMN email_mensagem_confirmacao TYPE text;
ALTER TABLE ponto.tb_empresa ALTER COLUMN email_mensagem_agradecimento TYPE text;
ALTER TABLE ponto.tb_empresa ADD COLUMN email_mensagem_falta text;

-- Dia 18/07/2017
 
ALTER TABLE ponto.tb_entradas ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_financeiro_contaspagar ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_financeiro_contasreceber ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_saidas ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_saldo ADD COLUMN empresa_id integer;

ALTER TABLE ponto.tb_exame_sala ADD COLUMN painel_id integer;


-- 25/07/2017

CREATE TABLE ponto.tb_exame_sala_grupo
(
  exame_sala_grupo_id serial NOT NULL,
  exame_sala_id integer,
  grupo character varying(100),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_exame_sala_grupo_pkey PRIMARY KEY (exame_sala_grupo_id)
);

ALTER TABLE ponto.tb_empresa ADD COLUMN botao_faturar_guia boolean DEFAULT true;
ALTER TABLE ponto.tb_empresa ADD COLUMN botao_faturar_procedimento boolean DEFAULT true;
ALTER TABLE ponto.tb_operador ADD COLUMN solicitante boolean DEFAULT false;

UPDATE ponto.tb_operador
   SET solicitante='t'
 WHERE email IS NULL and ativo = 't';

-- 26/07/2017



UPDATE ponto.tb_entradas e
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE e.empresa_id is null;



UPDATE ponto.tb_financeiro_contaspagar e 
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE e.empresa_id is null;


UPDATE ponto.tb_financeiro_contasreceber e
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE e.empresa_id is null;


UPDATE ponto.tb_saidas e 
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE e.empresa_id is null;



UPDATE ponto.tb_saldo e
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE e.empresa_id is null;


-- Dia 03/08/17

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN data_faturar date;

UPDATE ponto.tb_agenda_exames
SET data_faturar = data
WHERE data_faturar is null;
-- Dia 03/08/2017

INSERT INTO ponto.tb_perfil(
            perfil_id, nome, ativo)
    VALUES (15, 'TECNICO RECEPCAO', true);

-- Dia 09/08/2017
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN sms_enviado boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa_sms ADD COLUMN numero_indentificacao_sms integer;
   

-- Dia 10/08/17

UPDATE ponto.tb_procedimento_tuss
   SET qtde=1 
 WHERE qtde=0;

CREATE TABLE ponto.tb_empresas_indentificacao_sms
(
  empresas_indentificacao_sms_id serial NOT NULL,
  nome_empresa character varying(100),
  numero_indentificacao integer,
  CONSTRAINT tb_empresas_indentificacao_sms_pkey PRIMARY KEY (empresas_indentificacao_sms_id)
);

INSERT INTO ponto.tb_empresas_indentificacao_sms(nome_empresa, numero_indentificacao)
    VALUES ('TOPSAUDE', 1), ('CITYCOR', 2);


-- Dia 14/08/17

ALTER TABLE ponto.tb_empresa ADD COLUMN chamar_consulta boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN procedimento_multiempresa boolean DEFAULT false;
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN empresa_id integer;
ALTER TABLE ponto.tb_procedimento_convenio_antigo ADD COLUMN empresa_id integer;

-- Dia 21/08/17

CREATE TABLE ponto.tb_empresa_impressao_cabecalho
(
  empresa_impressao_id serial NOT NULL,

  cabecalho text,
  rodape text,
  paciente boolean DEFAULT false,
  procedimento boolean DEFAULT false,
  convenio boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_pkey PRIMARY KEY (empresa_impressao_id)
);


-- INSERE AQUI O GRUPO MATERIAL. NO CASO ELE NAO EXISTE NA PROIMAGEM
DELETE FROM ponto.tb_ambulatorio_grupo
WHERE tipo ='MATERIAL';

  INSERT INTO ponto.tb_ambulatorio_grupo (nome, tipo)
  VALUES ('MATERIAL', 'MATERIAL');
    
-- ATUALIZA O TUSS E O GRUPO ONDE FOR MAT/MED PRA MATERIAL
  UPDATE ponto.tb_procedimento_tuss
  SET grupo='MATERIAL'
  WHERE grupo = 'MAT/MED';

  UPDATE ponto.tb_ambulatorio_grupo
  SET nome= 'MATERIAL', tipo= 'MATERIAL'
  WHERE nome = 'MAT/MED';

-- INSERE AQUI O MEDICAMENTO. PRIMEIRO APAGO O MEDICAMENTO E INSIRO NOVAMENTE
DELETE FROM ponto.tb_ambulatorio_grupo
WHERE tipo ='MEDICAMENTO';

INSERT INTO ponto.tb_ambulatorio_grupo (nome, tipo)
VALUES ('MEDICAMENTO', 'MEDICAMENTO');



ALTER TABLE ponto.tb_tuss ADD COLUMN valor_bri numeric(10,2);
ALTER TABLE ponto.tb_tuss ADD COLUMN grupo_matmed character varying(100);

-- 23/08/2017

ALTER TABLE ponto.tb_procedimento_tuss ALTER COLUMN nome TYPE character varying(500);

-- 24/08/2017

UPDATE ponto.tb_procedimento_convenio pc
   SET  empresa_id=empresa.empresa_id
   FROM (SELECT empresa_id
  FROM ponto.tb_empresa
  ORDER BY empresa_id ASC
  LIMIT 1
) as empresa
WHERE pc.empresa_id is null;


ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN operador_atualizacao integer;
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN data_atualizacao date;
ALTER TABLE ponto.tb_ambulatorio_orcamento_item ADD COLUMN ativo boolean DEFAULT true;




--01/09/2017

ALTER TABLE ponto.tb_empresa ADD COLUMN data_contaspagar boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN medico_laudodigitador boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN guiaconvenio character varying(25);

UPDATE ponto.tb_agenda_exames ae
SET guiaconvenio = g.guiaconvenio
FROM ponto.tb_ambulatorio_guia g
WHERE g.ambulatorio_guia_id = ae.guia_id
AND ae.guiaconvenio is null
AND ae.guia_id is not null
AND ae.paciente_id is not null;

CREATE TABLE ponto.tb_horarioagenda_editada
(
  horarioagenda_editada_id serial NOT NULL,
  agenda_id integer NOT NULL,
  dia character varying(20),
  horaentrada1 time without time zone,
  horasaida1 time without time zone,
  intervaloinicio time without time zone,
  intervalofim time without time zone,
  tempoconsulta integer,
  qtdeconsulta integer,
  empresa_id integer,
  nome character varying(50),
  medico_id integer,
  observacoes character varying(1000),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_horarioagenda_editada_pkey PRIMARY KEY (horarioagenda_editada_id)
);


-- 02/09/2017

INSERT INTO ponto.tb_perfil(
            perfil_id, nome, ativo)
    VALUES (16, 'ASSISTENTE DE FATURAMENTO', true);

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN agenda_editada boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN horarioagenda_editada_id integer;
ALTER TABLE ponto.tb_horarioagenda_editada ADD COLUMN ativo boolean NOT NULL DEFAULT true;
ALTER TABLE ponto.tb_horarioagenda_editada ADD COLUMN consolidado boolean NOT NULL DEFAULT false;

--02/09/2017
DROP TABLE ponto.tb_empresa_impressao;

CREATE TABLE ponto.tb_empresa_impressao_cabecalho
(
  empresa_impressao_cabecalho_id serial NOT NULL,

  cabecalho text,
  rodape text,
  paciente boolean DEFAULT false,
  procedimento boolean DEFAULT false,
  convenio boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_cabecalho_pkey PRIMARY KEY (empresa_impressao_cabecalho_id)
);

CREATE TABLE ponto.tb_empresa_impressao_cabecalho
(
  empresa_impressao_cabecalho_id serial NOT NULL,

  cabecalho text,
  rodape text,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_cabecalho_pkey PRIMARY KEY (empresa_impressao_cabecalho_id)
);



CREATE TABLE ponto.tb_empresa_impressao_recibo
(
  empresa_impressao_recibo_id serial NOT NULL,
  texto text,
  nome text,
  cabecalho boolean DEFAULT false,
  rodape boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_recibo_pkey PRIMARY KEY (empresa_impressao_recibo_id)
);

CREATE TABLE ponto.tb_empresa_impressao_ficha
(
  empresa_impressao_ficha_id serial NOT NULL,
  texto text,
  nome text,
  cabecalho boolean DEFAULT false,
  rodape boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_ficha_pkey PRIMARY KEY (empresa_impressao_ficha_id)
);


CREATE TABLE ponto.tb_empresa_impressao_laudo
(
  empresa_impressao_laudo_id serial NOT NULL,
  texto text,
  nome text,
  cabecalho boolean DEFAULT false,
  rodape boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_laudo_pkey PRIMARY KEY (empresa_impressao_laudo_id)
);

UPDATE ponto.tb_procedimento_tuss
   SET qtde=1
 WHERE qtde = 0;


-- 08/09/2017

ALTER TABLE ponto.tb_empresa ADD COLUMN cabecalho_config boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN rodape_config boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN laudo_config boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN recibo_config boolean DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN ficha_config boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN odontologia boolean DEFAULT false;
ALTER TABLE ponto.tb_agenda_exames ADD COLUMN sala_pendente boolean NOT NULL DEFAULT false;

-- Dia 09/08/2017
ALTER TABLE ponto.tb_procedimento_percentual_medico_convenio ADD COLUMN dia_recebimento integer;
ALTER TABLE ponto.tb_procedimento_percentual_medico_convenio ADD COLUMN tempo_recebimento integer;

-- Dia 11/09/2017
ALTER TABLE ponto.tb_empresa ADD COLUMN producao_medica_saida boolean DEFAULT false;


-- Dia 12/09/2017
CREATE TABLE ponto.tb_empresa_permissoes
(
  empresa_permissoes_id serial NOT NULL,
  empresa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  procedimento_excecao boolean DEFAULT false,
  CONSTRAINT tb_empresa_permissoes_pkey PRIMARY KEY (empresa_permissoes_id)
);

INSERT INTO ponto.tb_empresa_permissoes(empresa_id, procedimento_excecao)
SELECT empresa_id, 'f' FROM ponto.tb_empresa
WHERE empresa_id NOT IN ( SELECT empresa_id FROM ponto.tb_empresa_permissoes );

-- Dia 16/09/2017
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN forma_pagamento_id integer;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN data date;
 
-- Dia 19/09/2017
--UPDATE ponto.tb_procedimento_tuss
 --  SET grupo = 'ODONTOLOGIA'
 --WHERE grupo ='TOMOGRAFIA';


-- UPDATE ponto.tb_procedimento_tuss
--   SET qtde=1 
-- WHERE qtde is null;

--INSERT INTO ponto.tb_ambulatorio_grupo(nome, tipo)
--    VALUES ('ODONTOLOGIA', 'ESPECIALIDADE');
ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN ordem_chegada boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente_credito ADD COLUMN empresa_id integer;