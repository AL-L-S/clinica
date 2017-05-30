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
# COPIAR A SEGUIR SEM AS ASPAS E EXECUTAR 'sudo apt-get install php5-curl -y && sudo service apache2 restart'


-- 23/05/2017 TORNANDO MAIS FÁCIL A CRIAÇÃO DE AGENDA

ALTER TABLE ponto.tb_agenda_exames ADD COLUMN horario_id integer;


-- Dia 25/05/2017
ALTER TABLE ponto.tb_agrupador_procedimento_nome ADD COLUMN convenio_id integer;



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


